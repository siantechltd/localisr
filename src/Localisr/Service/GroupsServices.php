<?php

namespace Siantech\Localisr\Service;

class GroupsServices extends AbstractService
{
    public function getGroupKeysTranslations($group)
    {
        $path = "groups/translations/{$this->client->getLanguage()}/{$group}";

        return $this->request('GET', $path);
    }
}
