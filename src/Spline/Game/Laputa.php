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
	private $map;

	public function __construct($id, $data, $size){
		$this->id = $id;
		$this->data = $data;
		$this->size = $size;
	}


	public function placeObject($level, $pos){
		$this->map = [];
		$this->createMap([$pos[0], $pos[2], $this->size]);
		foreach ($this->map as $key => $value) {
			for ($y=$pos[1]-$value[2]; $y<$pos[1]; $y++){
				if($y < 0) continue;
				$level->setBlockIdAt($value[0], $y+1, $value[1], $this->id);
				$level->setBlockDataAt($value[0], $y+1, $value[1], $this->data);
			}
		}
	}

	public function createMap($p){
		if($p[2] > 0){
			if($k = $this->sameAt($p[0], $p[1])){
				if($this->map[$k][2] < $p[2]){
					$this->map[$k][2] = $p[2];
				}
			}else{
				$this->map[] = $p;
			}
			$n = floor(($this->size-$p[2])/3);
			//$m = ceil(count($this->map)/3);
			$p[2]--;
			//if(mt_rand(0, $m) == 0) $p[2]++;
			if(mt_rand(0, $n) == 0) $this->createMap([$p[0]+1, $p[1], $p[2]]);
			if(mt_rand(0, $n) == 0) $this->createMap([$p[0]-1, $p[1], $p[2]]);
			if(mt_rand(0, $n) == 0) $this->createMap([$p[0], $p[1]+1, $p[2]]);
			if(mt_rand(0, $n) == 0) $this->createMap([$p[0], $p[1]-1, $p[2]]);
		}else{
			return;
		}
	}

	public function sameAt($x, $z){
		foreach ($this->map as $key => $value) {
			if($value[0] == $x and $value[1] == $z){
				return $key;
			}
		}
		return false;
	}


}