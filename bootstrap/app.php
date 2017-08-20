<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new class extends DI\Bridge\Slim\App {
    protected function configureContainer(DI\ContainerBuilder $builder)
    {
        $builder->addDefinitions(__DIR__ . '/config.php');
    }
};

$app->get('/', [App\Http\Controller\HomeController::class, 'index']);

return $app;