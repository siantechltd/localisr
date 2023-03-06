<?php

namespace Siantech\Localisr\Service;

use Siantech\Localisr\Core\LocalisrException;
use Siantech\Localisr\Models\Key;
use Siantech\Localisr\Models\KeyTranslation;

class KeysServices extends AbstractService
{
    public function all(){
        $path = $this->client->getLanguage();

        try {
            $response = $this->request('GET', $path);

            return $response['translations'];

        } catch (LocalisrException $e) {
            throw $e;
        }
    }

    public function getOne($slug){

        try {
            $response = $this->request('GET', "keys/{$slug}");

            $key = new Key();
            $key->setSlug($response['key']['slug']);
            $key->setId($response['key']['uuid']);

            return $key;

        } catch (LocalisrException $e) {
            throw $e;
        }
    }

    public function getTranslation(Key $key){

        $path = "keys/translations/{$this->client->getLanguage()}/{$key->getSlug()}";

        try {
            $response = $this->request('GET', $path);

            return $response['translations'][0] ?? null;

        } catch (LocalisrException $e) {
            throw $e;
        }
    }

    public function saveTranslation(KeyTranslation $keyTranslation){
        $params = [
            'language' => $this->client->getLanguage(),
            'key_uuid' => $keyTranslation->getKeyId() ?? null,
            'translation' => $keyTranslation->getTranslation(),
        ];

        $response = $this->request('POST', "keys/translations/{$this->client->getLanguage()}/{$keyTranslation->getKeyId()}", $params);

        return $response;
    }


}
