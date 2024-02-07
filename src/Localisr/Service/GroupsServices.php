<?php

namespace Siantech\Localisr\Service;

use Siantech\Localisr\Models\Group;
use Siantech\Localisr\Models\Key;

class GroupsServices extends AbstractService
{
    /**
     * Save group
     * @param Group $group
     * @return mixed
     */
    public function saveOne(Group $group): mixed
    {
        $params = [
            'reference' => $group->getReference(),
            'name' => $group->getName(),
            'info' => $group->getInfo()
        ];

        return $this->request('POST', 'groups', $params, []);
    }

    /**
     * Get translations for all the keys in the specified group
     * @param $group
     * @return mixed
     */
    public function getGroupKeysTranslations(string $group): mixed
    {
        $path = "groups/translations/{$this->client->getLanguage()}/{$group}";

        return $this->request('GET', $path);
    }
}
