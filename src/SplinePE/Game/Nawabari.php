<?php

namespace SplinePE\Game;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;

use pocketmine\scheduler\PluginTask;

class Nawabari {

	private $stage = 0;
    
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
		switch($this->stage){
			case 0: //待機状態
				$num = $this->entry->getEntryNum();
				if($num >= 4){
					$this->getServer()->getScheduler()->scheduleDelayedTask(new TimeScheduler($main), 200);
					$this->stage++;
				}
				break;
			case 1: //メンバー決定
				
				break;
		}
	}

}


class TimeTable extends PluginTask{
	public function onRun($tick){
		//1tick毎
		$this->getOwner()->game->timeTable();
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