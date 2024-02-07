<?php

namespace Siantech\Localisr;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Siantech\Localisr\Core\LocalisrException;

abstract class LocalisrClientBase implements LocalisrClientInterface
{
    /**
     * BASE_URL is "https://localisr.com/v1"
     *
     * You may modify this value to disable SSL support, but it is not recommended.
     *
     * @var string
     */
    public static $BASE_URL = "https://api.localisr.com/v1/";
//    public static $BASE_URL = "http://localisr.test/v1/";

    /**
     * VERIFY_SSL is defaulted to "true".
     *
     * In some PHP configurations, SSL/TLS certificates cannot be verified.
     * Rather than disabling SSL/TLS entirely in these circumstances, you may
     * disable certificate verification. This is dramatically better than disabling
     * connecting to the Localisr API without TLS, as it's still encrypted,
     * but the risk is that if your connection has been compromised, your application could
     * be subject to a Man-in-the-middle attack. However, this is still a better outcome
     * than using no encryption at all.
     *
     */
    public static $VERIFY_SSL= false;

    protected $authorization_header = "X-Localisr-Authorization-Token";
    protected $authorization_token = NULL;

    protected $project_header = "X-Localisr-Project-Token";
    protected $project_token = NULL;

    protected $language = NULL;

    /** @var  Client */
    protected $client;

    public function __construct($authorization_token, $project_token, $timeout = 30) {
        $this->authorization_token = $authorization_token;
        $this->project_token = $project_token;
        $this->version = phpversion();
        $this->os = PHP_OS;
        $this->timeout = $timeout;
    }

    public function setLanguage($language): static
    {
        $this->language = $language;
        return $this;
    }

    public function getLanguage(){
        return $this->language;
    }

    /**
     * Return the injected GuzzleHttp\Client or create a default instance
     * @return Client
     */
    public function getClient() {
        if(!$this->client) {
            $this->client = new Client([
                RequestOptions::VERIFY  => self::$VERIFY_SSL,
                RequestOptions::TIMEOUT => $this->timeout,
            ]);
        }
        return $this->client;
    }

    public function request($method = NULL, $path = NULL, $params = [], $opts = []) {
        $client = $this->getClient();

        $options = [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'User-Agent' => "Localisr-PHP (PHP Version:{$this->version}, OS:{$this->os})",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                $this->authorization_header => $this->authorization_token,
                $this->project_header => $this->project_token,
            ],
        ];

        if(!empty($params)) {

            $cleanParams = array_filter($params, function($value) {
                return $value !== null;
            });

            switch ($method) {
                case 'GET':
                case 'HEAD':
                case 'DELETE':
                case 'OPTIONS':
                    $options[RequestOptions::QUERY] = $cleanParams;
                    break;
                case 'PUT':
                case 'POST':
                case 'PATCH':
                    $options[RequestOptions::JSON] = $cleanParams;
                    break;
            }
        }


        $response = $client->request($method, self::$BASE_URL . $path, $options);


        switch ($response->getStatusCode()) {
            case 200:
                // Casting BIGINT as STRING instead of the default FLOAT, to avoid loss of precision.

                return json_decode($response->getBody(), true, 512, JSON_BIGINT_AS_STRING);
            case 401:
                $ex = new LocalisrException();
                $ex->message = 'Unauthorized: Missing or incorrect API token in header. ' .
                    'Please verify that you used the correct token when you constructed your client.';
                $ex->httpStatusCode = 401;
                throw $ex;
            case 500:
                $ex = new LocalisrException();
                $ex->httpStatusCode = 500;
                $ex->message = 'Internal Server Error: This is an issue with Localisr’s servers processing your request. ' .
                    'In most cases the message is lost during the process, ' .
                    'and Localisr is notified so that we can investigate the issue.';
                $ex->message .= "\n" . $response->getBody();
                throw $ex;
            case 503:
                $ex = new LocalisrException();
                $ex->httpStatusCode = 503;
                $ex->message = 'The Localisr API is currently unavailable, please try your request later.';
                throw $ex;
            // This should cover case 422, and any others that are possible:
            default:
                $ex = new LocalisrException();
                $body = json_decode($response->getBody(), true);
                $ex->httpStatusCode = $response->getStatusCode();
                $ex->localisrApiErrorCode = $response->getStatusCode();
                $ex->message = $body['message'] ?? '';
                throw $ex;
        }

    }
}
