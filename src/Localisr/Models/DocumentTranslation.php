<?php

namespace Siantech\Localisr\Models;

class DocumentTranslation
{
    private $id;
    private $parentId;
    private $language;
    private $title;
    private $slug;
    private $headline;
    private $body;
    private $tags;
    private $keywords;
    private $metaDescription;

    public function setId($id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLanguage($language): static
    {
        $this->language = $language;
        return $this;
    }

    public function setParentId($id)
    {
        $this->parentId = $id;
        return $this;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setHeadline($headline)
    {
        $this->headline = $headline;
        return $this;
    }

    public function getHeadline()
    {
        return $this->headline;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setMetaDescription($description)
    {
        $this->metaDescription = $description;
        return $this;
    }

    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    public function __toArray()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'headline' => $this->getHeadline(),
            'body' => $this->getBody(),
            'keywords' => $this->getKeywords(),
            'metaDescription' => $this->getMetaDescription()
        ];
    }
}
