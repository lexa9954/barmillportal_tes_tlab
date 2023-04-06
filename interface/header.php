<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <link rel="icon" href="/img/AMT_warehouse.png" type = "image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <title>AMT BarMill</title>

        <script src="/libs/ajax.js"></script>
        <script src="/libs/print.js"></script>
        <script src="/libs/JsBarcode.all.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="/libs/print.css">
	       <script src="/libs/сhart.js"></script>
    
<!-- 3d model viewer -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.0.0/model-viewer.min.js"></script>

</head>
    
<body id="interface"
  <?php /* присвоение класса "move_right_sidebar" к блоку с id "interface" для фиксации правого сайдбара в случае если при авторизации были введены неверные АMEI и/или пароль */
	 if(!empty($_SESSION['loginError'])){
		 echo "class=\"move_right_sidebar\"";
	 }else{
		 echo "class=\"\"";
	 }
  ?>
>
    
 	<!-- Верхняя полоска -->  
	<header class="header">
        <div class="header_logo">
          	<a href="index.php"><img src="img/logo.svg" alt="LOGO" class="svg-logo"></a>
            <div id="headName" style="margin:0 100px 0 0; color:white;">
                <?php 
                    $page = $_GET['page'];
                    switch($page){
                        case "profile":
                            echo "ПРОФИЛЬ";
                            break;
                        case "":
                            echo "ГЛАВНАЯ";
                            break;
                        case "AllMaterials":
                            echo "МАТЕРИАЛЫ";
                            break;
                        case "AllEngines":
                            echo "ДВИГАТЕЛЯ";
                            break;
                        case "ExamPage":
                            echo "ЭКЗАМЕНЫ";
                            break;
                        default: 
                            echo "ГЛАВНАЯ!";
                            break;
                    }
                ?>
            </div>
        </div> 
	</header>
    
    <script>
        $( document ).ready(function() {
            
            $.ajax({
               type: "POST",
               url: "profile/selectPeople.php",
               data: {action:'findPass'},
               success: function(result){
                   if(result !=''){
                       firstChangePass();
                   }
               }
           });
            
        });
        
        function firstChangePass(){
            alert('Перед началом работы пожалуйста смените первоначальный пароль!');
            close_all_sidebar();
            move_centr_sidebar();
            changingPassForm.style.display = 'block';
        }

    </script>
    