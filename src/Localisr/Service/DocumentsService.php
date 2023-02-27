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

        return $this->request('POST', 'document', $params, []);
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

        return $this->request('PATCH', 'document/' . $document->getId(), $params, []);
    }

    /**
     * @throws LocalisrException
     */
    public function getOneByReference($reference): Document
    {
        $params = [
            'reference' => $reference
        ];

        try {
            $response = $this->request('GET', 'document/getOneByReference', $params);

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
     * Get a Document by it's Localisr id
     *
     * @throws LocalisrException
     */
    public function getOne($id): Document
    {
        $params = [
            'uuid' => $id
        ];

        try {
            $response = $this->request('GET', 'document', $params);

            $document = new Document();
            $document->setId($response['document']['uuid']);
            $document->setName($response['document']['name']);
            $document->setReference($response['document']['external_reference']);

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
        $params = [
            'reference' => $reference
        ];

        return $this->request('DELETE', 'document', $params);
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
    public function getDocumentTranslation($reference)
    {
        $params = [
            'document_uuid' => $reference,
            'language' => $this->client->getLanguage() ?? null
        ];

        $response = $this->request('GET', 'document/translation', $params);

        $translation = $response['translation'];

        $documentTranslation = new DocumentTranslation();
        if ($translation) {
            $documentTranslation->setLanguage($this->client->getLanguage());
            $documentTranslation->setId($response['translation']['uuid']);
            $documentTranslation->setTitle($response['translation']['title']);
            $documentTranslation->setSlug($response['translation']['slug']);
            $documentTranslation->setHeadline($response['translation']['headline'] ?? null);
            $documentTranslation->setBody($response['translation']['body']);
            $documentTranslation->setKeywords($response['translation']['keywords']);
            $documentTranslation->setMetaDescription($response['translation']['meta_description']);
        }

        return $documentTranslation;
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

        $response = $this->request('POST', 'document/translation', $params);
    }
}
