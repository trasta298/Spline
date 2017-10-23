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
		# code...
	}
}