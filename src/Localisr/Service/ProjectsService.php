<?php

namespace Siantech\Localisr\Service;

class ProjectsService extends AbstractService
{
    /**
     * Get languages defined in Localisr platform for the selected project.
     * By default, it will return only enabled / active languages. If you want to get all the languages,
     * set devMode parameter to true
     *
     * @param bool $devMode - if true, it will also return disabled languages attached to your project
     * @return mixed
     */
    public function getAssignedLanguages(bool $devMode = false): mixed
    {
        $params = [
            'devMode' => $devMode
        ];

        $response = $this->request('GET', 'languages', $params);

        return $response['languages'];
    }
}
