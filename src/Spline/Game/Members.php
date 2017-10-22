<?php

namespace Spline\Game;

class Members {

	const RED = 0;
	const BLUE = 1;
	const GREEN = 2;

	private $ongame = [
	];
	
	function __construct(){
		# code...
	}

	public function resetMember(){
		$this->ongame = [
			"alive" => [],
			"dead" => []
		];
	}

	public function newMember($mem){
		$this->resetMember();
		# code...
	}
}