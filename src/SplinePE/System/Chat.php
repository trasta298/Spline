<?php

namespace Spline\System;

class Chat {

	public static function System($arg){
		$str = "§f[System] §7";
		$str .= $arg;
		return $str;
	}

	public static function Debug($arg){
		$str = "$f[Debug] $7";
		$str .= $arg;
		return $str;
	}

}