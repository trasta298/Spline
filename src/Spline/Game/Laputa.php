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
		echo "start\n";
		$this->map = [];
		$this->createMap($pos[0], $pos[2], $this->size);
		echo "map create!\n";
		foreach ($this->map as $key => $value) {
			for ($y=$pos[1]-$value[2]; $y<$pos[1]; $y++){
				if($y < 0) continue;
				$level->setBlockIdAt($value[0], $y+1, $value[1], $this->id);
				$level->setBlockDataAt($value[0], $y+1, $value[1], $this->data);
			}
		}
		echo "end\n";
	}

	// x, z, y
	public function createMap($x, $z, $y){
		$this->map[] = [$x, $z, $y];
		$radius = $this->size;
		for ($i=1; $i <= $radius; $i++) {
			$list = [[$x+$i, $z], [$x-$i, $z], [$x, $z+$i], [$x, $z-$i]];
			for ($p=0; $p < 4; $p++) { 
				$g = $this->size-round($this->size*$this->size/(($this->size-$i+1)*($this->size-$i+1)));
				$g = ($g > 0) ? $g : 0;
				$a = ($i < 5) ? $this->size+mt_rand(0,2)-1 : $g;
				$this->map[] = [$list[$p][0], $list[$p][1], $a];
			}
		}
		for ($n=1; $n <= $radius; $n++){
			for ($m=1; $m <= $radius; $m++){ 
				$list = [[$x+$n, $z+$m], [$x-$n, $z+$m], [$x+$n, $z-$m], [$x-$n, $z-$m]];
				for ($p=0; $p < 4; $p++) { 
					$abc = $this->abc($list[$p][0], $list[$p][1]);
					$this->map[] = [$list[$p][0], $list[$p][1], $abc];
				}
			}
		}
	}

	public function abc($x, $z){
		$sur = [$this->sameAt($x+1, $z), $this->sameAt($x-1, $z), $this->sameAt($x, $z+1), $this->sameAt($x, $z-1),$this->sameAt($x+1, $z+1), $this->sameAt($x-1, $z-1), $this->sameAt($x-1, $z+1), $this->sameAt($x+1, $z-1)];
		$sur = array_values(array_diff($sur, array(0)));
		$c = count($sur);
		$de = mt_rand(0,1);
		if($c < 3){
			return 0;
		}else if($c == 3){
			$de += mt_rand(0, max($sur));
		}
		$av = floor(array_sum($sur)/$c);
		$res = $av-$de;
		$res = ($res > 0) ? $res : 0;
		return $res;
	}

	public function sameAt($x, $z){
		foreach ($this->map as $key => $value) {
			if($value[0] == $x and $value[1] == $z){
				return $value[2];
			}
		}
		return 0;
	}


}