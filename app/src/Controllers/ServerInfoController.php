<?php
declare(strict_types=1);
namespace Yuyui\Interlopertracker\Controllers;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use Yuyui\Interlopertracker\Domain\ServerHistory;

class ServerInfoController{
    public function __construct(private EntityManager $entityManager){}

    public function getServerInfo(Request $request, Response $response): Response{
        $serverHistoryRepository = $this->entityManager->getRepository(ServerHistory::class);
        $serverHistory = $serverHistoryRepository->createQueryBuilder('sh')
            ->select('sh')
            ->orderBy('sh.registeredAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        if(empty($serverHistory) || ! $serverHistory instanceof ServerHistory){
            $response->getBody()->write("<span>Failed to get server info</span>");
            return $response;
        }

        

        $page_template = '<div class="flex-column space-controls">
                    <label>
                        Last query time
                        <label><b>%last_query_time%</b></label>
                    </label>
                    <label>
                        <label>Status</label>
                        <b>%status%</b>
                    </label>
                    <label>
                        Current Map
                        <input readonly type="text" value="%map%">
                    </label>
                    <label>
                        Players
                        <label><b>%current_player_count%/%max_player_count%</b></label>
                    </label>
                    <label>
                        Passworded
                        <input readonly type="checkbox" %password_checked%>
                    </label>
                </div>';

        $response->getBody()->write(strtr($page_template, [
            "%last_query_time%" => $serverHistory->getRegisteredAt()->format("r"),
            "%status%" => $serverHistory->getIsOnline() ? "Online" : "Offline",
            "%map%" => $serverHistory->getMap()?->getMapName() ?? "No map",
            "%current_player_count%" => $serverHistory->getPlayerCount(),
            "%max_player_count%" => $serverHistory->getMaxPlayers(),
            "%password_checked%" => $serverHistory->getIsPassworded() ? "checked" : null,
        ]));

        return $response;
    }
}