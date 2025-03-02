<?php
declare(strict_types=1);
namespace Yuyui\Interlopertracker\Jobs;
require_once("/var/www/bootstrap.php");

use Doctrine\ORM\EntityManager;
use xPaw\SourceQuery\Exception\SocketException;
use xPaw\SourceQuery\SourceQuery;
use Yuyui\Interlopertracker\Domain\Map;
use Yuyui\Interlopertracker\Domain\ServerHistory;
use Yuyui\Interlopertracker\Services\MapServices;

if(! isset($container) ){
    throw new \Exception("Failed to summon container");
}

$entityManager = $container->get(EntityManager::class);

if(! $entityManager instanceof EntityManager){
    throw new \Exception("Failed to summon EntityManager");
}

// @phpstan-ignore while.alwaysTrue
while(true){
    $sourceQuery = new SourceQuery();
    try{
        $sourceQuery->Connect("79.127.217.197", 22912);
    }catch(SocketException){
        $serverHistory = new ServerHistory(
            null,
            false,
            false,
            "Server offline",
            0,
            0
        );
        $entityManager->persist($serverHistory);
        $entityManager->flush();
    }

    $serverInfo = $sourceQuery->GetInfo();

    $map = MapServices::getMapByName($entityManager->getRepository(Map::class), $serverInfo["Map"]);
    if(is_null($map)){
        $map = new Map($serverInfo["Map"]);
        $entityManager->persist($map);
    }

    $serverHistory = new ServerHistory(
        $map,
        true,
        $serverInfo["Password"] == 1,
        $serverInfo["HostName"],
        $serverInfo["MaxPlayers"],
        $serverInfo["Players"]
    );

    $entityManager->persist($serverHistory);
    $entityManager->flush();
    sleep(5);
}
