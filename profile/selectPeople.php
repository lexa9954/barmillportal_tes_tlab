<?php

$action = $_POST['action'];
switch($action){
    case "checkPeople":
        selectPeopleFromAmei($_POST['amei']);
    break;
    case "regPeople":
        registrationPeople($_POST['amei'],$_POST['Email'],$_POST['tab_num']);
    break;
    case "findPass":
        findPass();
    break;
    case "changePass":
        changePass($_POST['oldPass'],$_POST['newPass']);
    break;
    case "removePass":
        removePass($_POST['amei']);
    break;
    default:
        echo ".!.";
    break;
}

function selectPeopleFromAmei($amei){
    require "../sql_connect.php";
    $query_ = "select id from peoples where amei=$amei";
    $stmt = mysqli_query($conn,$query_);
    $id="";
    $result="";
    while($row = mysqli_fetch_array($stmt)){
        $id = $row['id'];
    }
    
    if($id!=""){
        $q_active = "select id from log_auth_var where id_people=$id and Activate=1";
        $stmt = mysqli_query($conn,$q_active);

        while($row = mysqli_fetch_array($stmt)){
            $resuld = $row['id'];
            echo "access_auth";
            return;
        }
    }
        $q_request = "select id from all_request_login where enter_amei =$amei";
        $stmt = mysqli_query($conn,$q_request);

        while($row = mysqli_fetch_array($stmt)){
            $resuld = $row['id'];
            echo "request_checking";
            return;
        }
    if($id==""){
        echo "user_not_found";
            return;
    }   
        if($resuld==""){
            echo "request_not_found";
            return;
        }
}

function registrationPeople($amei,$email,$tab_num){
    require "../sql_connect.php";
    
    $q_get_id = "select id from peoples where amei=$amei";
    $stmt = mysqli_query($conn,$q_get_id);
    $id=0;
     
    $pass_gener = randomPassword();
    
    while($row = mysqli_fetch_array($stmt)){
        $id = $row['id'];
    }
    $insert = "insert into log_auth_var (id_people,Password) values ($id,'$pass_gener')";
    mysqli_query($conn,$insert);
    
    $insert_ava = "insert into img_ava (id_people) values ($id)";
    mysqli_query($conn,$insert_ava);
    
    if($tab_num =="")
        $tab_num=0;
        
    $insert_request = "insert into all_request_login (enter_email,enter_amei,enter_tab_num) values ('$email',$amei,$tab_num)";
    if(mysqli_query($conn,$insert_request)){
        echo "Ваша заявка принята, войдите в телеграмм бот  с использованием вашего табельного номера";
    }else{
        echo "Что то пошло не так";
    }
}

function removePass($amei){
    require "../sql_connect.php";
    $q_get_id = "select id from peoples where amei=$amei";
    $stmt = mysqli_query($conn,$q_get_id);
    $id=0;
     
    $pass_gener = randomPassword();
    
    while($row = mysqli_fetch_array($stmt)){
        $id = $row['id'];
    }
    
    $update = "update log_auth_var set activate=0,first_pass=1,password='$pass_gener' where id_people=$id";
        if(mysqli_query($conn,$update)){
        echo "Для продолжения сброса пароля, зайдите в телеграм бота!";
    }else{
        echo "Что то пошло не так";
    }
    
}
function randomPassword() {
    //$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()<>?/-+.";
    $alphabet = "1234567890";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}


function findPass(){
    require "../sql_connect.php";
    
    $amei =$_COOKIE['AMEI'];
    if($amei =='')
        return;
    $query = "select Password from log_auth_var left join peoples on log_auth_var.id_people=peoples.id where amei=$amei and first_pass=1";
    $stmt = mysqli_query($conn,$query);
    while($row = mysqli_fetch_array($stmt)){
        echo $amei;
    }
}

function changePass($oldPass,$newPass){
    require "../sql_connect.php";
    
    $newPassHash = password_hash($newPass, PASSWORD_DEFAULT);
    
    $id_people = $_COOKIE['PeopleID'];
    $amei = $_COOKIE['AMEI'];
    if($amei =='')
        return;
    
    $find_old_pass = "select Password from log_auth_var left join peoples on log_auth_var.id_people=peoples.id where amei=$amei";
    $stmt = mysqli_query($conn,$find_old_pass);
    while($row = mysqli_fetch_array($stmt)){
        if(!password_verify($oldPass,$row['Password'])){
             if($row['Password']!=$oldPass){
                echo 'fail_pass';
                return;   
             }
        }
    }
        
        
    $update_pass = "update log_auth_var set Password = '$newPassHash', first_pass=0 where id_people=$id_people";
    if(mysqli_query($conn,$update_pass)){
        echo "Пароль успешно изменён!";
    }else{
        echo "Что то пошло не так";
    }
}

?>
