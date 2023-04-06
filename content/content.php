<div class="content" style="background: #f5f5f5 ; background-repeat: no-repeat; background-size: 100% 100%;">
<?php
    $page = $_GET['page'];
    
	switch($page){
    	case "profile":
			require "profile/profile.php";
			break;
		case "AllMaterials":
			require "sklad/sklad.php";
			break;
        case "AllEngines":
			require "Motors/MotorPage.php";
			break;
        case "history":
			require "sklad/history.php";
			break;
        case "materialMore":
			require "sklad/materialMore.php";
			break;
		case "ExamPage": 
			require "Exam/ExamPage.php";
			break;
        case "EditorWarehouse":
			require "sklad/EditorWhPage.php";
			break;
        case "ierarhyMaterials":
			require "sklad/ierarhyMaterials.php";
			break;
        case "catalogMaterials":
			require "sklad/sklad.php";
			break;
    	default: 
            require "interface/Centr_content.php";
			echo "<div class=\"text\">WebNavigator:10.21.168.54\nСобственность цеха СПЦ, разработчики Нейштетр А.А. Ключинский О.С.</div>";
			break;
	}
     
    
?>
</div>