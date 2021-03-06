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
use lib\database\DB;
use lib\sessions\sessions;
use lib\sysadmin\sys;
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
        $this->send($user,templates::jsCode());
        $this->send($user,js::jsFunc('iDb.set',['templateHash',templates::md5()]));
    }

    /**
     * @param WebSocketUser $user
     *
     * @return void
     */
    protected function connected($user){
        parse_str(trim($user->headers['get'],'/'),$get);
        if(isset($get['IAMADMIN'])){
            $user->isAdmin  = 1;
        }else{
            $user->sessionId = $get['sessionId'] == undefined ? sessions::create($user) : $get['sessionId'];
            $user->lang      = $get['lang'] == undefined ? default_lang : $get['lang'];
            if($get['sessionId'] == undefined){
                $this->send($user,js::equal('localStorage.sessionId',$user->sessionId));
            }elseif(!sessions::issetId($get['sessionId'])){
                $user->sessionId = sessions::create($user);
                $this->send($user,js::equal('localStorage.sessionId',$user->sessionId));
            }
            if($get['md5'] !== templates::md5()){
                $this->sendTemplate($user);
            }
            $this->send($user,js::jsFunc('iDb.SET_JSON',[DB::GET_JSON()]));
        }
    }

    /**
     * @param WebSocketUser $user
     * @param $input
     */
    protected function onMessage($user,$input){
        /**
         * $- means its a json command
         * #subject:arg means a news (for example:#open:pages/test)
         */
        $message      = substr($input,1);
        switch($input[0]){
            case '$':
                if(!($command = json_decode($message,true))){
                    $this->send($user,'console.error("Error! Command should be in JSON format");');
                    break;
                }elseif(!class_exists($class = '\\commands\\'.$command['command'])){
                    $this->send($user,'console.error("Error! Command not found.");');
                    break;
                }else{
                    if(!empty($re = $class::call($user,$command['data']))){
                        $this->send($user,$re);
                    }
                }
                unset($re);
                break;
            case '#':
                $ex         = explode(':',$message);
                $subject    = $ex[0];
                $arg        = substr($message,strlen($subject)+1);
                unset($ex);
                switch($subject){
                    case 'open':
                        if(class_exists($arg)){
                            $arg::connected($user);
                        }
                        break;
                    case 'closed':
                        if(class_exists($arg)){
                            $arg::closed($user);
                        }
                        break;
                }
                break;
            default:
                $this->send($user,'console.error("Error! Bad Command.");');
                break;
        }
        unset($message);
    }

    /**
     * @param $user
     *
     * @return void
     */
    protected function closed($user){

    }

    /**
     * @param WebSocketUser $user
     * @param $message
     *
     * @return void
     */
    protected function process($user, $message){
        //TODO:RSA
        if($user->isAdmin == 0){
            $this->onMessage($user,$message);
        }else{
            sys::onMessage($user,$message);
        }
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
        @$user->lastMsg = $message;
    }
}