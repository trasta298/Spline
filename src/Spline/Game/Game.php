<?php

namespace Spline\Game;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\MainLogger;

use Spline\System\Chat;
use Spline\Game\Field;
use Spline\Game\Members;

class Game {

	private $stage = 0;
    
	function __construct($main){
		$this->main = $main;
		$stage = 0;
		$this->timeTable();
		$this->m = new Members();
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
			case 0: //フィールド作成
					$this->main->getServer()->getScheduler()->scheduleDelayedTask(new TimeScheduler($this->main), 200);
				break;
			case 1: //メンバー決定
				$res = $this->main->entry->choiceBattleMember();
				if($res){
					$this->m->newMember($res);
					$this->main->getServer()->broadcastMessage(Chat::System("メンバーがそろいました"));
					$this->main->getServer()->broadcastMessage(Chat::System("試合を開始します"));
					$this->main->getServer()->getScheduler()->scheduleDelayedTask(new TimeScheduler($this->main), 100);
				}else{//人数が足りない
					$this->main->getServer()->getScheduler()->scheduleDelayedTask(new TimeScheduler($this->main), 100);
					MainLogger::getLogger()->debug(Chat::Debug("メンバーがそろいませんでした"));
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