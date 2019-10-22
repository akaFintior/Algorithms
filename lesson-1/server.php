<?php
$queue = new SplQueue();
$socket_server = stream_socket_server('tcp://127.0.0.1:8765');
while (1) {
    $socket = stream_socket_accept($socket_server, -1);
    $data = fread($socket, 1024);
    if ($data === "ok") {
        fwrite($socket, $queue->dequeue());
    } else {
        $queue->enqueue($data);
    }
    fclose($socket);
}
fclose($socket_server);