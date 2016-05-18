<?php
namespace Example;

use ZMQ;
use ZMQSocket;
use ZMQContext;
use ZMQPoll;

class RpcClient
{
    /**
     * @var ZMQSocket
     */
    private $socket;

    public function __construct()
    {
        $this->socket = new ZMQSocket(new ZMQContext(), ZMQ::SOCKET_REQ);
        $this->socket->bind('tcp://127.0.0.1:5554');
    }

    public function __destruct()
    {
        $this->socket->disconnect('tcp://127.0.0.1:5554');
    }

    public function call($data)
    {
        $socket = $this->socket;

        $pool = new ZMQPoll();
        $pool->add($socket, ZMQ::POLL_OUT);

        $res = $pool->poll($r = [], $w = [], 5000);
        if ($res == 0) {
            throw new \RuntimeException("ZeroMQ: send timeout");
        }

        $socket->send($data, ZMQ::MODE_DONTWAIT);

        $pool = new ZMQPoll();
        $pool->add($socket, ZMQ::POLL_IN);

        $res = $pool->poll($r = [], $w = [], 5000);
        if ($res == 0) {
            throw new \RuntimeException("ZeroMQ: recv timeout");
        }

        $res = $socket->recv(ZMQ::MODE_DONTWAIT);

        return $res;
    }
}
