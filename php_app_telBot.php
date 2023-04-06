<?php

$bot_id = $_GET['botId'];
$chat_id = "123";
if($_GET['chatId']){
    $chat_id = $_GET['chatId'];
}

$text = $_GET['text'];

require "sql_connect.php";

$url = "https://api.telegram.org/bot$bot_id/sendMessage?chat_id=$chat_id&text=$text";

$sql = "INSERT INTO telegram_commands (bot_id,text,chat_id)
VALUES ('".$bot_id."','".$text."','".$chat_id."')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error . $url;
}

?>