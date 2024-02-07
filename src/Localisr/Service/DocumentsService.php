<?php

namespace Siantech\Localisr\Service;

use Siantech\Localisr\Core\LocalisrException;
use Siantech\Localisr\Models\Document;
use Siantech\Localisr\Models\DocumentTranslation;

class DocumentsService extends AbstractService
{
    public function all($params = null, $opts = null)
    {
        $response = $this->request('GET', 'documents', $params, $opts);
        $documents = [];

        foreach ($response['documents'] as $doc) {
            $document = new Document();
            $document->setName($doc['name']);
            $document->setReference($doc['internal_ref']);

            $documents[] = $document;
        }
        return $documents;
    }

    /**
     * @param $document Localisr Models
     * @return mixed
     */
    public function save(Document $document)
    {
        $params = [
            'reference' => $document->getReference(),
            'name' => $document->getName()
        ];

        return $this->request('POST', 'documents', $params, []);
    }

    /**
     * @param $document Localisr Models
     * @return mixed
     */
    public function updateOne(Document $document)
    {
        $params = [
            'reference' => $document->getReference(),
            'name' => $document->getName()
        ];

        return $this->request('PATCH', 'documents/' . $document->getId(), $params, []);
    }

    /**
     * @throws LocalisrException
     */
    public function getOne($reference): Document
    {
        try {
            $response = $this->request('GET', 'documents/' . $reference);

            $document = new Document();
            $document->setId($response['document']['uuid']);
            $document->setName($response['document']['name']);
            $document->setReference($reference);

            return $document;
        } catch (LocalisrException $e) {
            throw $e;
        }
    }

    /**
     * @param $reference
     * @return void
     * @throws LocalisrException
     */
    public function deleteOne($reference)
    {
        return $this->request('DELETE', "documents/{$reference}");
    }

    /**
     * Get translations for a document.
     * If language is specified, it will return the translation for that language - if exists.
     * If language is not associated with the project, it will return the translation in the default language.
     *
     * @param $reference
     * @return void
     * @throws Core\LocalisrException
     */
    public function getDocumentTranslation($reference): ?DocumentTranslation
    {
        $response = $this->request('GET', "documents/translations/{$this->client->getLanguage()}/{$reference}");

        $translation = $response['translation'] ?? null;

        if ($translation) {
            $documentTranslation = new DocumentTranslation();
            $documentTranslation->setLanguage($this->client->getLanguage());
            $documentTranslation->setId($translation['uuid']);
            $documentTranslation->setTitle($translation['title']);
            $documentTranslation->setSlug($translation['slug']);
            $documentTranslation->setHeadline($translation['headline'] ?? null);
            $documentTranslation->setBody($translation['body']);
            $documentTranslation->setKeywords($translation['keywords']);
            $documentTranslation->setMetaDescription($translation['meta_description']);

            return $documentTranslation;
        }

        return null;
    }

    public function saveDocumentTranslation(DocumentTranslation $documentTranslation)
    {
        $params = [
            'language' => $this->client->getLanguage(),
            'translation_uuid' => $documentTranslation->getId() ?? null,
            'document_id' => $documentTranslation->getParentId(),
            'title' => $documentTranslation->getTitle(),
            'slug' => $documentTranslation->getSlug(),
            'headline' => $documentTranslation->getHeadline(),
            'body' => $documentTranslation->getBody(),
            'tags' => $documentTranslation->getTags(),
            'keywords' => $documentTranslation->getKeywords(),
//            'metaDescription' => $documentTranslation->getMetaDescription()
        ];

        $response = $this->request('POST', "documents/translations/{$this->client->getLanguage()}/{$documentTranslation->getParentId()}", $params);
    }
}
