<?php

use Slim\App;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Slim\Factory\AppFactory;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use UMA\DIC\Container;
use Yuyui\Interlopertracker\Controllers\ServerInfoController;
use Yuyui\Interlopertracker\Jobs\GrabServerInfoJob;

require_once __DIR__ . "/vendor/autoload.php";

$container = new Container(require __DIR__ . '/settings.php');

$container->set(App::class, static function (Container $c): App {
    /** @var array $settings */
    $settings = $c->get('settings');

    $app = AppFactory::create(null, $c);

    $app->addErrorMiddleware(
        $settings['slim']['displayErrorDetails'],
        $settings['slim']['logErrors'],
        $settings['slim']['logErrorDetails']
    );

    return $app;
});

$container->set(EntityManager::class, static function (Container $c): EntityManager{
    $settings = $c->get('settings');
    $cache = $settings['doctrine']['dev_mode'] ? new ArrayAdapter() : new FilesystemAdapter(directory: $settings['doctrine']['cache_dir']);

    $config = ORMSetup::createAttributeMetadataConfiguration(
        $settings['doctrine']['metadata_dirs'],
        $settings['doctrine']['dev_mode'],
        null,
        $cache
    );

    $connection = DriverManager::getConnection($settings['doctrine']['connection']);

    return new EntityManager($connection, $config);
});

$container->set(GrabServerInfoJob::class, static function (Container $c){
    return new GrabServerInfoJob($c->get(EntityManager::class));
});

$container->set(ServerInfoController::class, static function (Container $c){
    return new ServerInfoController($c->get(EntityManager::class));
});

return $container;