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
set_time_limit(0);
set_include_path(__DIR__);
include('lib/controller/Controller.php');
include('config.php');
//$controller = new \lib\controller\Controller();
//include('config.php');
/**
 * Test Each Class
 * This is the Unix philosophy:
 *  Write programs that do one thing and do it well.
 *  Write programs to work together.
 *  Write programs to handle text streams, because that is a universal interface.
 */
//echo \lib\database\DB::GET_JSON();

$input  = "Open:News:jgg";
$ex     = explode(':',$input);
$subject= $ex[0];
$ars    = substr($input,strlen($subject)+1);
//var_dump($subject,$ars);

abstract class MyParent{
	public static $name;
	public static function name(){
		self::load();
		return self::$name;
	}
	public static function load(){}
}
class child extends MyParent{
	public static function load(){
		parent::$name = __CLASS__;
	}
}
var_dump(child::name());