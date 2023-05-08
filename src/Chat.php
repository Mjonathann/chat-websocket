<?php 
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{

    private $clients;

    public function __construct(){
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn){
        $this->clients->attach($conn);
        printf(PHP_EOL ."Nueva conexion: %s\n", $conn->resourceId);
        $conn->send(json_encode(array('type' => 'message', 'text' => 'Bienvenido a la aplicacion test de chat')));
    }

    public function onClose(ConnectionInterface $conn){
        $this->clients->detach($conn);
        printf(PHP_EOL ."Conecion cerrada : %s\n", $conn->resourceId);
    }

    public function onError(ConnectionInterface $conn, \Exception $error) {
        printf(PHP_EOL ."Error %s\n", $error->getMessage());
        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $message){
        foreach ($this->clients as $client) {
            if ($from == $client) {
                continue;
            }
            $client->send($message);
        }
    }
}