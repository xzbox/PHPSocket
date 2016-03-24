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
namespace lib\controller;
use lib\network\Network;
use lib\network\Socket;
use lib\sessions\sessions;

class Controller{
    protected $server;
    public function auto_load($class){
        $file = str_replace("\\","/",$class).'.php';
        if(file_exists($file)){
            require_once($file);
            if(class_exists($class)){
                return true;
            }
        }
        return false;
    }
    public function __construct(){
        spl_autoload_register([$this,"auto_load"]);
    }
    public function run(){
        sessions::$tmp_address = sessions_folder;
        sessions::load();
        printf("Welcome to the WSoc server!\r\nIPv4 Address : %s\r\n",Network::ServerIPv4());
        $this->server = new Socket(socket_addr,socket_port,socket_bufferLength);
        $this->server->run();
    }
}