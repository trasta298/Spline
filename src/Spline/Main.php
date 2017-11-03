<?php

namespace Spline;

use Spline\PlayerData;
use Spline\System\Entry;
use Spline\Game\Game;
use Spline\Event\Event;
use Spline\System\Chat;

# Base
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;

# Other
use pocketmine\scheduler\PluginTask;

class Main extends PluginBase implements Listener{

	private $data = [];

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents(new Event($this), $this);
		$this->entry = new Entry($this);
		$this->game = new Game($this);
	}

	/**
	*PlayerDataを取得する
	*/
	public function getData($name){
		if(isset($this->data[$name])){
			return $this->data[$name];
		}else{
			Server::getInstance()->getLogger()->info("§b{$name}のデータは存在しません");
			return false;
		}
	}

	/**
	*データをセーブする
	*/
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

	/**
	*データをロードする
	*/
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

}
