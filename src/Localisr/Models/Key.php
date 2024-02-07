<?php

namespace Siantech\Localisr\Models;

class Key
{
    private $id;
    private $reference;
    private $label;
    private $slug;
    private $info;
    private $type = 'string';

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference(string $reference)
    {
        $this->reference = $reference;
        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    public function setSlug($slug){
        $this->slug = $slug;
        return $this;
    }

    public function getSlug(){
        return $this->slug;
    }

    public function setInfo(string $info)
    {
        $this->info = $info;
        return $this;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }
}
