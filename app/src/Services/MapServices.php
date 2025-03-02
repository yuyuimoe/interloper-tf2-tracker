<?php
namespace Yuyui\Interlopertracker\Services;

use Doctrine\ORM\EntityRepository;
use Yuyui\Interlopertracker\Domain\Map;

final readonly class MapServices{
    /**
     * Undocumented function
     *
     * @param EntityRepository<Map> $repository
     * @param string $mapName
     *
     * @return Map|null
     */
    public static function getMapByName(EntityRepository $repository, string $mapName): ?Map{
        $map = $repository->findOneBy(["mapName" => $mapName]);
        if(is_null($map)){
            return null;
        }
        return $map;
    }
}