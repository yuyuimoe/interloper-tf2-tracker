<?php
namespace Yuyui\Interlopertracker\Domain;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'maps')]
class Map
{
    #[Id, Column(type: 'integer'), GeneratedValue()]
    // @phpstan-ignore property.onlyRead
    private int $id;
    #[Column(name: 'map_name', type: 'string', unique: true, nullable: false)]
    private string $mapName;
    #[Column(name: 'registered_at', type: 'datetimetz_immutable', nullable: false)]
    private DateTimeImmutable $registeredAt;

    public function __construct(string $mapName){
        $this->mapName = $mapName;
        $this->registeredAt = new DateTimeImmutable('now');
    }

    public function getId(): int{
        return $this->id;
    }

    public function getMapName(): string{
        return $this->mapName;
    }

    public function getRegisteredAt(): DateTimeImmutable{
        return $this->registeredAt;
    }
}