<?php

namespace Siantech\Localisr;

interface LocalisrClientInterface
{
    public function request($method, $path, $params, $opts);
}
