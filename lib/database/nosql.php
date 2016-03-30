<?php
/*****************************************************************************
 *         In the name of God the Most Beneficent the Most Merciful          *
 *___________________________________________________________________________*
 *   This program is free software: you can redistribute it and/or modify    *
 *   it under the terms of the GNU General Public License as published by    *
 *   the Free Software Foundation, either version 3 of the License, or       *
 *   (at your option) any later version.                                     *
 *___________________________________________________________________________*
 *   This program is distributed in the hope that it will be useful,         *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *   GNU General Public License for more details.                            *
 *___________________________________________________________________________*
 *   You should have received a copy of the GNU General Public License       *
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *___________________________________________________________________________*
 *                             Created by  Qti3e                             *
 *        <http://Qti3e.Github.io>    LO-VE    <Qti3eQti3e@Gmail.com>        *
 *****************************************************************************/
namespace database;

/**
 * Class nosql
 * @package database
 */
class nosql{
	/**
	 * @var string
	 */
	private static $dataString = '';
	private static $dataArray  = '';
	public static $nosql_fetch_count = 0;
	/**
	 * @param $str
	 *
	 * @return string
	 */
	public static function encode($str){
		//STR: Hello My name is:%Qti3e%;
		//$str = str_replace('%','%3',$str);//STR:Hello My name is:%3Qti3e%3;
		//$str = str_replace(';','%2',$str);//STR:Hello My name is:%3Qti3e%3%2
		//$str = str_replace(':','%1',$str);//STR:Hello My name is%1%3Qti3e%3%2
		return str_replace(['%',';',':'],['%3','%2','%1'],$str);
	}

	/**
	 * @param $str
	 *
	 * @return string
	 */
	public static function decode($str){
		//STR:Hello My name is%1%3Qti3e%3%2
		//$str = str_replace('%1',':',$str);//STR:Hello My name is:%3Qti3e%3%2
		//$str = str_replace('%2',';',$str);//STR:Hello My name is:%3Qti3e%3;
		//$str = str_replace('%3','%',$str);//STR:Hello My name is:%Qti3e%;
		return str_replace(['%1','%2','%3'],[':',';','%'],$str);
	}

	/**
	 * @return string
	 */
	public static function getDb(){
		return self::$dataArray;
	}

	/**
	 * @return array
	 */
	private static function makeArray(){
		preg_match_all('/(.+):(.+);/',self::$dataString,$matches);
		$count = count($matches[0]);
		$return= array();
		for($i = 0;$i < $count;$i++){
			$key = $matches[1][$i];
			$val = $matches[2][$i];
			$return[self::decode($key)] = self::decode($val);
		}
		self::$dataArray = $return;
		return $return;
	}

	/**
	 * @param        $value
	 * @param string $key
	 *
	 * @return array
	 */
	public static function find($value,$key = '.+'){
		preg_match_all('/;('.$key.'):(.+'.preg_quote($value).'.+);/',self::$dataString,$matches);
		$count = count($matches[0]);
		self::$nosql_fetch_count = $count;
		$return = [];
		for($i = 0;$i < $count;$i++){
			$key = $matches[1][$i];
			$val = $matches[2][$i];
			$return[self::decode($key)] = self::decode($val);
		}
		return $return;
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return mixed
	 */
	public static function update($key,$value){
		if(is_array($key)&&is_array($value)){
			if(count($key) != count($value)){
				return false;
			}else{
				$count = count($key);
				$re    = 0;
				for($i = 0;$i < $count;$i++){
					$re += self::update($key[$i],$value[$i]);
				}
				return $re;
			}
		}elseif(is_array($key) && !is_array($value)){
			$count = count($key);
			$re    = 0;
			for($i = 0;$i < $count;$i++){
				$re += self::update($key[$i],$value);
			}
			return $re;
		}elseif(!is_array($key) && !is_array($value)){
			$key = self::encode($key);
			$val = self::encode($value);
			$to  = ';'.$key.':'.$val.';';
			self::$dataString = preg_replace('/;'.preg_quote($key).':.+;/',$to,self::$dataString,-1,$count);
			return $count;
		}
		return false;
	}

	public static function issetKey($key){

	}

	public static function insert() {

	}
}