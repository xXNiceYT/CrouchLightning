<?php

declare(strict_types=1);

namespace CL;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\entity\Entity;
use pocketmine\network\mcpe\protocol\AddEntityPacket;

class Main extends PluginBase implements Listener{

	public function onEnable(): void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onSneak(PlayerToggleSneakEvent $e): void{
		$player = $e->getPlayer();

		if(!$player->isSneaking()) return;
		foreach($this->getServer()->getOnlinePlayers() as $user){
			$pk = new AddEntityPacket();
			$pk->type = 93;
			$pk->entityRuntimeId = Entity::$entityCount++;
			$pk->position = $user->asVector3();
			$this->getServer()->broadcastPacket($this->getServer()->getOnlinePlayers(), $pk);
		}
	}
}