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

    public function getOne($code){

        $params = [
            'code' => $code
        ];

        try {
            $response = $this->request('GET', 'key/getOneByCode', $params);

            $key = new Key();
            $key->setCode($response['key']['slug']);
            $key->setId($response['key']['uuid']);

            return $key;

        } catch (LocalisrException $e) {
            throw $e;
        }
    }

    public function getTranslation(Key $key){

        $path = $this->client->getLanguage() . '?key=' . $key->getCode();

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

        $response = $this->request('POST', 'key/translation', $params);
    }


}
