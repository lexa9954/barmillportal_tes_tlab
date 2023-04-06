<?php
	setcookie('name', $user['name'], time() - 3600, "/");
    setcookie('AMEI', $user['amei'], time() - 3600, "/");
	header('Location:../index.php');
?>