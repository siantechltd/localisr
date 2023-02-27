<?php

namespace Siantech\Localisr\Service;

use Siantech\Localisr\LocalisrClientInterface;

abstract class AbstractService
{
    protected $client;
    protected $language;

    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Gets the client used by this service to send requests.
     *
     * @return LocalisrClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    public function getLanguage(){
        return $this->client->language;
    }

    protected function request($method, $path, $params = [], $opts = []){
        return $this->getClient()->request($method, $path, static::formatParams($params), $opts);
    }

    /**
     * Translate null values to empty strings. For service methods,
     * we interpret null as a request to unset the field, which
     * corresponds to sending an empty string for the field to the
     * API.
     *
     * @param null|array $params
     */
    private static function formatParams($params)
    {
        if (null === $params) {
            return null;
        }
        \array_walk_recursive($params, function (&$value, $key) {
            if (null === $value) {
                $value = '';
            }
        });

        return $params;
    }
}
