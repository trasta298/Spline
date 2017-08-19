<?php

namespace EscapePE;

class PlayerData {

    private final $VERSION = 1;

    public $name;
    public $rank;

    function __construct(){
        #code...
    }

	//データをセーブする
	public function dataSave(){
		$data = $this->encodeJSON();
		$res = file_put_contents("SaveData/".$name.".json",$data);
		if($res){
			Server::getInstance()->getLogger()->info("\033[1;34m".$name."のデータセーブが完了しました"."\033[0m");
		}else{
			Server::getInstance()->getLogger()->info("\033[0;31m".$name."のデータセーブに失敗しました"."\033[0m");
		}
	}

	//データをロードする
	public function dataLoad($name){
		if(file_exists("SaveData/".$name.".json")){
			$res = file_get_contents("SaveData/".$name.".json");
			Server::getInstance()->getLogger()->info("\033[1;34m".$name."のデータロードが完了しました"."\033[0m");
			return json_decode($res);
		}else{
			Server::getInstance()->getLogger()->info("\033[1;36m".$name."のデータが見つからなかったので新しいデータを作成しました"."\033[0m");
			return $this->getNewData();
		}
    }
    
    public function encodeJSON(){
        $data = [
            "version" => $this->VERSION,
            "rank" => $this->rank
        ];
        return json_encode($data);
    }

}