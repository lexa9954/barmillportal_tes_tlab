<?php

$allMats = 0;
$selCategor =-1;
$searchOzm ="";
$minQty = "";
$sortMat = "";
$catalogType = "Sklad1";
$pageURL = "";    
$warehouse = 2;

if (!empty($_POST["allMats"]))
    $allMats = $_POST['allMats'];
if (!empty($_POST["categor"]))
    $selCategor = $_POST['categor'];
if (!empty($_POST["searchOzm"]))
    $searchOzm = $_POST['searchOzm'];
if (!empty($_POST["minQty"]))
    $minQty = $_POST['minQty'];
if (!empty($_POST["sort"]))
    $sortMat = $_POST['sort'];

if (!empty($_POST["page"])){
    $pageURL = $_POST['page'];
    $parts = parse_url($pageURL);
    parse_str($parts['query'], $params);
    $warehouse = $params['warehouse'];
}

SelectMats($warehouse,$selCategor,$searchOzm,$minQty,$sortMat,$allMats);
/*Запрос на получение материалов по фильтру*/
function SelectMats($wh,$categor,$search,$min,$sort,$allMat){
    require "../sql_connect.php";


    $query_select_categor ="";
    $query_search_name ="";
    $query_select_min ="";
    $query_sort_by = "";
    
    /*Вывод по категории*/
    if($categor != -1)
        $query_select_categor = "and categor =$categor";
    /*Поиск по озм*/
    if($search !="")
        $query_search_name = "and ozm =$search";
    /*Минимальное кол-во*/
    if($min !=""){
        switch($min){
            case 1:
                $query_select_min = "and material_objects.qty>min ";
            break;
            case 2:
                $query_select_min = "and material_objects.qty<=min ";
            break;
            case 3:
                $query_select_min = "and material_objects.qty=0 ";
            break;
        }
    }
    /**/
    if($sort !=""){
        $query_sort_by = "order by $sort";
    }else{
        $query_sort_by = "order by id desc";
    }
        
    
    $query_select_mats = "select bar_code,materials.id,name_mat,min,max,ozm,sum(qty)'qty',ediniciIzmerenija.ei_name,categories.cg_name, individual,
    (select max(mat_date) from history where mat_id=materials.id and spisanie_or_dobavlenie=1)  'mat_date' 
from materials 
inner join material_objects on materials.id = material_objects.id_mat
inner join ediniciIzmerenija on ediniciIzmerenija.id = materials.ei_id 
inner join categories on categories.id = materials.categor 
where id_wh=$wh 
$query_select_categor $query_search_name $query_select_min  

group by name_mat,ozm,ediniciIzmerenija.ei_name,categories.cg_name,min,max,materials.id  
    $query_sort_by ";
    
    if($allMat == 1){
        $where;
        if($categor != -1){
            $where = "where categor =$categor ";
        }
        
        //$query_select_mats = "SELECT sum(material_objects.qty)`qty`,materials.id`id`, `name_mat`, `bar_code`, `categor`,categories.cg_name, `min`, `max`, `ei_id`, `ozm`,`individual`, `deleted_mat`,ediniciIzmerenija.ei_name FROM `materials` left join ediniciIzmerenija on ediniciIzmerenija.id = materials.ei_id inner join categories on categories.id = materials.categor inner join material_objects on material_objects.id_mat = materials.id $where group by name_mat,ozm,ediniciIzmerenija.ei_name,categories.cg_name,min,max,materials.id  $query_sort_by";
        $query_select_mats = "SELECT sum(material_objects.qty)`qty`,materials.id`id`, `name_mat`, `bar_code`, `categor`,categories.cg_name, `min`, `max`, `ei_id`, `ozm`,`individual`, `deleted_mat`,ediniciIzmerenija.ei_name FROM `materials` left join ediniciIzmerenija on ediniciIzmerenija.id = materials.ei_id left join categories on categories.id = materials.categor left join material_objects on material_objects.id_mat = materials.id $where group by name_mat,ozm,ediniciIzmerenija.ei_name,categories.cg_name,min,max,materials.id  $query_sort_by";
    }
        
    $stmt = mysqli_query($conn,$query_select_mats);
    
     if($allMat == 1){
        CreateTableAllMaterialsCatalog($stmt,$wh);
     }else{
         CreateTableAllMaterials($stmt,$wh);
     }
    
    
    mysqli_close($conn);
}

    
/*Запрос на получение материалов по фильтру*/
function SelectEngines($categor,$search,$min,$sort){
    require "../sql_connect.php";
    
    $query_select_categor ="";
    $query_search_name ="";
    $query_select_min ="";
    $query_sort_by = "";
    /*Вывод по категории*/
    if($categor != -1)
        $query_select_categor = "and categor =$categor";
    /*Поиск по озм*/
    if($search !="")
        $query_search_name = "and ozm =$search";
    /*Минимальное кол-во*/
    if($min !=""){
        switch($min){
            case 1:
                $query_select_min = "and material_objects.qty>min ";
            break;
            case 2:
                $query_select_min = "and material_objects.qty<=min ";
            break;
            case 3:
                $query_select_min = "and material_objects.qty=0 ";
            break;
        }
    }
    /**/
    if($sort !=""){
        $query_sort_by = "order by $sort";
    }
        
    
    $query_select_mats = "select materials.id, inv_num,type_engine,power,status_name,wh_name,ceh_name,agregat_name,hran_name,remPloshadka_name,agregatUzel_name,mesto 
from material_objects 
left join engines on engines.id_mat = material_objects.id_mat
left join status_mat on status_mat.id = material_objects.status
left join all_wh on all_wh.id = material_objects.mesto_wh
left join all_ceh on all_ceh.id = material_objects.mesto_ceh
left join all_agregats on all_agregats.id = material_objects.mesto_agregat
left join all_mesto_hran on all_mesto_hran.id = material_objects.mesto_hran
left join all_remPloshadka on all_remPloshadka.id = material_objects.mesto_rem_ploshadka
left join all_agrUzel on all_agrUzel.id = material_objects.mesto_agregat_uzel
join materials on materials.id = material_objects.id_mat
where categor = 5018 

$query_select_categor $query_search_name $query_select_min 
 
    $query_sort_by";
    CreateTableAllEngines(mysqli_query($conn,$query_select_mats));
    mysqli_close($conn);
}


/* ▼ Создание таблицы ▼ */
function CreateTableAllMaterials($stmt,$wh){
    include "categoriesGenerator.php";
    echo "
            <table class=\"tableMats\">
                <thead id=\"material_table_head\" class=\"material_table_head\">
                	<tr>
                    	<th class=\"columnOZM\">
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"resetSort\">
							
							<label for=\"resetSort\" class=\"resetSort\" onclick=\"close_all_sidebar()\" id=\"resetSort-svg\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/resetSort.svg';	echo "							
							</label>
							
							<label for=\"select2\" class=\"select2\"  onclick=\"show_overlay()\" id=\"searchOZM\">";				
  								require dirname(__FILE__) . '/../sklad/sys_img/searchOZM.svg';	echo "
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"select2\">
							<input type=\"number\" id=\"lname\" name=\"lname\" onkeydown=\"searchOzmEnter(event)\" min=\"111\" max=\"9999999999\">
							</label> 
							
							<div class=\"columnHeader\">ОЗМ</div>	
							<label  id=\"sortByOZM\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						
                    	<th class=\"columnName\">
							<div class=\"columnHeader\">Наименование</div>	
							<label  id=\"sortByName\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						
                    	<th class=\"columnQty\">
							<div class=\"filtr\" onclick=\"show_overlay()\">
    							<label>";
									require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
								</label>";
                                	GenerateQty();
              						echo "
							</div>
							<div class=\"columnHeader\">Количество</div>
							<label id=\"sortByQty\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>							
                    	</th>
						
                        <th class=\"columnEdIzm\">
							<div class=\"columnHeader\">Ед.Изм.</div
						</th>
						
                    	<th class=\"columnCategory\">
    						<div class=\"filtr\" onclick=\"show_overlay()\">					
								<label>";
									require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
								</label>";
                    				GenerateCategories();
              						echo "
							</div>
							<div class=\"columnHeader\">Категория</div>
							<label id=\"sortByCatName\">";
        					    require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "    
							</label>							
                    	</th>
						
                    	<th class=\"columnDate\" >
							<div class=\"columnHeader\">Последнее поступление</div>	
							<label  id=\"sortByDate\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";

                    $rows = mysqli_num_rows ( $stmt );
                    if ($rows ==0 )
                        echo "<tr><td>материал не найден</td</tr";    
    
                    while($row = mysqli_fetch_array($stmt) ){
                        $classMin = "itemMatTR";
                        $date = "";
        				if($row['qty']<=$row['min'] && $row['qty']!=0){
            				$classMin = "minItemMatTR";
        				}else if($row['qty']==0){
            				$classMin = "zeroItemMatTR";
                        }
                        //Проверка на историю
                        if($row['mat_date'] !=null){
                            $date = $row['mat_date'];
                        }
                        echo "
                		<tr id=\"item\" class=\"tableRow $classMin\" onclick=\"selectTd(this)\">
                            <td id=\"id_mat\" style=\"display:none;\">",$row['id'],"</td>
                            <td id=\"columnMin\" style=\"display:none;\">",$row['min'],"</td>
                            <td id=\"columnMax\" style=\"display:none;\">",$row['max'],"</td>
                            <td id=\"columnBarcode\" style=\"display:none;\">",$row['bar_code'],"</td>
                            <td id=\"columnIndividual\" style=\"display:none;\">",$row['individual'],"</td>
                    		<td class=\"columnOZM value\">",$row['ozm'],"</td>					
                    		<td class=\"columnName value\">",$row['name_mat'],"</td>
                    		<td class=\"columnQty value\">",$row['qty'],"</td>
                            <td class=\"columnEdIzm\">",$row['ei_name'],"</td>
                    		<td class=\"columnCategory\">",$row['cg_name'],"</td>
                    		<td class=\"columnDate value\">",$date,"</td>
                            </tr>";
                            
                        if($row['individual']==1){

                            $query_selMat = "select id,qty,barcode_dlc from material_objects where material_objects.id_mat=".$row['id'];
                            require "../sql_connect.php";
                            $id_matsCont = $row['id']."_Cont";
                            echo "<tr id=\"$id_matsCont\" style=\"background-color: darkgrey; display:none;\">
                            <td style=\"margin-left: auto; \">
                            <table class=\"tableMatsObj\" style=\"margin-left: auto; \">";
                        
                            $query_req = mysqli_query($conn,$query_selMat);
                            while($row_selMat = mysqli_fetch_array($query_req)){
                                {
                                    $barcode_gen = $row_selMat['barcode_dlc'];
                                    echo 
                                    "<tr  class=\"tableRow itemMatTR\" id=\"item_matObj\"  onclick=\"selectTdMatObject(this,'".$barcode_gen."');\">
                                        <td id=\"id_mat\" style=\"display:none;\">",$row_selMat['id'],"</td>
                            
                                        <td class=\"columnName value\">",$barcode_gen,"</td>
                                        <td class=\"columnQty value\">",$row_selMat['qty'],"</td>
                                        <td class=\"columnQty value\">-</td>
                                        <td class=\"columnQty value\">-</td>
                                        
                                        <td class=\"columnEdIzm\" >",$row['ei_name'],"</td>
                                     </tr>
                                     ";
                                }
                            }
                            echo "</table></td></tr>";         
                        }
                    }
    				echo "
				</tbody>
            </table>";	
}
/* ▲ Создание таблицы ▲ */

/* ▼ Создание таблицы ▼ */
function CreateTableAllMaterialsCatalog($stmt,$wh){
    include "categoriesGenerator.php";
    echo "
            <table class=\"tableMats\">
                <thead id=\"material_table_head\" class=\"material_table_head\">
                	<tr>

                        <th class=\"columnCategory\">
                        	<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"resetSort\">
							
							<label for=\"resetSort\" class=\"resetSort\" onclick=\"close_all_sidebar()\" id=\"resetSort-svg\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/resetSort.svg';	echo "							
							</label>
                            
    						<div class=\"filtr\" onclick=\"show_overlay()\">					
								<label>";
									require dirname(__FILE__) . '/../sklad/sys_img/filtr.svg';	echo "
								</label>";
                    				GenerateCategories();
              						echo "
							</div>
							<div class=\"columnHeader\">Категория</div>
							<label id=\"sortByCatName\">";
        					    require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "    
							</label>							
                    	</th>
                        
                    	<th class=\"columnOZM\">

							
							<label for=\"select2\" class=\"select2\"  onclick=\"show_overlay()\" id=\"searchOZM\">";				
  								require dirname(__FILE__) . '/../sklad/sys_img/searchOZM.svg';	echo "
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"select2\">
							<input type=\"number\" id=\"lname\" name=\"lname\" onkeydown=\"searchOzmEnter(event)\" min=\"111\" max=\"9999999999\">
							</label> 
							
							<div class=\"columnHeader\">ОЗМ</div>	
							<label  id=\"sortByOZM\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
                        
						
                    	<th class=\"columnName\">
							<div class=\"columnHeader\">Наименование</div>	
							<label  id=\"sortByName\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						

                    	<th class=\"columnQty\">
							<div class=\"columnHeader\">Общее кол-во</div>
							<label id=\"sortByQty\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>							
                    	</th>
                        
                        <th class=\"columnQty\">
							<div class=\"columnHeader\">Резерв план</div>
							<label id=\"sortByQty\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>							
                    	</th>
                        
                        <th class=\"columnQty\">
							<div class=\"columnHeader\">Резерв факт</div>
							<label id=\"sortByQty\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>							
                    	</th>
						
                        <th class=\"columnEdIzm\">
							<div class=\"columnHeader\">Ед.Изм.</div
						</th>
						
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";

                    $rows = mysqli_num_rows ( $stmt );
                    if ($rows ==0 )
                        echo "<tr><td>материал не найден</td</tr";    
    
                    while($row = mysqli_fetch_array($stmt) ){
                        $classMin = "itemMatTR";
                        $date = "";

                        //Проверка на историю
                        if($row['mat_date'] !=null){
                            $date = $row['mat_date'];
                        }
                        echo "
                		<tr id=\"item\" class=\"tableRow $classMin\" onclick=\"selectTd(this)\">
                            <td id=\"id_mat\" style=\"display:none;\">",$row['id'],"</td>
                            <td id=\"columnMin\" style=\"display:none;\">",$row['min'],"</td>
                            <td id=\"columnMax\" style=\"display:none;\">",$row['max'],"</td>
                            <td id=\"columnBarcode\" style=\"display:none;\">",$row['bar_code'],"</td>
                            <td id=\"columnIndividual\" style=\"display:none;\">",$row['individual'],"</td>
                            <td class=\"columnCategory value\">",$row['cg_name'],"</td>
                    		<td class=\"columnOZM value\">",$row['ozm'],"</td>					
                    		<td class=\"columnName value\">",$row['name_mat'],"</td>
                    		<td class=\"columnQty value\" >",$row['qty'],"</td>
                            <td class=\"columnQty value\" >-</td>
                            <td class=\"columnQty value\" >-</td>
                            <td class=\"columnEdIzm\" >",$row['ei_name'],"</td>
                    		
                    		<td class=\"columnDate value\" style=\"display:none;\">>",$date,"</td>
                            </tr>
                            ";
                            
                        if($row['individual']==1){

                            $query_selMat = "select id,qty,barcode_dlc from material_objects where material_objects.id_mat=".$row['id'];
                            require "../sql_connect.php";
                            $id_matsCont = $row['id']."_Cont";
                            echo "<tr id=\"$id_matsCont\" style=\"background-color: darkgrey; display:none;\">
                            <td style=\"margin-left: auto; \">
                            <table class=\"tableMatsObj\" style=\"margin-left: auto; \">";
                        
                            $query_req = mysqli_query($conn,$query_selMat);
                            while($row_selMat = mysqli_fetch_array($query_req)){
                                {
                                    $barcode_gen = $row_selMat['barcode_dlc'];
                                    echo 
                                    "<tr  class=\"tableRow itemMatTR\" id=\"item_matObj\"  onclick=\"selectTdMatObject(this,'".$barcode_gen."');\">
                                        <td id=\"id_mat\" style=\"display:none;\">",$row_selMat['id'],"</td>
                            
                                        <td class=\"columnName value\">",$barcode_gen,"</td>
                                        <td class=\"columnQty value\">",$row_selMat['qty'],"</td>
                                        <td class=\"columnQty value\">-</td>
                                        <td class=\"columnQty value\">-</td>
                                        
                                        <td class=\"columnEdIzm\" >",$row['ei_name'],"</td>
                                     </tr>
                                     ";
                                }
                            }
                            //echo "<tr style=\"justify-content: end;\"><td><input type=\"button\" class=\"knopka\" style=\"cursor:pointer; display:block;\" value=\"Добавить материал\"></td></tr>";
                            echo "</table></td></tr>";         
                        }
                    }
    				echo "
				</tbody>
            </table>";	
}
/* ▲ Создание таблицы ▲ */




?>
<script type="text/javascript">

    /*Сортировка*/
    function sortMats(sortName){
        if (sortType.search("desc") != -1) {//слово не найдено
            sortType = sortName;
        }else{
            sortType = sortName+" desc";
        }
        StartDocument();
    }
    /*Поис по ОЗМ*/
    function searchOzmEnter(e){
        if (e.keyCode === 13) {
            searchOzm();
        }
    }
    function searchOzm(){
            searchMatOzm = document.querySelector('#lname').value;
            if(searchMatOzm.length>9 || searchMatOzm.length<3)
                return;
            StartDocument();
    }
    /*Сброс фильтра*/
    function resetFiltr(){
        //selCatId =-1;
        //minQty = "";
        //sortType = "";
        StartDocument();
    }
    

</script>