<?php

$action = $_POST['action'];
switch($action){
    case 'selectPeople':
        SelectPeople($_POST['idPeople']);
    break;
}

    function SelectPeople($id){
        echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/Protocols/Protocol_TB.html");
    }

?>