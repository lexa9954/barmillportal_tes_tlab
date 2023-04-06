<?php



Start();

function Start(){
    $action = "";
    
    if (!empty($_POST["action"])){
        $action = $_POST["action"];
    
        switch($action){
            case "tableMotors";
                MotorsCreated();
            break;
            case "tableAreas":
                $query_select_areas = "select id,area_name from all_areas";
                CreateTableResultsAreas($query_select_areas);
            break;
        }
    }

    
    

    
    //
}

function MotorsCreated(){
    $pageUrl = $_POST["page"];
    $query_sort_by;
    
    $parts = parse_url($pageUrl);
    parse_str($parts['query'], $params);
    
    $sortMotor;
    if (!empty($_POST["typeSort"]))
        $sortMotor = $_POST['typeSort'];
    
    if($sortMotor !=""){
        $query_sort_by = " order by $sortMotor";
    }
    
    $query_select_motors = "select motors.id_mat'Motor_id_mat',status_name,front_bearing_id'front',rear_bearing_id'rear',motor_objects.motor_id'Motor_id',motor_objects.id'motor_object_id',inventory_num,places_of_aggregates.place 'place',materials.name_mat 'motor',motors.power'power',motors.voltage'voltage',motors.speed'speed',motor_objects.installation_year'year',all_aggregates.aggregete_name 'aggregat' from motor_objects left join places_of_aggregates on places_of_aggregates.id = motor_objects.place_id left join motors on motors.id = motor_objects.motor_id left join all_aggregates on all_aggregates.id=motor_objects.aggregate_id left join all_status on all_status.id=motor_objects.status_id inner join materials on materials.id=motors.id_mat
    $query_sort_by";
    CreateTableResultsMotors($query_select_motors);
}

function CreateTableResultsAreas($query){
    echo "
    <table id=\"main_table\" class=\"tableMats\" style=\"height:99%\" id=\"resultsContent\">
    <thead id=\"material_table_head\" class=\"material_table_head\"
    <tr>
    <th st>
    <div >УЧАСТКИ</div>	
    
    <div style=\"display:flex; width:220px;position: absolute;right: 0px;\">
    <input id=\"area_name_text\" style=\"display:block;width:200px; height:20px;\" type=\"text\" />
    <input type=\"image\" style=\"display:block; width:20px\" src=\"/sklad/sys_img/create.svg\" onclick=\"add_area()\"/></div>

    </th>
    </tr>
    </thead>";
    
    echo "<tbody id=\"containerItems\">";
    
    require "../sql_connect.php";
                    $result = mysqli_query($conn,$query);

    
                    while($row = mysqli_fetch_array($result) ){
                        $classMin = "itemMatTR";
                        
                        echo "
                		<tr id=\"item_area_",$row['id'],"\" class=\"tableRow $classMin\" style=\"display:block;\" onclick=\"select_area(this)\">
                            <td id=\"id_area\" style=\"display:none;\">",$row['id'],"</td>
                            <td id=\"area_name\"class=\"columnStatusRepair\">",$row['area_name'],"</td>
                            </tr>
                        ";
                        $query_select_place = "select id,aggregate_name from all_aggregate_of_areas where area_id=".$row['id'];
                        CreateTableResultPlaceOfAgreagate($query_select_place,$row['id']);
                    }
    echo "</tbody>";
    echo "</table>";
}

function CreateTableResultPlaceOfAgreagate($query,$id_area){
    echo "<td>
    <table id=\"table_aggregate_$id_area\" class=\"tableMats\" style=\"display:none; height:auto\" id=\"resultsContent\">
    <thead id=\"material_table_head\" class=\"material_table_head\">
    <tr>
    <th>
    <div >ОБОРУДОВАНИЯ</div>	
    
    <div style=\"display:flex; width:220px;position: absolute;right: 0px;\">
    <input id=\"aggregate_name_text_$id_area\" style=\"display:block;width:200px; height:20px;\" type=\"text\" />
    <input type=\"image\" style=\"display:block; width:20px\" src=\"/sklad/sys_img/create.svg\" onclick=\"add_aggregate()\"/></div>
    
    </th>
    </tr>
    </thead>";
    
    echo "<tbody id=\"containerItems\">";
    
    require "../sql_connect.php";
                    $result = mysqli_query($conn,$query);

    
                    while($row = mysqli_fetch_array($result) ){
                        $classMin = "itemMatTR";
                        
                        echo "
                		<tr id=\"item_aggr_",$row['id'],"\" class=\"tableRow $classMin\" style=\"display:block;\" onclick=\"select_aggregate(this)\">
                            <td id=\"id_aggregate\" style=\"display:none;\">",$row['id'],"</td>
                            <td id=\"aggregate_name\"class=\"columnStatusRepair\">",$row['aggregate_name'],"</td>
        				</tr>"; 
                        
                        $query_select_equip = "select id,equipment_name from all_equipments_of_aggregate where aggregate_id=".$row['id'];
                        CreateTableResultEquipmentsOfAggregate($query_select_equip,$row['id']);
               	 		
                    }
    
 
    echo "</tbody>";
    echo "</table></td>";
}

function CreateTableResultEquipmentsOfAggregate($query,$id_aggregate){
    echo "<td>
    <table id=\"table_equipments_$id_aggregate\" class=\"tableMats\" style=\"display:none;; height:auto\" id=\"resultsContent\">
    <thead id=\"material_table_head\" class=\"material_table_head\">
    <tr>
    <th>
    <div >АГРЕГАТЫ</div>	
    
    <div style=\"display:flex; width:220px;position: absolute;right: 0px;\">
    <input id=\"equipment_name_text_$id_aggregate\" style=\"display:block;width:200px; height:20px;\" type=\"text\" />
    <input type=\"image\" style=\"display:block; width:20px\" src=\"/sklad/sys_img/create.svg\" onclick=\"add_equipment()\"/></div>
    
    </th>
    </tr>
    </thead>";
    
    echo "<tbody id=\"containerItems\">";
    
    require "../sql_connect.php";
                    $result = mysqli_query($conn,$query);

    
                    while($row = mysqli_fetch_array($result) ){
                        $classMin = "itemMatTR";
                        
                        echo "
                		<tr id=\"item\" class=\"tableRow $classMin\" onclick=\"select_equipment(this)\">
                            <td id=\"id_equipment\" style=\"display:none;\">",$row['id'],"</td>
                            <td id=\"equipment_name\"class=\"columnStatusRepair\">",$row['equipment_name'],"</td>
               	 		</tr>
        				"; 
                    }
    echo "</tbody>";
    echo "</table></td>";
}



/* ▼ Создание таблицы ▼ */
function CreateTableResultsMotors($query){
    echo "
            <table class=\"tableMats\" id=\"resultsContent\">
                <thead id=\"material_table_head\" class=\"material_table_head\">
                	<tr>
                        <th class=\"columnInvNum\">
                            <label  id=\"sortByInvNum\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
							<div >Инв №</div>	
                    	</th>
                        <th class=\"columnPower\">
                        
                            <label  id=\"sortByPower\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
							<div >Мощность</div>	
                    	</th>
                        <th class=\"columnSpeed\">
							<div >Обороты</div>	
                    	</th>
                        
                        <th class=\"columnTypeMotor\">
                            <div >Тип двигателя</div>
                    	</th>
                        <th class=\"columnStatusRepair\">
							<div >Статус</div>	
                    	</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
    require "../sql_connect.php";
                    $result = mysqli_query($conn,$query);

    
                    while($row = mysqli_fetch_array($result) ){
                        $bearing_front_query = "select bearing_name from all_bearings where id =".$row['front'];   
                        $bearing_rear_query = "select bearing_name from all_bearings where id =".$row['rear'];  
                        
                        $res_front = mysqli_query($conn,$bearing_front_query);
                        $res_rear = mysqli_query($conn,$bearing_rear_query);
                        
                        $front_bearing = 0;
                        $rear_bearing = 0;
                        while($front = mysqli_fetch_array($res_front)){
                            $front_bearing = $front['bearing_name'];
                        }
                        while($rear = mysqli_fetch_array($res_rear)){
                            $rear_bearing = $rear['bearing_name'];
                        }
                        
                        $classMin = "itemMatTR";
                        
                        switch($row['status_name']){
                            case "На ремонте":
                                $classMin = "zeroItemMatTR";
                            break;
                            case "Установлен":
                                $classMin = "green";
                            break;
                            case "Резерв":
                                $classMin = "minItemMatTR";
                            break;
                        }
                        
                        echo "
                		<tr id=\"item\" class=\"tableRow $classMin\" onclick=\"selectTd(this)\">
                            <td id=\"id_motor_material\" style=\"display:none;\">",$row['Motor_id_mat'],"</td>
                            <td id=\"id_motor\" style=\"display:none;\">",$row['Motor_id'],"</td>
                            <td id=\"id_voltage\" style=\"display:none;\">",$row['voltage'],"</td>
                            <td id=\"id_speed\" style=\"display:none;\">",$row['speed'],"</td>
                            <td id=\"id_year\" style=\"display:none;\">",$row['year'],"</td>
                            <td id=\"id_bearing_front\" style=\"display:none;\">",$front_bearing,"</td>
                            <td id=\"id_bearing_rear\" style=\"display:none;\">",$rear_bearing,"</td>
                            <td id=\"id_motor_obj\" style=\"display:none;\">",$row['motor_object_id'],"</td>
                            
                            <td class=\"columnInvNum\">F-",$row['inventory_num'],"</td>
                            <td id=\"id_power\" class=\"columnPower\">",$row['power']," кВт</td>
                            <td class=\"columnSpeed\">",$row['speed'],"</td>
                            <td class=\"columnTypeMotor\">",$row['motor'],"</td>
                            <td id=\"columnPlace\" class=\"columnPlaceAgr\" style=\"display:none;\">",$row['place'],"</td>
                            <td id=\"columnAggr\" class=\"columnAggr\" style=\"display:none;\">",$row['aggregat'],"</td>
                            <td id=\"columnAggr\" class=\"columnStatusRepair\">",$row['status_name'],"</td>
                            
               	 		</tr>
        				"; 
                    }
    				echo "
				</tbody>
            </table>";	
}
/* ▲ Создание таблицы ▲ */

?>

<script type="text/javascript">

    /*Сортировка*/
    function sortMotorF(sortName){
        if (sortType.search("desc") != -1) {//слово не найдено
            sortType = sortName;
        }else{
            sortType = sortName+" desc";
        }
        ajaxGenerateTable();
    }
    
</script>