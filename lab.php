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
 *                       Created by AliReza Ghadimi                          *
 *     <http://AliRezaGhadimi.ir>    LO-VE    <AliRezaGhadimy@Gmail.com>     *
 *****************************************************************************/
//helpers
/**
 * @param $string
 *
 * @return string
 */
function addslashes_dq($string){
	return addcslashes($string,'"\\');
}
class test{
	public $addr;
	public function __construct($b = "") {
		$this->addr = $b;
	}

	public static function jsFunc($name,$args = []){
		$count   = count($args);
		$argStr  = '';
		for($i = 0;$i < $count;$i++){
			$argStr .= ',"'.addslashes_dq($args[$i]).'"';
		}
		$code    = $name.'('.substr($argStr,1,strlen($argStr)).');';
		return $code;
	}
	public function __call($name, $arguments) {
		$p = self::jsFunc($this->addr.'.'.$name,$arguments);
		return substr($p,1,strlen($p)-1);
	}
	public function __get($name) {
		return (new test($this->addr.'.'.$name));
	}
	public function __set($name, $value) {
		// TODO: Implement __set() method.
		return $this->addr.'.'.$name.' = "'.addslashes_dq($value).'";';
	}

	public function __toString() {
		// TODO: Implement __toString() method.
		return 'RE:'.substr($this->addr,1,strlen($this->addr)-1);
	}
}
echo ((new test())->bc->s->a("Hi this is my text"));