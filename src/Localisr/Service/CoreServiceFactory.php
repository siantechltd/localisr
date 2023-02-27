<?php

namespace Siantech\Localisr\Service;

class CoreServiceFactory extends AbstractServiceFactory
{

    private static $classMap = [
        'documents' => DocumentsService::class,
        'groups' => GroupsServices::class,
        'keys' => KeysServices::class,
        'projects' => ProjectsService::class,
    ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
