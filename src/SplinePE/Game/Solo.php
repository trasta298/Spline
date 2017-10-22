<?php

namespace Spline\Game;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;

use pocketmine\scheduler\PluginTask;

use Spline\System\Chat;

class Solo {

	private $stage = 0;
	private $ongame = [
		"alive" => [],
		"dead" => []
	];
    
	function __construct($main){
		$this->main = $main;
		$stage = 0;
		$this->timeTable();
	}

	public function getStage(){
		return $this->stage;
	}

	/**
	*タイムテーブル
	*/
	public function timeTable(){
		$next = true;
		switch($this->stage){
			case 0: //メンバー決定
				$res = $this->main->entry->choiceBattleMember();
				if($res){
					$this->ongame["alive"] = $res;
					$this->main->getServer()->broadcastMessage(Chat::System("メンバーがそろいました"));
					$this->main->getServer()->broadcastMessage(Chat::System("試合を開始します"));
					$this->main->getServer()->getScheduler()->scheduleDelayedTask(new TimeScheduler($this->main), 100);
				}else{//人数が足りない
					$this->main->getServer()->getScheduler()->scheduleDelayedTask(new TimeScheduler($this->main), 100);
					$this->main->getServer()->broadcastMessage(Chat::Debug("メンバーがそろいませんでした"));
					$next = false;
				}
				break;

			case 2: //試合開始
				break;

			default:
				# err

		}//end switch

		if($next) $this->stage++;
	}

}

class TimeScheduler extends PluginTask{
	
	public function __construct(PluginBase $owner){
		parent::__construct($owner);
	}

	public function onRun($tick){
		$this->getOwner()->game->timeTable();
	}
}