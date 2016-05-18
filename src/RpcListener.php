<?php
namespace Example;

use ZMQ;
use ZMQSocket;
use ZMQContext;

class RpcListener
{
    /**
     * @var ZMQSocket
     */
    private $socket;

    public function __construct()
    {
        $this->socket = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_REP);
        $this->socket->connect('tcp://127.0.0.1:5554');
    }

    public function __destruct()
    {
        $this->socket->disconnect('tcp://127.0.0.1:5554');
    }

    public function wait($callback)
    {
        $socket = $this->socket;

        for (;;) {
            $data = $socket->recv();

            $respond = false;

            $done = function ($result = null) use ($socket, &$respond) {
                if ($respond) {
                    return;
                }
                $respond = true;
                $socket->send($result);
            };

            $result = $callback($data, $done);
            $done($result);
        }
    }
}
