<?php

namespace EscapePE;

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
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new TimeTable($this), 1);
		//$this->dataSave("trasta298");
	}

	//データをセーブする
	public function dataSave($name){
		if(isset($this->data[$name])){
			$data = json_encode($this->data[$name]);
		}else{
			$data = json_encode($this->dataLoad($name));
		}
		$res = file_put_contents("SaveData/".$name.".json",$data);
		if($res){
			Server::getInstance()->getLogger()->info("".$name."のデータセーブが完了しました");
		}else{
			Server::getInstance()->getLogger()->info("".$name."のデータセーブに失敗しました");
		}
	}

	//データをロードする
	public function dataLoad($name){
		$res = file_get_contents("SaveData/".$name.".json");
		if($res){
			Server::getInstance()->getLogger()->info($name."のデータロードが完了しました");
			return json_decode($res);
		}else{
			Server::getInstance()->getLogger()->info($name."のデータが見つからなかったので新しいデータを作成しました");
			return $this->getNewData();
		}
	}

	public function getNewData(){
		$data = [
			"rank" => 1
		];
		return $data;
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
