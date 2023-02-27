<?php

namespace Siantech\Localisr\Models;

class Document
{
    private $id;
    private $name;
    private $reference;
    private $extraInfo;

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function setReference($reference){
        $this->reference = $reference;
        return $this;
    }

    public function getReference(){
        return $this->reference;
    }

    public function setExtraInfo($info){
        $this->extraInfo = $info;
        return $this;
    }

    public function getExtraInfo($info){
        return $this->extraInfo;
    }
}
