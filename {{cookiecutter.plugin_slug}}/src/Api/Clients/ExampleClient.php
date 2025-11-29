<?php
namespace {{ cookiecutter.php_namespace }}\Api\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

if (!defined('ABSPATH')) exit;

Class ExampleClient
{
    private Client $client;


    /**
     * Constructor
     * @param string|null $token Optional Bearer token for authentication
     */
    public function __construct(?string $token = null)
    {
        if ($token) {
            $config['headers'] = [
                'Authorization' => "Bearer {$token}",
                'Accept'        => 'application/json',
            ];
        }

        $this->client = new Client($config);
    }

    /**
     * Core request handler.
     * Returns either a decoded array.
     * @param string $method HTTP method
     * @param string $endpoint API endpoint
     */
    private function request(string $method, string $endpoint, array $options = []): array {
        try {
            $response = $this->client->request($method, $endpoint, $options);

            $body = (string) $response->getBody();
            return json_decode($body, true) ?? ['raw' => $body];
        } catch (RequestException $e) {
            $status  = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $message = $e->hasResponse()
                ? (string) $e->getResponse()->getBody()
                : $e->getMessage();

            return [
                'error'   => true,
                'status'  => $status,
                'message' => $message,
            ];
        }
    }

    /** GET request **/
    public function get(string $endpoint): array {
        return $this->request('GET', $endpoint);
    }

    /** POST request */
    public function post(string $endpoint, array $data = []): array {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }

    /** PUT request */
    public function put(string $endpoint, array $data = []): array {
        return $this->request('PUT', $endpoint, ['json' => $data]);
    }

    /** DELETE request */
    public function delete(string $endpoint): array {
        return $this->request('DELETE', $endpoint);
    }
}
