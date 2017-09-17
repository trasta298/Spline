<?php

namespace SplinePE;

use pocketmine\Player;
use pocketmine\Server;

class Entry {

	private $entrylist = [];
	private $preentrylist = [];

	function __construct($main){
		$this->main = $main;
	}

	/**
	 * エントリーしているかどうか取得
	 */
	public function isEntry($user){
		return in_array($user, $this->entrylist);
	}

	/**
	 * 仮エントリーしているかどうか取得
	 */
	public function isPreEntry($user){
		return in_array($user, $this->preentrylist);
	}


	/**
	 * エントリー何番目かを取得
	 */
	public function getEntry($user){
		return array_search($user, $this->entrylist)+1;
	}

	/**
	 * エントリーできるかどうか取得
	 */
	public function canEntry($user){
		return ($this->main->team->getTeamOf($user) == 0);
	}

	/**
	 * エントリーしている人数を取得
	 */
	public function getEntryNum(){
		return count($this->entrylist)+count($this->preentrylist);
	}

	/**
	 *エントリーの順番確定
	 */
	public function PreintoEntry(){
		shuffle($this->preentrylist);
		$this->entrylist = array_merge($this->entrylist, $this->preentrylist);
		foreach ($this->preentrylist as $user) {
			$player = $this->main->getServer()->getPlayer($user);
			if($player instanceof Player){
				$player->sendMessage($this->getEntry($user)."番目にエントリーした！");
			}
		}
		$this->preentrylist = [];
	}

	/**
	 * エントリー追加
	 */
	public function addEntry($user, $run_isReady = true){
		$playerData = Account::getInstance()->getData($user);
		if($this->isEntry($user)){
			return $this->getEntry($user)."番目にエントリーしてるじゃなイカ";
		}
		if($this->isPreEntry($user)){
			return "エントリー済みじゃなイカ シャッフル中…";
		}
		// ゲーム中にエントリー 後で書く 2017/9/4
		/*
		if($this->main->game == 17 || $this->main->game == 1){
			$this->preentrylist[] = $user;
			if($run_isReady){
				$this->isReady();
			}
			return "エントリー完了！ シャッフル中…";
		}
		*/
		$this->entrylist[] = $user;
		if($run_isReady){
			$this->isReady();
		}
		return "エントリー完了！ ".count($this->entrylist)."番目";
	}

	/**
	 * エントリー解除
	 */
	public function removeEntry($user){
		if(!$this->isEntry($user) and !$this->isPreEntry($user)){
			return false;
		}
		while(true){
			if(($n = array_search($user, $this->entrylist)) !== false){
				array_splice($this->entrylist, $n, 1);
			}else{
				break;
			}
			if(($n = array_search($user, $this->preentrylist)) !== false){
				array_splice($this->preentrylist, $n, 1);
			}else{
				break;
			}
		}
		return true;
	}

	/**
	 * 試合メンバー選出
	 */
	public function choiceBattleMember(){
		//エントリー人数が足りない時
		if(count($this->entrylist) < 2){
			return false;
		}
		#code...
	}

	/**
	 * 試合の平等マッチング選出
	 * @param $members
	 * @param $many
	 */
	public function getMatching($members, $many){
		#code...
	}
}