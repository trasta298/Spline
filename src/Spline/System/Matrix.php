<?php

namespace Spline\System;


class Matrix {

	/**
	* 行数
	* @param 二重配列 行列1
	* @return int 行数
	*/
	public static function countRow(array $a){
		return count($a);
	}

	/**
	* 列数
	* @param 二重配列 行列1
	* @return int 列数
	*/
	public static function countCol(array $a){
		return count($a[0]);
	}


	/**
	* 行列のサイズ
	* @param 二重配列 行列1
	* @return array [行数,列数]
	*/
	public static function countSize(array $a){
		return [self::countRow($a), self::countCol($a)];
	}

	/**
	* 和
	* @param 二重配列 行列1
	* @param 二重配列 行列2
	* @return 行列1 + 行列2
	*/
	public static function add(array $a, array $b){
		if(self::countSize($a) !== self::countSize($b)){
			throw new Exception('Different Matrix size.');
		}
		foreach($a as $x=>$v){
			foreach($v as $y=>$val){
				$a[$x][$y] += $b[$x][$y];
			}
		}
		return $a;
	}

	/**
	* 差
	* @param 二重配列 行列1
	* @param 二重配列 行列2
	* @return 行列1 - 行列2
	*/
	public static function sub(array $a, array $b){
		if(self::countSize($a) !== self::countSize($b)){
			throw new Exception('Different Matrix size.');
		}
		foreach($a as $x=>$v){
			foreach($v as $y=>$val){
				$a[$x][$y] -= $b[$x][$y];
			}
		}
		return $a;
	}

	/**
	* 積
	* @param 二重配列 行列1
	* @param 二重配列 行列2
	* @return 行列1 * 行列2
	*/
	public static function multiply(array $a, array $b){
		$c = self::countCol($a);
		if($c !== self::countRow($b)){
			throw new Exception('Invalid Matrix size.');
		}
		$r = self::countRow($b);

		$ret = [];
		for($i=0;$i<$r;$i++){
			for($j=0;$j<$r;$j++){
				$ret[$i][$j] = 0;
				for($k=0;$k<$c;$k++){
					$ret[$i][$j] += floor($a[$i][$k] * $b[$k][$j]);
				}
			}
		}
		return $ret;
	}

	/**
	* スカラー倍
	* @param 二重配列 行列1
	* @param float スカラー倍
	* @return 行列1 * float
	*/
	public static function scalar(array $a, float $m){
		array_walk_recursive($a, function(&$v, $k, $m){
			$v = $v*$m;
		}, $m);
		return $a;
	}

	/**
	* 転置行列
	* @param 二重配列 行列1
	* @return 行列1の転置行列
	*/
	public static function transpose(array $a){
		return call_user_func_array('array_map', array_merge([null], $a));
	}

	public static function abc(array $a){
		return [[$a[0]], [$a[1]], [$a[2]]];
	}

	public static function cba(array $a){
		return [$a[0][0], $a[1][0], $a[2][0]];
	}
}