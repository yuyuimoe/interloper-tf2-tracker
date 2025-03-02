<?php
namespace Yuyui\Interlopertracker\Domain;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\JoinColumn;
use Yuyui\Interlopertracker\Domain\Map;

#[Entity, Table(name: "history")]
class ServerHistory
{
    #[Id, Column(type: 'integer'), GeneratedValue()]
    // @phpstan-ignore property.onlyRead
    private int $id;
    #[ManyToOne(targetEntity: Map::class), JoinColumn(name: 'map_id', referencedColumnName: 'id', nullable: true)]
    private ?Map $map;
    #[Column(name: "is_online", type: 'boolean', nullable: false)]
    private bool $isOnline;
    #[Column(name: "is_passworded", type: 'boolean', nullable: false)]
    private bool $isPassworded;
    #[Column(name: "server_name", type: 'string', nullable: false)]
    private string $serverName;
    #[Column(name: "max_players", type: "integer", nullable: false)]
    private int $maxPlayers;
    #[Column(name: "player_count", type: "integer", nullable: false)]
    private int $playerCount;
    #[Column(name: 'registered_at', type: 'datetimetz_immutable', nullable: false)]
    private DateTimeImmutable $registeredAt;

    public function __construct(?Map $map, bool $isOnline, bool $isPassworded, string $serverName, int $maxPlayers, int $playerCount){
        $this->map = $map;
        $this->isOnline = $isOnline;
        $this->isPassworded = $isPassworded;
        $this->serverName = $serverName;
        $this->maxPlayers = $maxPlayers;
        $this->playerCount = $playerCount;
        $this->registeredAt = new DateTimeImmutable("now");
    }

    public function getId(): int{
        return $this->id;
    }

    public function getMap(): Map|null{
        return $this->map;
    }

    public function getIsOnline(): bool{
        return $this->isOnline;
    }

    public function getIsPassworded(): bool{
        return $this->isPassworded;
    }

    public function getServerName(): string{
        return $this->serverName;
    }

    public function getMaxPlayers(): int{
        return $this->maxPlayers;
    }

    public function getPlayerCount(): int{
        return $this->playerCount;
    }

    public function getRegisteredAt(): DateTimeImmutable{
        return $this->registeredAt;
    }
}