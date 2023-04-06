	<div id="left_sidebar">
 		<!-- Кнопка бургер меню -->  
        <?php
            if(!empty($_COOKIE['name'])){
                echo "<div class=\"toggle-btn\" onclick=\"move_left_sidebar()\">
        	       <span>Menu</span>
    	       </div>";
            }
        ?>

        
        
        <ul>
            <li>
                <li onclick="activDropDown(this);" class="parentLi">Аттестация персонала &#9662
                <ul  id="examDropDown" style="display:none;">
                    <li>
                        <a href="index.php?page=ExamPage&ekzamen=1" onclick="close_all_sidebar()">Электротехнический</a>
                    </li>
                    <li>
                        <a href="index.php?page=ExamPage&ekzamen=2" onclick="close_all_sidebar();">Электротехнологический</a>
                    </li>
                    <li>
                        <a href="index.php?page=ExamPage&ekzamen=3" onclick="close_all_sidebar()">ТБ для электромонтеров</a>
                    </li>
                    <li>
                        <a href="index.php?page=ExamPage&ekzamen=4" onclick="close_all_sidebar()">ТБ для мостового крана</a>
                    </li>
                    <li>
                        <a href="index.php?page=ExamPage&ekzamen=5" onclick="close_all_sidebar()">Электротехнический Каз</a>
                    </li>
                    <li>
                        <a href="index.php?page=ExamPage&ekzamen=6" onclick="close_all_sidebar()">Электротехнологический Каз</a>
                    </li>
                </ul>
                </li>
        </ul>
            
		<ul>
			
                   <!-- WMS Warehouse Management System / Страница о материалах -->
            
                    <?php
            
                    if(empty($_COOKIE['name'])){
                        header('Location:/index.php');
                    }else{
                         
                        require "sql_connect.php";
                        $sql = "SELECT `ceh_name` FROM `all_ceh` where id= ".$_COOKIE['ceh'];
                        $stmt = mysqli_query( $conn, $sql);
                        $ceh = mysqli_fetch_array( $stmt);
                        
                        $sql_wh = "SELECT id,`wh_name` FROM `all_wh` where ceh_id= ".$_COOKIE['ceh'];
                        $stmt = mysqli_query( $conn, $sql_wh);
                        
                        echo "<li onclick=\"activDropDown(this);\" class=\"parentLi\">Склады цеха-".$ceh['ceh_name']." &#9662;
                        <ul id=\"wareAutoDropDown\" style=\"display:none;\" >";
                        
                        while($row = mysqli_fetch_array($stmt)){
                            $id = $row['id'];
                            $wh_name =$row['wh_name'];
                            echo "<li>                
                                <a href=\"index.php?page=AllMaterials&warehouse=".$id."\" onclick=\"close_all_sidebar()\">".$wh_name."</a>
                            </li>";
                        }
                        
                        
                       
                        echo "<li class=\"parentLi\" onclick=\"location.href='index.php?page=EditorWarehouse';\">Создать склад</li>";
                        echo "</ul>";
                        echo "<li class=\"parentLi\" onclick=\"location.href='index.php?page=AllEngines';\">Двигателя-".$ceh['ceh_name']."</li>";
                        //echo "<li class=\"parentLi\" onclick=\"location.href='index.php?page=ierarhyMaterials';\">Иерархия оборудования</li>";
                        echo "<li class=\"parentLi\" onclick=\"location.href='index.php?page=catalogMaterials';\">Каталог материалов</li>";
                    }
                    ?>
		</ul> 	

	</div>	
<script>

    function activDropDown(e){
        const style = getComputedStyle(e.firstElementChild);
        const visible = style.display;
        
        if(visible=="none"){
           e.firstElementChild.style.display = "block";
        }else{
           e.firstElementChild.style.display = "none";
        }
    }
    
</script>