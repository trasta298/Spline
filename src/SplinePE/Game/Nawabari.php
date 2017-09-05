<?php

namespace SplinePE;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;

use pocketmine\scheduler\PluginTask;

class Nawabari {

	private $stage = 0;
    
	function __construct($main){
		$this->main = $main;
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new TimeTable($this), 1);
		$stage = 0;
	}

	public function getStage(){
		return $this->stage;
	}

	/**
	*タイムテーブル
	*/
	public function timeTable(){
		#code...
	}

}


class TimeTable extends PluginTask{
	public function onRun($tick){
		//1tick毎
		$this->getOwner()->timeTable();
	}
}
