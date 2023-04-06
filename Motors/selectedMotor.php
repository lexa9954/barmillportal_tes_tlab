<?php

$action = $_POST['action'];
$curHistoryId;
switch($action){
        //Выбрали двигатель из списка
    case 'selectMotor':
        SelectMotor($_POST['idMotor']);
    break;
        //ремонтная карта выбранного двигателя
    case 'selectMotorRepairCard':
        SelectMotorRepairCard($_POST['idMotor']);
    break;
        //выбор картинки двигателя
    case 'selectMotorImg':
        imgSelMotor($_POST['idMotor']);
    break;
        //генерация типа ремонта
    case "generateTypeRepair":
        GenerateTypeRepair();
    break;
        //генерация статусов
    case "generateTypeStatus":
        GenerateTypeStatus();
    break;
        //генерация мест ремонта
    case "generateRepairPlaces":
        GenerateRepairPlacesCeh();
    break;
        //генерация мест ремонта
    case "generateAllAgr":
        GeneratePlaces_of_aggregates();
    break;
        //генерация мест ремонта
    case "generateNumAgr":
        GenerateNums_all_arg();
    break;
        //сохранение ремонта и запись
    case "saveHistoryRepair":
        saveHistoryRepair($_POST['date'],$_POST['type_repair'],$_POST['cause'],$_POST['fact'],$_POST['place_repair'],$_POST['idMotorObj']);
    break;
        //смена статуса двигателя
    case "changeMotorStatus":
        changeMotorStatus($_POST['status_id'],$_POST['idMotorObj'],$_POST['status_name'],$_POST['motor_type'],$_POST['inv_num']);
    break;
        //
    case "changeHistoryStatus":
        changeHistoryStatus($_POST['idHistory']);
    break;
    case "generateHistoryRepair":
        GenerateHistoryRepair($_POST['idMotor']);
    break;
        
    case "uploadRepairCard":
        uploadDocRepairCard($_POST['docName'],$_POST['docFileCont']);
    break;
    case "downloadRepairCard":
        downloadDoc($_POST['idRepair']);
    break;
    case 'generateMotorsType':
        GenerateTypeMotors();
    break;
    case 'generateNewInvNum':
        GenerateNewInvNum();
    break;
    case 'addMotor':
        AddMotor();
    break;
    case 'addArea':
        AddArea();
    break;
    case 'addAgregate':
        AddAggregate();
    break;
    case 'addEquipment':
        AddEquipment();
    break;
        
    case "createMotor":
        createMotor();
    break;
    case "motorTableGeneration":
        CreateTableResultsMotors($_POST['query']);
    break;
    case "changePlaceMotor":
        changePlaceMotor();
    break;
}


function saveHistoryRepair($dateRepair,$type_repair,$cause,$fact,$place_repair,$idMotorObj){
    $place_repair = 1;
    include   "../sql_connect.php";
    $query_insert = "INSERT INTO `history_motor_repair`(`date_repair`, `typeRepair_id`, `cause`, `fact`, `placeRepair_ceh_id`, `motorObject_id`) VALUES ('$dateRepair',$type_repair,'$cause','$fact',$place_repair,$idMotorObj)";
    
    $query_update = "UPDATE motor_objects SET status_id=10 where id=$idMotorObj";
    
    if (($conn->query($query_insert) && $conn->query($query_update)) === TRUE) {
      echo "✅Готово";
    } else {
      echo "❌Ошибка: " . $sql . "\n" . $conn->error."\n".$query_insert."\n".$query_update;
    }
}

function changeMotorStatus($status_id,$idMotorObj,$status_name,$motor_type,$inv_num){
    include   "../sql_connect.php";
    $agr_name = $_POST["agr"];
    $agrNum_name = $_POST["agrNum"];
    $agr_id=0;
    $numArg_id=0;
    $query_get_agr_id = "select id from all_aggregates where aggregete_name='".$agrNum_name."'";
    $query_get_numAgr_id = "select id from places_of_aggregates where place='".$agr_name."'";


    $stmt = mysqli_query($conn,$query_get_agr_id);
    while($row = mysqli_fetch_array($stmt)){
        $agr_id = $row['id'];
    }
    $stmt = mysqli_query($conn,$query_get_numAgr_id);
    while($row = mysqli_fetch_array($stmt)){
        $numArg_id = $row['id'];
    }
    
    if(strlen($status_id)==0){
        $status_id=0;
    }
    
    $query_update = "UPDATE `motor_objects` SET `status_id`=$status_id where `id`=$idMotorObj";
    
    if(strlen($agrNum_name)>0){
        $query_update = "UPDATE `motor_objects` SET `status_id`=$status_id,`aggregate_id`=$agr_id where `id`=$idMotorObj";
    }
        if(strlen($agr_name)>0){
        $query_update = "UPDATE `motor_objects` SET `status_id`=$status_id,`place_id`=$numArg_id where `id`=$idMotorObj";
    }
    
    if ($conn->query($query_update) === TRUE) {
      echo "✅Готово\nУ двигателя:".$motor_type."\nИнв №:".$inv_num."\nСтатус изменён на ".$status_name;
    } else {
      echo "❌Ошибка: " . $sql . "\n" . $conn->error.$query_update;
    }
}

function changePlaceMotor(){
    include   "../sql_connect.php";
    
    $motor_type = $_POST['motor_type'];
    $inv_num = $_POST['inv_num'];
    $idMotorObj=$_POST['idMotorObj'];

    $area =0;
    $agregate=0;
    $equipment=0;
    if (!empty($_POST["areaId"]))
        $area = $_POST['areaId'];
    if (!empty($_POST["aggrId"]))
        $agregate = $_POST['aggrId'];
    if (!empty($_POST["equipId"]))
        $equipment = $_POST['equipId'];
    
    $query_update = "UPDATE `motor_objects` SET `status_id`=5, `area_id`=$area,`aggr_id`=$agregate,`equip_id`=$equipment  where `id`=$idMotorObj";
    
    if ($conn->query($query_update) === TRUE) {
      echo "✅Готово\nДвигатель:".$motor_type."\nИнв №:".$inv_num."\n перемещён!";
    } else {
      echo "❌Ошибка: " . $sql . "\n" . $conn->error.$query_update;
    }
}

function changeHistoryStatus($idHistory){
    include   "../sql_connect.php";
    $query_update = "UPDATE `history_motor_repair` SET `status`=1 where `id`=$idHistory";
    
    if ($conn->query($query_update) === TRUE) {
      echo "✅Готово";
    } else {
      echo "❌Ошибка: " . $sql . "\n" . $conn->error;
    }
}


function SelectMotor($id){
        include   "../sql_connect.php";
        $query_ = "select materials.name_mat,power,voltage,speed, all_manufacturers.manufacturers_name'manufacturer' from motors left join materials on materials.id=motors.id_mat left join all_manufacturers on all_manufacturers.id=motors.manufacturer_id where motors.id =".$id;
        $stmt = mysqli_query($conn,$query_);
        while($row = mysqli_fetch_array($stmt)){
            echo "Мощность: ".$row['power']." кВт</br> Номенально напряжение: ".$row['voltage']."В</br> Максимальные обороты: ".$row['speed']." Об/мин</br> Производитель: ".$row['manufacturer'];
        }

        mysqli_close($conn);
    }
function SelectMotorRepairCard($id){
        echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/Motors/Motor_docs/RepairMotorCard.html");
    }

function GenerateHistoryRepair($id){
    include   "../sql_connect.php";
        echo "
            <table class=\"tableMats\" id=\"resultsContent\">
                <thead id=\"material_table_head\" class=\"material_table_head\">
                	<tr>
                        <th >
							<div class=\"columnHeader\">Дата</div>	
                    	</th>
                        <th >
							<div class=\"columnHeader\">Вид ремонта</div>	
                    	</th>
                        <th >
                            <div class=\"columnHeader\">Причина</div>
                    	</th>
                        <th >
							<div class=\"columnHeader\">Обстоятельство</div>	
                    	</th>
                        <th >
							<div class=\"columnHeader\">Где ремонт</div>	
                    	</th>
                        <th >
							<div class=\"columnHeader\"></div>	
                    	</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
    require "../sql_connect.php";
    
                $query = "SELECT motor_objects.inventory_num'inv_num', history_motor_repair.id 'id_repair',`date_repair`, name_repair, `cause`, `fact`, ceh_name,status FROM `history_motor_repair` left join all_type_repair on all_type_repair.id=`typeRepair_id` LEFT join all_ceh on all_ceh.id=`placeRepair_ceh_id` left join motor_objects on motor_objects.id=motorObject_id WHERE motorObject_id=$id ORDER BY history_motor_repair.id DESC";
                    $result = mysqli_query($conn,$query);
    
                    $rows = mysqli_num_rows ( $result );
                    if ($rows ==0 )
                        echo "<tr><td>Ремонтов не найдено</td</tr";    
                    $i = 1;
                    while($row = mysqli_fetch_array($result) ){
                        $fileName = "Инв № (".$row['inv_num'].") Дата (".$row['date_repair'].")";
                        
                        if($row['status']==1){
                            echo "
                            <tr id=\"item\" class=\"tableRow zeroItemMatTR\" onclick=\"selectTd(this)\">
                                <td class=\"columnDateRepairH\">",$row['date_repair'],"</td>
                                <td class=\"columnTypeRepairH\">",$row['name_repair'],"</td>
                                <td class=\"columnCauseH\">",$row['cause'],"</td>
                                <td class=\"columnFactH\">",$row['fact'],"</td>
                                <td class=\"columnPlaceCehH\">",$row['ceh_name'],"</td>
                                <td class=\"iconHistoryMotorRepair\">Отменён</td>
                                <td class=\"iconHistoryMotorRepair\"></td>
                            </tr>
                            "; 
        				}else if($i == 1){
                            echo "
                            <tr id=\"item\" class=\"tableRow\" onclick=\"selectTd(this)\">
                                <td class=\"columnDateRepairH\">",$row['date_repair'],"</td>
                                <td class=\"columnTypeRepairH\">",$row['name_repair'],"</td>
                                <td class=\"columnCauseH\">",$row['cause'],"</td>
                                <td class=\"columnFactH\">",$row['fact'],"</td>
                                <td class=\"columnPlaceCehH\">",$row['ceh_name'],"</td>
                                <td class=\"iconHistoryMotorRepair\" > <a href=\"/Motors/repair_cards/".$row['id_repair'].".doc\" download=\"$fileName.doc\">";require "../sklad/sys_img/info.svg";  
                                echo "</a></td>
                                
                                <td class=\"iconHistoryMotorRepair\" onclick=\"changeStatusHistory(".$row['id_repair'].",'".$row['date_repair']."');\">✖</td>
                            </tr>
                            "; 
                        }else{
                                                        echo "
                            <tr id=\"item\" class=\"tableRow\" onclick=\"selectTd(this)\">
                                <td class=\"columnDateRepairH\">",$row['date_repair'],"</td>
                                <td class=\"columnTypeRepairH\">",$row['name_repair'],"</td>
                                <td class=\"columnCauseH\">",$row['cause'],"</td>
                                <td class=\"columnFactH\">",$row['fact'],"</td>
                                <td class=\"columnPlaceCehH\">",$row['ceh_name'],"</td>
                                <td class=\"iconHistoryMotorRepair\" > <a href=\"/Motors/repair_cards/".$row['id_repair'].".doc\" download=\"$fileName.doc\">";require "../sklad/sys_img/info.svg";  
                                echo "</a></td>
                                <td class=\"iconHistoryMotorRepair\"></td>
                            </tr>
                            "; 
                        }
                        $i++;
                    }
    				echo "
				</tbody>
            </table>";	
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
                            <td id=\"columnPlace\" class=\"columnPlaceAgr\"  style=\"display:none;\">",$row['place'],"</td>
                            <td id=\"columnAggr\" class=\"columnAggr\" style=\"display:none;\">",$row['aggregat'],"</td>
                            <td id=\"columnAggr\" class=\"columnStatusRepair\" style=\"display:none;\">",$row['status_name'],"</td>
                            
               	 		</tr>
        				"; 
                    }
    				echo "
				</tbody>
            </table>";	
}
/* ▲ Создание таблицы ▲ */

function GenerateTypeRepair(){ 
    require "../sql_connect.php";
		echo "	
		<select id=\"typeRepairBox\" onchange=\"selectTypeRepair(this);\" style=\"height: 25px; width: -webkit-fill-available\">";
    		$query_select_categor ="select id,name_repair from all_type_repair";
    		$stmt = mysqli_query($conn,$query_select_categor);
	
    		while($row = mysqli_fetch_array($stmt)){
                $id = $row['id'];
                $nameRepair =$row['name_repair'];
				CreateItemStatus($nameRepair,$id);
    		}
    
    		mysqli_close($conn);
        echo "
		</select>";
}


function GenerateTypeMotors(){
        require "../sql_connect.php";
		echo "	
        <input id=\"motorType_input\" type=\"text\"  list=\"typeMotorsBox\" style=\"height: 25px; width: -webkit-fill-available\"/>
		<datalist id=\"typeMotorsBox\" >";
    		$query_select_categor ="select id,name_mat from materials where categor =5018";
    		$stmt = mysqli_query($conn,$query_select_categor);
	
    		while($row = mysqli_fetch_array($stmt)){
                $id = $row['id'];
                $nameRepair =$row['name_mat'];
				CreateItemStatus($nameRepair,$id);
    		}
    
    		mysqli_close($conn);
        echo "
		</datalist>";
}

function GenerateNewInvNum(){
    require "../sql_connect.php";
    $query = "select max(inventory_num)'inv_num' from motor_objects";
    $stmt = mysqli_query($conn,$query);
    while($row = mysqli_fetch_array($stmt)){
        echo ($row["inv_num"]+1);
    }
}

function addMotor(){
    include   "../sql_connect.php";

    $typeMotor = $_POST['type_motor'];
    $idMotor=0;
    $inv_num = $_POST["invNum"];
    $year = $_POST["yearEnter"];
    
    $last_mo_id = 0;
    //SZ160730832
    
    //160634740
    //160634742
    $qSel = "select motors.id'id',id_mat from motors inner join materials on materials.id=motors.id_mat where name_mat = '".$typeMotor."'";
    $stmt = mysqli_query($conn,$qSel);
    
    while($row = mysqli_fetch_array($stmt)){
        $idMotor = $row["id"];
        
        $barcode_gen = "F-".$inv_num." ".$typeMotor;
        $query_insert_mo = "insert into  material_objects (`id_mat`,`barcode_dlc`) values(".$row["id_mat"].",'".$barcode_gen."')";
        mysqli_query($conn,$query_insert_mo);
        $last_mo_id = $conn->insert_id;
    }
    
    $query_update = "insert into motor_objects (motor_id,inventory_num,installation_year,mo_id) values (".$idMotor.",".$inv_num.",".$year.",".$last_mo_id.")";
    
    

    if ($conn->query($query_update) === TRUE) {
      echo "✅Готово";
    } else {
      echo "❌Ошибка: " . $sql . "\n" . $conn->error.$query_update;
    }
}

function addArea(){
    include   "../sql_connect.php";

    $areaName = $_POST['name_area'];
    
    $query_insert = "insert into all_areas (area_name) values ('".$areaName."')";
    
    if ($conn->query($query_insert) === TRUE) {
      echo "✅Готово";
    } else {
      echo "❌Ошибка: " . $sql . "\n" . $conn->error.$query_insert;
    }
}
function addAggregate(){
    include   "../sql_connect.php";

    $aggregateName = $_POST['name_aggregate'];
    $areaId = $_POST['area_id'];
    
    $query_insert = "insert into all_aggregate_of_areas (aggregate_name,area_id	) values ('".$aggregateName."',".$areaId.")";
    
    if ($conn->query($query_insert) === TRUE) {
      echo "✅Готово";
    } else {
      echo "❌Ошибка: " . $sql . "\n" . $conn->error.$query_insert;
    }
}
function addEquipment(){
    include   "../sql_connect.php";

    $equipmentName = $_POST['name_equipment'];
    $aggregateId = $_POST['aggregate_id'];
    
    $query_insert = "insert into all_equipments_of_aggregate (equipment_name,aggregate_id) values ('".$equipmentName."',".$aggregateId.")";
    
    if ($conn->query($query_insert) === TRUE) {
      echo "✅Готово";
    } else {
      echo "❌Ошибка: " . $sql . "\n" . $conn->error.$query_insert;
    }
}

function createMotor(){
    include   "../sql_connect.php";
    $id_mat =  $_POST['id_mat'];
    $power =  $_POST['power'];
    $voltage =  $_POST['voltage'];
    $speed =  $_POST['speed'];
    
    $query_insert = "insert into motors (power,voltage,speed,id_mat) values (".$power.",".$voltage.",".$speed.",".$id_mat.")";
    
    if ($conn->query($query_insert) === TRUE) {
      echo "✅Готово";
    } else {
      echo "❌Ошибка: " . $sql . "\n" . $conn->error.$query_insert;
    }
}


function GenerateTypeStatus(){ 
    require "../sql_connect.php";
		echo "	
		<select id=\"typeStatusBox\" onchange=\"selectTypeStatus(this);\" style=\"height: 25px; width: -webkit-fill-available\">";
    		$query_select_categor ="SELECT `id`, `status_name` FROM `all_status`";
    		$stmt = mysqli_query($conn,$query_select_categor);
	
    		while($row = mysqli_fetch_array($stmt)){
                $id = $row['id'];
                $nameRepair =$row['status_name'];
				CreateItemStatus($nameRepair,$id);
    		}
    
    		mysqli_close($conn);
        echo "
		</select>";
}
function GenerateRepairPlacesCeh(){ 
    require "../sql_connect.php";
		echo "	
		<select id=\"typeStatusBox\" onchange=\"selectPlaceRepair(this);\" style=\"height: 25px; width: -webkit-fill-available\">";
    		$query_select_categor ="SELECT `id`, `ceh_name`, `МВЗ` FROM `all_ceh`";
    		$stmt = mysqli_query($conn,$query_select_categor);
	
    		while($row = mysqli_fetch_array($stmt)){
                $id = $row['id'];
                $nameRepair =$row['ceh_name']." (".$row['МВЗ'].")";
				CreateItemStatus($nameRepair,$id);
    		}
    
    		mysqli_close($conn);
        echo "
		</select>";
}
function GeneratePlaces_of_aggregates(){ 
   require "../sql_connect.php";
    if($_POST['type'] == "Add"){
		echo "	
        <input id=\"Places_of_aggregates_input\" type=\"text\" list=\"Places_of_aggregatesBox\"  style=\"width:100%;\"/>
		<datalist id=\"Places_of_aggregatesBox\" >";
    }else if($_POST['type'] == "Edit"){
		echo "	
        <input id=\"Places_of_aggregates_Edit_input\" type=\"text\" list=\"Places_of_aggregatesBox\"  style=\"width:100%;\"/>
		<datalist id=\"Places_of_aggregatesBox\" >";
    }
    

    $query_select_categor ="SELECT `id`, `place` FROM `places_of_aggregates`";
    $stmt = mysqli_query($conn,$query_select_categor);
	
    while($row = mysqli_fetch_array($stmt)){
            $id = $row['id'];
            $nameRepair =$row['place'];
        CreateItem($nameRepair,$id);
    }
    
    mysqli_close($conn);
        echo "
		</datalist>";
}
function GenerateNums_all_arg(){ 
       require "../sql_connect.php";
    if($_POST['type'] == "Add"){
		echo "	
        <input id=\"Nums_all_arg_input\" type=\"text\" list=\"Nums_all_argBox\"  style=\"width:100%;\"/>
		<datalist id=\"Nums_all_argBox\" >";
    }else if($_POST['type'] == "Edit"){
		echo "	
        <input id=\"Nums_all_arg_Edit_input\" type=\"text\" list=\"Nums_all_argBox\"  style=\"width:100%;\"/>
		<datalist id=\"Nums_all_argBox\" >";
    }
    

    $query_select_categor ="SELECT `id`, `aggregete_name` FROM `all_aggregates`";
    $stmt = mysqli_query($conn,$query_select_categor);
	
    while($row = mysqli_fetch_array($stmt)){
            $id = $row['id'];
            $nameRepair =$row['aggregete_name'];
        CreateItem($nameRepair,$id);
    }
}
function CreateItemStatus($name,$id){
    echo "<option id=\"$id\" value=\"$name\">";
        echo $name;
    echo "</option  >";
}
function CreateItem($name,$id){
    echo "<option id=\"$id\" value=\"$name\">";
        //echo $name;
    echo "</option  >";
}

function uploadDocRepairCard($file_name,$data){
    include   "../sql_connect.php";
    $query_ = "SELECT max(id) FROM history_motor_repair";
    $stmt = mysqli_query($conn,$query_);
    $idRepairCard=0;
    while($row = mysqli_fetch_array($stmt)){
        $idRepairCard = $row['max(id)'];
    }

    mysqli_close($conn);
    
    file_put_contents('repair_cards/'.$idRepairCard.".doc", $data);
    echo "Upload File Complete!";
}


?>