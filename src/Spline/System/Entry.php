<?php

namespace Spline\System;

use pocketmine\Player;
use pocketmine\Server;

class Entry {

	private $entrylist = [];

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
	 * エントリー何番目かを取得
	 */
	public function getEntry($user){
		return array_search($user, $this->entrylist)+1;
	}

	/**
	 * エントリーしている人数を取得
	 */
	public function getEntryNum(){
		return count($this->entrylist);
	}

	/**
	 * エントリー追加
	 */
	public function addEntry($user){
		$playerData = Account::getInstance()->getData($user);
		if($this->isEntry($user)){
			return $this->getEntry($user)."番目にエントリーなう";
		}
		$this->entrylist[] = $user;
		return "エントリー完了！ ".count($this->entrylist)."番目";
	}

	/**
	 * エントリー解除
	 */
	public function removeEntry($user){
		if(!$this->isEntry($user)){
			return "まだエントリーしていません";
		}
		while(true){
			if(($n = array_search($user, $this->entrylist)) !== false){
				array_splice($this->entrylist, $n, 1);
			}else{
				break;
			}
		}
		return "エントリーを解除しました";
	}

	/**
	 * 試合メンバー選出
	 */
	public function choiceBattleMember(){
		//エントリー人数が足りない時
		if($this->getEntryNum() < 4){
			return false;
		}
		//一試合上限は12人
		$num = ($this->getEntryNum() > 12) ? 12 : $this->getEntryNum();
		return array_splice($this->entrylist, 0, $num);
	}

}