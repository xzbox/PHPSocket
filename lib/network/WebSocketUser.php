<?php
namespace lib\network;
class WebSocketUser {

  public $socket;
  public $id;
  public $sessionId;
  public $page;
  public $lastMsg;
  public $lang;
  public $information = array();

  public $handshake = false;

  public $handlingPartialPacket = false;
  public $headers = array(
      'get'                       => null,
      'host'                      => null,
      'connection'                => null,
      'pragma'                    => null,
      'cache-control'             => null,
      'upgrade'                   => null,
      'origin'                    => null,
      'sec-websocket-version'     => null,
      'user-agent'                => null,
      'accept-encoding'           => null,
      'accept-language'           => null,
      'sec-websocket-key'         => null,
      'sec-websocket-extensions'  => null,
  );

  public $partialBuffer = "";
  public $sendingContinuous = false;

  public $partialMessage = "";

  public $hasSentClose = false;

  function __construct($id, $socket) {
    $this->id = $id;
    $this->socket = $socket;
  }
}