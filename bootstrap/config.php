<?php

use function DI\get;
use function DI\object;

return [
    'path.client' => __DIR__ . '/../client/',
    \App\View\Handlebars::class => object(\App\View\Handlebars::class)
        ->constructor(get('path.client')),
];
