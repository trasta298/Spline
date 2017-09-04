<?php

namespace SplatoonPE;

use SplatoonPE\PlayerData;

# Base
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;

# Other
use pocketmine\scheduler\PluginTask;

class Main extends PluginBase implements Listener{

	private $data = [];
	private $entry = [];

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents(new Event($this), $this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new TimeTable($this), 1);
	}

	//PlayerDataを取得する
	public function getData($name){
		return $this->data[$name];
	}

	//データをセーブする
	public function dataSave($name, $isout = true){
		if(isset($this->data[$name])){
			$this->data[$name]->dataSave();
			if($isout){
				unset($this->data[$name]);
			}
		}else{
			//セーブするデータがない
		}
	}

	//データをロードする
	public function dataLoad($name, $isin = true){
		if(isset($this->data[$name])){
			return $this->data[$name];
		}
		$pdata = new PlayerData($name, true);
		if($isin){
			$this->data[$name] = $pdata;
		}
		return $pdata;
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
