<?php

namespace Siantech\Localisr\Service;

class GroupsServices extends AbstractService
{
    public function getGroupKeysTranslations($group)
    {
        $path = $this->client->getLanguage() . '?group=' . $group;

        return $this->request('GET', $path);
    }
}
