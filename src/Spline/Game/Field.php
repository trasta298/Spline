<?php

namespace Spline\Game;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;

use Spline\System\Matrix;
use Spline\Game\Laputa;


class Field{

	private $center = [100,10,100];
	private $radius = 20;

	//フィールド削除
	public static function remove(){
		# code...
	}

	//フィールド生成
	public static function generate(){
		# code...
	}

	//浮島生成
	public static function geneLaputa($pos, $size){
		$level = Server::getInstance()->getDefaultLevel();
		$laputa = new Laputa(1, 0, $size);
		$laputa->placeObject($level, $pos);
	}


}