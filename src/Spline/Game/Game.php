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

	// 関数を遅らせて実行する
	public function delayFunc($str, $tick){
		$this->main->getServer()->getScheduler()->scheduleDelayedTask(new TimeScheduler($this->main, $str), 100);
	}

	/**
	*タイムテーブル
	*/
	public function timeTable(){
		$next = true;
		switch($this->stage){
			case 0: //フィールド作成
					$this->delayFunc("timeTable", 200);
				break;
			case 1: //メンバー決定
				$res = $this->main->entry->choiceBattleMember();
				if($res){
					$this->main->getServer()->broadcastMessage(Chat::System("プレイヤーがそろいました"));
					$this->m->newMember($res);
					$this->delayFunc("timeTable", 100);
				}else{//人数が足りない
					$this->delayFunc("timeTable", 100);
					MainLogger::getLogger()->info(Chat::Debug("プレイヤーが足りません"));
					$next = false;
				}
				break;

			case 2: //試合開始
				$this->main->getServer()->broadcastMessage(Chat::System("試合を開始します"));
				break;

			default:
				# err

		}//end switch

		if($next) $this->stage++;
	}

}

class TimeScheduler extends PluginTask{

	private $func;

	public function __construct(PluginBase $owner, $str = "timeTable"){
		parent::__construct($owner);
		$this->func = $str;
	}

	public function onRun($tick){
		$f = array($this->getOwner()->game, $this->func);
		$f();
	}
}