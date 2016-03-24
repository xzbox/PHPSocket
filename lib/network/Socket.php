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
namespace lib\network;
use lib\client\js;
use lib\client\js\console;
use lib\sessions\sessions;

class Socket extends WebSocketServer{
    /**
     * @param WebSocketUser $user
     */
    protected function connected($user){
        parse_str(trim($user->headers['get'],'/'),$get);
        $user->sessionId = $get['sessionId'] == undefined ? sessions::create($user) : $get['sessionId'];
        $user->lang      = $get['lang'] == undefined ? default_lang : $get['lang'];
        if($get['sessionId'] == undefined){
            $this->send($user,js::equal('localStorage.sessionId',$user->sessionId));
        }elseif(!sessions::issetId($get['sessionId'])){
            $user->sessionId = sessions::create($user);
            $this->send($user,js::equal('localStorage.sessionId',$user->sessionId));
        }
        $this->send($user,console::log($get['sessionId']));
	    $session = sessions::getByUser($user);
        $session->name = 'alireza';
    }
    protected function onMessage($user,$message){

    }
    protected function closed($user){

    }


    protected function process($user, $message){
        //TODO:RSA
        $this->onMessage($user,$message);
    }

    /**
     * This function has to encrypt all of data
     *  and send them to user and set user's last message.
     * @param WebSocketUser $user
     * @param $message
     */
    public function send($user, $message){
        //TODO:RSA
        parent::send($user, $message);
        $user->lastMsg = $message;
    }
}