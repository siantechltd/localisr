<?php

namespace Siantech\Localisr;

use Siantech\Localisr\Service\CoreServiceFactory;
use Siantech\Localisr\Service\DocumentsService;
use Siantech\Localisr\Service\GroupsServices;
use Siantech\Localisr\Service\KeysServices;
use Siantech\Localisr\Service\ProjectsService;

/**
 * @property DocumentsService $documents
 * @property GroupsServices $groups
 * @property KeysServices $keys
 * @property ProjectsService $projects
 */
class LocalisrClient extends LocalisrClientBase
{

    protected $coreServiceFactory;

    public function __get($name)
    {
        if (null === $this->coreServiceFactory) {
            $this->coreServiceFactory = new CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->__get($name);
    }
}
