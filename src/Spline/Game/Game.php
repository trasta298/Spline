<?php

namespace Spline\Game;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\level\Position;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\MainLogger;

use Spline\System\Chat;
use Spline\Game\Field;
use Spline\Game\Members;

class Game {

	const CENTER_POS = [200,70,200];
	const LOBBY_POS = [200,7,200];
	private $stage = 0;
	private $laputas = [];
    
	function __construct($main){
		$this->main = $main;
		Server::getInstance()->loadLevel(Field::WORLD);
		$stage = 0;
		$this->timeTable();
		$this->m = new Members();
	}

	//プレイヤーがログインしたとき
	public function onJoin($player){
		$level = Server::getInstance()->getLevelByName("world");
		$player->teleport(new Position(self::LOBBY_POS[0], self::LOBBY_POS[1], self::LOBBY_POS[2], $level));
	}

	public function getStage(){
		return $this->stage;
	}

	// 関数を遅らせて実行する
	public function delayFunc($str, $tick){
		$this->main->getServer()->getScheduler()->scheduleDelayedTask(new TimeScheduler($this->main, $str), $tick);
	}

	public function formField(){
		$this->laputas = [];
		$this->laputas = Field::form(self::CENTER_POS);
	}

	/**
	*タイムテーブル
	*/
	public function timeTable(){
		echo "timeTable {$this->stage}\n";
		$next = true;//
		switch($this->stage){
			case 0: //フィールド初期化
					$this->delayFunc("timeTable", 200);
					Field::remove();
					$this->delayFunc("formField", 100);
				break;
			case 1: //メンバー決定
				$res = $this->main->entry->choiceBattleMember();
				if($res){
					$this->main->getServer()->broadcastMessage(Chat::System("プレイヤーがそろいました"));
					$this->m->newMember($res);
					$this->delayFunc("timeTable", 200);
				}else{//人数が足りない
					MainLogger::getLogger()->debug(Chat::Debug("プレイヤーが足りません"));
					$next = false;
					$this->delayFunc("timeTable", 100);
				}
				break;

			case 2: //試合開始
				$this->main->getServer()->broadcastMessage(Chat::System("試合を開始します"));
				$this->m->teleportField($this->laputas);
				$this->delayFunc("timeTable", 400);
				break;

			case 3: //
				$this->main->getServer()->broadcastMessage(Chat::System("終了！"));
				$this->m->teleportLobby(self::LOBBY_POS);
				$this->delayFunc("timeTable", 100);
				break;

			case 4: //すべて終了
				$next = false;
				$this->stage = 0;
				$this->delayFunc("timeTable", 100);
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