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
namespace lib\database;

use lib\client\js;
use lib\client\sender;

/**
 * Class DB
 *
 */
class DB{
	/**
	 * @var null|myRedis
	 */
	public static $DB = null;

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return array|bool|int|string
	 */
	public static function SET($name,$value){
		sender::ToAll(js::jsFunc("iDb.set", [$name,$value]));
		return self::$DB->SET($name,$value);
	}

	/**
	 * @param $name
	 *
	 * @return array|bool|int|string
	 */
	public static function GET($name){
		return self::$DB->GET($name);
	}

	/**
	 * @param $name
	 *
	 * @return array|bool|int|string
	 */
	public static function KEYS($name){
		return self::$DB->KEYS($name);
	}

	public static function GET_JSON(){

	}
}