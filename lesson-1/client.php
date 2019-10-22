<?php
$socket = stream_socket_client('tcp://127.0.0.1:8765');
fwrite($socket, $_POST["message"]);
$message = fgets($socket, 1024);
fclose($socket);
?>
<form action="#" method="post">
    Введите сообщение:
    <input type="text" name="message" required>
    <input type="submit" name="send" value="Отправить">
</form>

<form action="#" method="post">
    <input type="text" name="message" value="ok" hidden>
    <input type="submit" name="send" value="Получить сообщение">
</form>

<div id="answer">Сообщение: <?=$message?></div>
