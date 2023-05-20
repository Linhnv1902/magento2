<?php

namespace Linhnv\ChatSystem\Helper;

class Socket
{
    private $server_socket;

    public function __construct($host, $port)
    {
        // Tạo socket mới
        $this->server_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        // Liên kết socket với địa chỉ và cổng
        socket_bind($this->server_socket, $host, $port);

        // Lắng nghe các yêu cầu kết nối từ client
        socket_listen($this->server_socket);
    }

    public function accept()
    {
        return socket_accept($this->server_socket);
    }

    public function close()
    {
        socket_close($this->server_socket);
    }
}
