<?php

namespace Siantech\Localisr\Models;

class Key
{
    private $id;
    private $code;

    public function setCode($code){
        $this->code = $code;
        return $this;
    }

    public function getCode(){
        return $this->code;
    }

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getId(){
        return $this->id;
    }
}
