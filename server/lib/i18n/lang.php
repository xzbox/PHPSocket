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
namespace lib\i18n;

/**
 * Class lang
 * @package lib\i18n
 */
class lang{
    protected static $lang = array();
    public static function load(){
        $files = glob('lib/i18n/lang/*.php');
        $count = count($files);
        for($i = 0;$i < $count;$i++){
            $code = substr($files[$i],5,strlen($files[$i])-9);
            self::$lang[$code] = include($files[$i]);
        }
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public static function get($code = default_lang){
        if(self::$lang == array()){
            self::load();
        }
        if(isset(self::$lang[$code])){
            return self::$lang[$code];
        }else{
            return false;
        }
    }
}