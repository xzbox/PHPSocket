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
namespace lib\network;
use lib\client\js;
use lib\sessions\sessions;
use lib\view\templates;

/**
 * Class Socket
 * @package lib\network
 */
class Socket extends WebSocketServer{
    /**
     * @param $user
     *
     * @return void
     */
    private function sendTemplate($user){
        $this->send($user,js::equal('localStorage.templateHash',templates::md5()));
    }

    /**
     * @param $user
     *
     * @return void
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
        if($get['md5'] !== templates::md5()){

        }
    }

    /**
     * @param $user
     * @param $message
     */
    protected function onMessage($user,$message){

    }

    /**
     * @param $user
     *
     * @return void
     */
    protected function closed($user){

    }

    /**
     * @param $user
     * @param $message
     *
     * @return void
     */
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