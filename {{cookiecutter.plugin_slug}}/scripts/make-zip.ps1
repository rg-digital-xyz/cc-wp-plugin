# WordPress plugin ZIP script (forward-slash paths for WordPress compatibility)
# Run from plugin root: powershell -ExecutionPolicy Bypass -File scripts/make-zip.ps1

param(
    [switch]$SkipComposer = $false,
    [switch]$NoPause = $false
)

$ErrorActionPreference = "Stop"

$RootDir = Resolve-Path (Join-Path $PSScriptRoot "..")
$PluginName = (Get-Item $RootDir).Name
$DistFolder = Join-Path $RootDir "dist"
$ReleaseFolder = Join-Path $DistFolder $PluginName
$ZipFile = Join-Path $RootDir "$PluginName.zip"

Write-Host "`n=== Build & Zip: $PluginName ===" -ForegroundColor Cyan
Write-Host "Plugin Root: $RootDir" -ForegroundColor Gray

# Composer
if (-not $SkipComposer) {
    Write-Host "`n--- Composer ---" -ForegroundColor Cyan
    $autoloadPath = Join-Path $RootDir "vendor\autoload.php"
    if (-not (Test-Path $autoloadPath)) {
        Write-Host "Running composer install..." -ForegroundColor Yellow
        Push-Location $RootDir
        try {
            composer install --no-dev --optimize-autoloader
            if ($LASTEXITCODE -ne 0) { throw "Composer install failed." }
        } finally { Pop-Location }
    } else {
        Write-Host "Vendor found." -ForegroundColor Green
    }
} else {
    Write-Host "Skipping composer (--SkipComposer)." -ForegroundColor Yellow
}

# Clean
Write-Host "`n--- Cleaning ---" -ForegroundColor Cyan
if (Test-Path $DistFolder) { Remove-Item -Path $DistFolder -Recurse -Force -ErrorAction SilentlyContinue }
if (Test-Path $ZipFile) { Remove-Item -Path $ZipFile -Force -ErrorAction SilentlyContinue }
Start-Sleep -Milliseconds 500
New-Item -ItemType Directory -Path $ReleaseFolder -Force | Out-Null

# Copy
Write-Host "`n--- Copying ---" -ForegroundColor Cyan
$RootFiles = @("$PluginName.php", "composer.json", "readme.md", "readme.txt", "uninstall.php")
foreach ($File in $RootFiles) {
    $FilePath = Join-Path $RootDir $File
    if (Test-Path $FilePath) {
        Copy-Item $FilePath $ReleaseFolder -Force
        Write-Host "  [OK] $File" -ForegroundColor DarkGray
    }
}

$VendorPath = Join-Path $RootDir "vendor"
if (-not (Test-Path $VendorPath)) {
    Write-Error "Vendor not found. Run composer install."
    exit 1
}
$VendorDest = Join-Path $ReleaseFolder "vendor"
robocopy $VendorPath $VendorDest /S /E /NFL /NDL /NJH /NJS /nc /ns /np /R:3 /W:1 | Out-Null
if ($LASTEXITCODE -gt 1) { Write-Error "Vendor copy failed."; exit 1 }
$VendorBin = Join-Path $ReleaseFolder "vendor\bin"
if (Test-Path $VendorBin) { Remove-Item -Path $VendorBin -Recurse -Force -ErrorAction SilentlyContinue }

$SrcPath = Join-Path $RootDir "src"
if (Test-Path $SrcPath) {
    $SrcDest = Join-Path $ReleaseFolder "src"
    robocopy $SrcPath $SrcDest /S /E /XD "Web" /NFL /NDL /NJH /NJS /nc /ns /np /R:3 /W:1 | Out-Null
    Write-Host "  [OK] src (Web excluded)" -ForegroundColor DarkGray
}

# Remove dev files
$ExcludePatterns = @("*.log", "*.map", "composer.lock", "package.json", "pnpm-lock.yaml", "tsconfig*.json", "vite.config.*", "*.vue", "*.ts", "*.tsx", ".eslintrc.*", ".prettierrc.*", ".editorconfig", ".gitignore", ".gitattributes", "README.md", ".DS_Store", "Thumbs.db")
$ExcludeDirs = @("node_modules", ".git", ".vscode", ".idea", "dist", "Web")
foreach ($p in $ExcludePatterns) {
    Get-ChildItem -Path $ReleaseFolder -Include $p -Recurse -File -ErrorAction SilentlyContinue | Remove-Item -Force -ErrorAction SilentlyContinue
}
foreach ($d in $ExcludeDirs) {
    Get-ChildItem -Path $ReleaseFolder -Directory -Filter $d -Recurse -ErrorAction SilentlyContinue | Remove-Item -Recurse -Force -ErrorAction SilentlyContinue
}

# Verify
$MainPhp = Join-Path $ReleaseFolder "$PluginName.php"
$Autoload = Join-Path $ReleaseFolder "vendor\autoload.php"
if (-not (Test-Path $MainPhp) -or -not (Test-Path $Autoload)) {
    Write-Error "Critical files missing ($PluginName.php or vendor/autoload.php)."
    exit 1
}
Write-Host "`n--- Verify ---" -ForegroundColor Cyan
Write-Host "  [OK] $PluginName.php" -ForegroundColor Green
Write-Host "  [OK] vendor/autoload.php" -ForegroundColor Green

# Create ZIP (forward slashes only)
Write-Host "`n--- Creating ZIP ---" -ForegroundColor Cyan
Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem
$DistFolderPath = (Resolve-Path $DistFolder).Path.TrimEnd([System.IO.Path]::DirectorySeparatorChar, [System.IO.Path]::AltDirectorySeparatorChar)
$baseLength = $DistFolderPath.Length + 1

try {
    if (Test-Path $ZipFile) { Remove-Item $ZipFile -Force }
    $zip = [System.IO.Compression.ZipFile]::Open($ZipFile, [System.IO.Compression.ZipArchiveMode]::Create)
    try {
        Get-ChildItem -Path $DistFolder -Recurse -File | ForEach-Object {
            $relativePath = $_.FullName.Substring($baseLength)
            $entryName = $relativePath.Replace('\', '/')
            [void][System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zip, $_.FullName, $entryName, [System.IO.Compression.CompressionLevel]::Optimal)
        }
    } finally { $zip.Dispose() }

    $archive = [System.IO.Compression.ZipFile]::OpenRead($ZipFile)
    try {
        $badEntries = $archive.Entries | Where-Object { $_.FullName -match '\\' }
        if ($badEntries) {
            $archive.Dispose()
            Remove-Item $ZipFile -Force -ErrorAction SilentlyContinue
            Write-Error "ZIP validation failed: backslash in path (WordPress-incompatible): $($badEntries[0].FullName)"
            exit 1
        }
    } finally { $archive.Dispose() }
    Write-Host "  [OK] All paths use forward slashes" -ForegroundColor Green

    $ZipSize = (Get-Item $ZipFile).Length / 1MB
    Write-Host "`n[SUCCESS] $ZipFile ($([math]::Round($ZipSize, 2)) MB)" -ForegroundColor Green
    if (Test-Path $DistFolder) { Remove-Item -Path $DistFolder -Recurse -Force -ErrorAction SilentlyContinue }
} catch {
    Write-Error "ZIP failed: $($_.Exception.Message)"
    exit 1
}

if (-not $NoPause) {
    Write-Host "`nPress any key to close..." -ForegroundColor Gray
    $null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
}
