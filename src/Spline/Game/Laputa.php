<?php

namespace Spline\Game;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3 as Vector3;
use pocketmine\utils\Random;

use Spline\System\Matrix;


class Laputa {

	private $id;
	private $data;
	private $size;

	public function __construct($id, $data, $size){
		$this->id = $id;
		$this->data = $data;
		$this->size = $size;
	}

	public function placeObject($level, $pos){
		$this->set($level, $pos[0], $pos[1]-$this->size, $pos[2], 0);
	}

	public function set($level, $x, $y, $z, $count){
		echo $block->x." ".$block->y." ".$block->z."\n";
		$id = $level->getBlockIdAt($x, $y, $z);
		$data  = $level->getBlockDataAt($x, $y, $z);
		if($y < 0 || $y >= 256 || $count > $this->size){
			return false;
		}
		if($id !== $this->id || $data !== $this->data){
			$level->setBlockIdAt($x, $y, $z, $this->id);
			$level->setBlockDataAt($x, $y, $z, $this->data);
		}
		$r = ceil($count/3);
		$this->set($level, $x, $y+1, $z, $count+1);
		if(mt_rand(0, $r) === 0) $this->set($level, $x+1, $y+1, $z, $count+1);
		if(mt_rand(0, $r) === 0) $this->set($level, $x-1, $y+1, $z, $count+1);
		if(mt_rand(0, $r) === 0) $this->set($level, $x, $y+1, $z+1, $count+1);
		if(mt_rand(0, $r) === 0) $this->set($level, $x, $y+1, $z-1, $count+1);
		return true;
	}

}