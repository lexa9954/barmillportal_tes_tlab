<?php

$action = $_POST['action'];


switch($action){
    case 'addWH':
        addWareHouse($_POST['whName']);
    break;
    case 'addRack':
        addRack($_POST['whId']);
    break;
}

function addWareHouse($name){
    require "../sql_connect.php";
    $curCeh = $_COOKIE["ceh"];
    $sql = "insert into all_wh (wh_name,ceh_id) values ('$name'".",".$curCeh.")";
    
    mysqli_query( $conn, $sql); //Добавили новый склад в базу
    
    echo mysqli_insert_id($conn);//Взяли ИД нового склада
}

function addRack($id_wh){
    require "../sql_connect.php";
    $rname =$_POST["rackName"];
    $cshelves = $_POST["shelvesCount"];
    $place = $_POST["mestoStr"];
    
    $sql = "insert into all_racks (wh_id,rack_name,count_shelves,place) values (".$id_wh.",'".$rname."',".$cshelves.",'".$place."')";
    mysqli_query( $conn, $sql); //Добавили стелажа

}

?>