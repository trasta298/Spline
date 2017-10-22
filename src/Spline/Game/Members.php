<?php

namespace Spline\Game;

class Members {

	private $ongame = [
		"alive" => [],
		"dead" => []
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