<?php


//$first_name= filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
//$second_name= filter_var(trim($_POST['second_name']), FILTER_SANITIZE_STRING);
//$last_name= filter_var(trim($_POST['last_name']), FILTER_SANITIZE_STRING);
$tab_num= filter_var(trim($_POST['tab_num']), FILTER_SANITIZE_STRING);
$amei= filter_var(trim($_POST['amei']), FILTER_SANITIZE_STRING);
$pass = "spc-user000";
require "../sql_connect.php";

//$sql = "SELECT login.id,tabnumbersap from login left join peoples on login.people_id=peoples.id where login.pass = "1234""

/*$sql = "insert into login (amei,pass) values ($amei,$pass)"

if($stmt = mysqli_query( $conn, $sql)){
    echo "Ваша заявка на пользователя успешно создана, пожалуйста дождитесь ответа от Адимнистратора!";
}*/

/*
$sqlData = mysqli_fetch_array( $stmt);	
	if($hash_old_pass == $sqlData['pass']){
		unset($_SESSION['wrongPass']);
		$_SESSION['correctPass'] = "Пароль изменён спешно!";
		$sql = "UPDATE login SET pass = '$hash_new_pass' WHERE AMEI = '$AMEI'";
		$stmt = mysqli_query( $conn, $sql);
	}else{
		unset($_SESSION['correctPass']);
		$_SESSION['wrongPass'] = "Пароль не изменён!<br>Так как прежний пароль введён неправильно.";
	}

mysqli_fetch_array($stmt);
header('Location:/index.php?page=profile');
*/
?>
<script>


    
</script>
