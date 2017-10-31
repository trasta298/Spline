<?php

namespace Spline\Game;

class Members {

	const RED = 0;
	const BLUE = 1;
	const GREEN = 2;

	private $ongame = [
		self::RED =>[],
		self::BLUE => [],
		self::GREEN => []
	];
	
	function __construct(){
		# code...
	}

	public function resetMember(){
		$this->ongame = [
			self::RED =>[],
			self::BLUE => [],
			self::GREEN => []
		];
	}

	public function newMember($mem){
		$this->resetMember();
		shuffle($mem);
		$this->ongame[self::RED] = array_splice($mem, 0, floor(count($mem)/3));
		$this->ongame[self::BLUE] = array_splice($mem, 0, floor(count($mem)/2));
		$this->ongame[self::GREEN] = $mem;
	}
}