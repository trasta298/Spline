<?php

namespace EscapePE;

# Base
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

# Other
use pocketmine\scheduler\PluginTask;

class Main extends PluginBase implements Listener{

	private $data = [];

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents(new Event($this), $this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new TimeTable($this), 1);
	}

	//エントリーリクエスト処理
	public function onEntry($name){
		#code...
	}

	//エントリーキャンセル処理
	public function outEntry($name){
		#code...
	}

	//タイムテーブル
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
