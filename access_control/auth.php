<?php
	session_start();
	$AMEI = filter_var(trim($_POST['amei']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

$hash_pass = $pass;
require "../sql_connect.php";


//$sql = "SELECT log_auth_var.id,amei,first_name,peoples.id'id_people' FROM log_auth_var join peoples on peoples.id=log_auth_var.id_people WHERE AMEI = $AMEI AND Password = '$hash_pass'";
$sql = "SELECT Ceh_id,log_auth_var.id,amei,first_name,last_name, second_name, peoples.id'id_people',Password FROM log_auth_var join peoples on peoples.id=log_auth_var.id_people WHERE AMEI = $AMEI";
$stmt = mysqli_query( $conn, $sql);


if( $stmt === false) {
    //die( print_r( mysqli_connect_error(), true) );
    //die( print_r( sqlsrv_errors(), true) );
}

$user = mysqli_fetch_array( $stmt);
//empty($user['amei'])
	if(!password_verify($hash_pass, $user['Password'])){
        if($user['Password']==$pass){
            unset($_SESSION['loginError']);
            $msg="";
	           //echo $msg;
        }else{
            unset($_SESSION['wrongPass']);
           $_SESSION['correctPass'] = "Пароль изменён спешно!";
           $_SESSION['loginError'] = "Не верный пароль<br>или имя пользователя.";
            $msg = "Не верный пароль или имя пользователя.";
           echo $msg;
            return;
        }
	}else{
	   unset($_SESSION['loginError']);
        $msg = "Добро пожаловать ".$user['first_name']." ".$user['second_name']."!";
	   //echo $msg;
	}
//exit();




setcookie('name', $user['first_name'], time() + 36000, "/");
setcookie('AMEI', $user['amei'], time() + 36000, "/");
setcookie('PeopleID', $user['id_people'], time() + 36000, "/");
setcookie('last_name', $user['last_name'], time() + 36000, "/");
setcookie('second_name', $user['second_name'], time() + 36000, "/");
setcookie('ceh', $user['Ceh_id'], time() + 36000, "/");
//header('Location:../index.php');
?>