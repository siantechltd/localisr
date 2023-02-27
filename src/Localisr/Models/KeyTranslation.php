<?php

namespace Siantech\Localisr\Models;

class KeyTranslation
{
    private $id;
    private $keyId;
    private $language;
    private $translation;

    public function setKeyId($keyId): static
    {
        $this->keyId = $keyId;
        return $this;
    }

    public function getKeyId(){
        return $this->keyId;
    }

    public function setLanguage($language): static
    {
        $this->language = $language;
        return $this;
    }

    public function getLanguage(){
        return $this->language;
    }

    public function setTranslation($translation): static
    {
        $this->translation = $translation;
        return $this;
    }

    public function getTranslation(){
        return $this->translation;
    }
}
