<?php

namespace {{ cookiecutter.php_namespace }}\Api\Traits;

use WP_REST_Request;
use WP_REST_Response;

if (!defined('ABSPATH')) exit;

/**
 * Common helpers for REST controllers: nonce verification, standard responses.
 */
trait ControllerHelpers
{
    /**
     * Verify REST nonce (X-WP-Nonce header or _wpnonce param). For GET/HEAD/OPTIONS, allows cookie auth when logged in.
     */
    public function verify_nonce(WP_REST_Request $request): bool
    {
        $nonce = $request->get_header('X-WP-Nonce');
        if ($nonce === null || $nonce === '') {
            $nonce = $request->get_param('_wpnonce');
            if (is_string($nonce)) {
                $nonce = sanitize_text_field($nonce);
            }
        }
        if ($nonce && wp_verify_nonce($nonce, 'wp_rest')) {
            return true;
        }
        $method = $request->get_method();
        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'], true) && is_user_logged_in()) {
            return true;
        }
        return false;
    }

    /** Standard error response: { "success": false, "message": "", "data": {} } */
    protected function error_response(string $message, int $status_code = 500, array $data = []): WP_REST_Response
    {
        return new WP_REST_Response([
            'success' => false,
            'message' => esc_html($message),
            'data'    => $data,
        ], $status_code);
    }

    /** Standard success response: { "success": true, "data": {}, "message": "" } */
    protected function success_response($data, int $status_code = 200, string $message = ''): WP_REST_Response
    {
        return new WP_REST_Response([
            'success' => true,
            'data'    => $data,
            'message' => $message ? esc_html($message) : '',
        ], $status_code);
    }

    /** Log exception and return error response. */
    protected function handle_exception(\Throwable $e, string $action): WP_REST_Response
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log(sprintf('%s [%s]: %s in %s:%d', __CLASS__, $action, $e->getMessage(), $e->getFile(), $e->getLine()));
        }
        return $this->error_response('An error occurred while ' . $action . '. Please try again.', 500);
    }
}
