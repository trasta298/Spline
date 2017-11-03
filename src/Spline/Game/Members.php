<?php

namespace Spline\Game;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\level\Position;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\MainLogger;

use Spline\System\Chat;
use Spline\Game\Field;
use Spline\Game\Members;
use Spline\Game\Laputa;

class Members {

	const RED = 0;
	const BLUE = 1;
	const GREEN = 2;

	private $ongame = [
		self::RED =>[],
		self::BLUE => [],
		self::GREEN => []
	];
	
	function __construct(){
		# code...
	}

	//チームの色を取得
	public function getColor($i){
		switch ($i) {
			case self::RED:
				return "§cred§f";
			case self::BLUE:
				return "§9blue§f";
			case self::GREEN:
				return "§agreen§f";
			default:
				return "no team";
		}
	}

	public function getTeam($name){
		for ($i=0; $i < 3; $i++) {
			if(in_array($name, $this->ongame[$i])){
				return $i;
			}
		}
		return false;
	}

	public function resetMember(){
		$this->ongame = [
			self::RED =>[],
			self::BLUE => [],
			self::GREEN => []
		];
	}

	public function newMember($mem){
		$this->resetMember();
		shuffle($mem);
		$this->ongame[self::RED] = array_splice($mem, 0, floor(count($mem)/3));
		$this->ongame[self::BLUE] = array_splice($mem, 0, floor(count($mem)/2));
		$this->ongame[self::GREEN] = $mem;
		for ($i=0; $i < 3; $i++) {
			foreach ($this->ongame[$i] as $name) {
				if(($player = Server::getInstance()->getPlayer($name)) instanceof Player){
					$out = $this->getColor($i)."チームに入りました";
					$player->sendMessage(Chat::System($out));
				}
			}
		}
	}

	public function teleportField($laputas){
		$level = Server::getInstance()->getLevelByName(Field::WORLD);
		for ($i=0; $i < 3; $i++) { 
			$pos = $laputas[$i]->getPos();
			foreach ($this->ongame[$i] as $name) {
				if(($player = Server::getInstance()->getPlayer($name)) instanceof Player){
					$player->teleport(new Position($pos[0], $pos[1]+2, $pos[2], $level));
				}
			}
		}
	}

	public function teleportLobby($pos){
		$level = Server::getInstance()->getLevelByName("world");
		for ($i=0; $i < 3; $i++) { 
			foreach ($this->ongame[$i] as $name) {
				if(($player = Server::getInstance()->getPlayer($name)) instanceof Player){
					$player->teleport(new Position($pos[0], $pos[1], $pos[2], $level));
				}
			}
		}
	}

}