<?php

namespace EscapePE;

# Base
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

# Other
use pocketmine\scheduler\PluginTask;

class Main extends PluginBase implements Listener{

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents(new Event($this), $this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new TimeTable($this), 1);
	}

	//タイムテーブル
	public function timeTable(){
		
	}

}

class TimeTable extends PluginTask{
	public function onRun($tick){
		$this->getOwner()->timeTable();
	}
}
