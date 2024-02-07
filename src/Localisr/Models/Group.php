<?php

namespace Siantech\Localisr\Models;

class Group
{
    private $id;
    private $reference;
    private $name;
    private $slug;
    private $info;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference): static
    {
        $this->reference = $reference;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setInfo($info): static
    {
        $this->info = $info;
        return $this;
    }
}
