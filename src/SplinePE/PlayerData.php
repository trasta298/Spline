<?php

namespace SplinePE;

use pocketmine\Server;

class PlayerData {

	const VERSION = 1;
	/*
	* 新しいデータを追加したいときはVERSIONの数字を上げたうえで getNewData,encodeJSON,decodeJSON に追加する
	*/

    public $name;
    public $rank;

    function __construct($name, $load){
		$this->name = $name;
        if($load){
			$this->dataLoad();
		}
    }

	//データをセーブする
	public function dataSave(){
		$data = $this->encodeJSON();
		$res = file_put_contents("SaveData/".$this->name.".json",$data);
		if($res){
			Server::getInstance()->getLogger()->info("\033[1;34m".$this->name."のデータセーブが完了しました"."\033[0m");
		}else{
			Server::getInstance()->getLogger()->info("\033[0;31m".$this->name."のデータセーブに失敗しました"."\033[0m");
		}
		return $res;
	}

	//データをロードする
	public function dataLoad(){
		if(file_exists("SaveData/".$this->name.".json")){
			$res = file_get_contents("SaveData/".$this->name.".json");
			$this->decodeJSON($res);
			Server::getInstance()->getLogger()->info("\033[1;34m".$this->name."のデータロードが完了しました"."\033[0m");
		}else{
			Server::getInstance()->getLogger()->info("\033[1;36m".$this->name."のデータが見つからなかったので新しいデータを作成しました"."\033[0m");
			$this->getNewData();
		}
	}

	/**
	*初期データ取得
	*/
	public function getNewData(){
		$this->rank = 1;
	}
	
    public function encodeJSON(){
        $data = [
            "version" => self::VERSION,
            "rank" => $this->rank
        ];
        return json_encode($data);
	}
	
	public function decodeJSON($str){
		$data = json_decode($str);
		if($data["version"] != self::VERSION){//データのバージョンが古かったら
			switch ($data["version"]) {
				case 1:
				$data["rank"] = 1;
				
			}
		}
		$this->rank = $data["rank"];
	}
    

}