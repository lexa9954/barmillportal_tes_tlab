<?php
	// Exam Page / Страница о результатах тестиования
?>

<div class="Motor">

<?php
	// Доступ на страницу только после авторизации
	if(empty($_COOKIE['name'])){
    	header('Location:/index.php');
    }
?>
    
    <!-- Доступ на страницу только после авторизации -->

	<!-- Левая колонка с плитками -->
	<div class="WH_left_column">  		   		
   		<!-- Плитка с фотографией и навигационной панелью -->
   		<div class="material_main_panel">
            <form class="material_navigation" action="">
   			<!-- Кнопка отображения информации о двигателе -->
  				<label for="info_chkBox" id="info_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="info_chkBox" disabled>
  					<?php	require "sklad/sys_img/info.svg";?>
					</label>
   			<!-- Кнопка отображения характеристики двигателя --> 
  				<label for="spec_chkBox" id="spec_btn" class="material_nav_btn openTab">
   					<input type="checkbox" id="spec_chkBox" checked>
  					<?php	require "sklad/sys_img/spec.svg";?>
					</label>
            <!-- Кнопка отображения характеристики двигателя --> 
  				<label for="SelectPlace_chkBox" id="SelectPlace_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="SelectPlace_chkBox" checked>
  					<?php	require "sklad/sys_img/spec.svg";?>
					</label>
   			<!-- Кнопка отображения таблицы перемещения материала --> 
  				<label for="trans_chkBox" id="trans_btn" class="material_nav_btn openTab">
   					<input type="checkbox" id="trans_chkBox" checked>
  					<?php	require "sklad/sys_img/edit.svg";?>
					</label>
            <!-- Кнопка отображения графика перемещения материала -->
  				<label for="places_chkBox" id="place_btn" class="material_nav_btn openTab">
   					<input type="checkbox" id="places_chkBox" checked>
  					<?php	require "sklad/sys_img/electricmotor.svg";?>
					</label>
            <!-- Кнопка добавления перемещения материала --> 
  				<label for="status_chkBox" id="status_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="status_chkBox" disabled>
  					<?php	require "sklad/sys_img/status.svg";?>
					</label>
            <!-- Кнопка отображения графика перемещения материала -->
  				<label for="add_chkBox" id="add_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="add_chkBox">
  					<?php	require "sklad/sys_img/create.svg";?>
					</label>
                
			</form>
  			<div  class="material_img">
                <div id="img_motor">
                    
                </div>
                <div style="display: flex; align-items: end; ">
                <!--div style="display: flex; align-items: end; "-->
                     <div style="display: none; width:50px;"><img id="bearing_front_image" src="sklad/sys_img/noimg.jpg"></div>
                     <div style="text-align: center;"><img id="motor_image" src="sklad/sys_img/noimg.jpg"></div>
                     <div style="display: none; width:50px;"><img id="bearing_rear_image" src="sklad/sys_img/noimg.jpg"></div>
                </div>
                
                
   				<div id="Motor_name" style="margin: 0px 0px 10px 0px; text-align:center;">
   					Тип двигателя <!-- Сюда выводить имя выбранного двигателя -->
   				</div> 
			</div>  		  			
   		</div>
   		
   		<!-- Плитка с подробной информацией -->
   		<div class="bar slide hidden" id="info">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/info.svg";?>
				</div>
				<div class="barTitle">Подготовка ремонтной карты</div>
                <div id="infoCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<stackpanel class="barContent" >
                <!-- Контейнер для элементов -->
                <div  id="protocol" name-"protocol" style=" display: none;"></div >
                Замечание по работе<br><textarea id="Zamechanie" style="width:100%; min-width: 300px; max-width: 300px;"></textarea>
                <br>
                Вид ремонта
                <br>
                <form id="type_repairs" ></form>
                <br>
                Причина<br><textarea id="Prichina" style="width:100%; min-width: 300px; max-width: 300px;"></textarea>
                <br>
                Обстоятельство<br><textarea id="Obstoyatelstvo" style="width:100%; min-width: 300px; max-width: 300px;"></textarea>
                <br>
                Где ремонт
                <br>
                <form id="repair_place" ></form>
                <br>
                Дата поломки
                <br>
                <input type="date" id="dateRepair" name="trip-start" value="2022-03-29" style="width:100%;">
                <br>

                <br>
   	            <input type="button" class="knopka" value="Печать ремонтной карты" onclick="print()"/>
			</stackpanel>
   		</div>
        
        <!-- Плитка с характеристиками -->
   		<div class="bar" id="spec">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/spec.svg";?>
				</div>
				<div class="barTitle">Характеристики</div>
				<div id="specCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="specContent">
                <!-- Контейнер для элементов -->
                
                
   				<div id="infoContent"></div>
   			</div>
   		</div>
        <!-- Плитка со статусом -->
   		<div class="bar slide hidden" id="status">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/status.svg";?>
				</div>
				<div class="barTitle">Расположение</div>
				<div id="statusCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="statusContent">
   				<div id="statusContent">

                    <input type="button" class="knopka" value="Изменить расположение" onclick="changePlaceMotor();"/>
                </div>
   			</div>
   		</div>
        <!-- Плитка с добавлением -->
   		<div class="bar slide hidden" id="add">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/create.svg";?>
				</div>
				<div class="barTitle">Добавление</div>
				<div id="addCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="addContent">
                <!-- Контейнер для элементов -->
   				<div id="addContent">
                Инвентарный №
                <br>
                F-<a id="invAdd_num" style="text-decoration-line: underline;">****</a>
                <br>
                <br>
                Год ввода в эксплуатацию:
                <input id="year_input" type="input" style="width:100%"/>
                <br>
                <br>
                Тип двигателя:
                <br>
                <form id="motor_type" ></form>
                <br>
                    <input type="button" class="knopka" value="Добавить" onclick="addMotor();"/>
                </div>
   			</div>
   		</div>
   	</div>
   	
   	<!-- Правая колонка с плитками -->
	<div class="WH_right_column" id="column_review">  		
  		<!-- Плитка с участками и  -->
		<div class="bar" style="overflow: hidden;" id="catalog">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</div>
				<div class="barTitle">Расположение</div>
                            <div style="    display: flex; width: 100px;">
                <input type="button" class="knopka" value="Список" onclick="ajaxGenerateTable();"/>
                <input type="button" class="knopka" value="Схема" onclick="schema();"/>
            </div>
			</div>

            
			<div class="barContent" id="catalogContent">
				<!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->		
			</div>
		</div>  
        <!-- Плитка с двигателями на определенном оборудовании -->
   		<div class="bar " style="overflow: hidden;" id="motor_place">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/electricmotor.svg";?>
				</div>
				<div id="name_select_place" class="barTitle">...</div>
				<div id="motor_placeCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="motorsRequest">
                <!--canvas id="myChart"></canvas-->
            </div>
   		</div>
        <!-- Плитка с полным списком двигателей -->
  		<div class="bar" id="all_motors">
  			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/electricmotor.svg";?>
				</div>
				<div class="barTitle">Все двигателя</div>
				<div id="all_motorsCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="motorsContent">
  				<!-- В данный блок интегрируется "selectedMaterial.php" посредством AJAX -->			
			</div>
  		</div> 
        <!-- Плитка с транзакциями (инф. о перемещении материалов) -->
  		<div class="bar" id="trans">
  			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/edit.svg";?>
				</div>
				<div class="barTitle">История ремонтов</div>
				<div id="transCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="historyRepair">
  				<!-- В данный блок интегрируется "selectedMaterial.php" посредством AJAX -->			
			</div>
  		</div> 
 
   	</div>
</div>

<script type="text/javascript">
    var selRowNow;
    var resultProtocol;
    var docName ="null";
    var sortType = "";
    
    
    //выбраный тип ремонта в ремонтной карте
    var curSelTypeRepairId;
    var curSelTypeRepairName;
    //выбор со списком где ремонт в ремонтной карте
    var curSelPlaceRepairId;
    var curSelPlaceRepairName;
    //выбор со списком где ремонт в ремонтной карте
    var curSelTypeStatusId;
    var curSelTypeStatusName;
    
    $(document).ready(function(){
        window.onload = function() {
          document.querySelector("formChangeImg").reset();
          }
        ajaxGenerateTable();
        ajaxGenerateTableMotors();
    });
    function DocumentReady(){
        //close_all_sidebar();
        window.addEventListener("resize", displayWindowSize);
        displayWindowSize();
        searchPlitkiAndAddEvents();
        //кнопка сортировки по мощности двигателя в таблице
        //sortByPower.addEventListener("click",function(){sortMotorF("motors.power");});
        //кнопка сортировки по мощности двигателя в таблице
        //sortByInvNum.addEventListener("click",function(){sortMotorF("inventory_num");});
        //выпадающий список с видами ремонта при создании ремонтной карты
        $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'generateTypeRepair'},
               success: function(result){
                    type_repairs.innerHTML = result;
                    var selBox = document.getElementById('typeRepairBox');
                    selectTypeRepair(selBox);
               }
           });
        //выпадающий список со статусом
        $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'generateTypeStatus'},
               success: function(result){
                    type_status.innerHTML = result;
               }
           });
        //выпадающий список с местами агрегатов
        $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'generateAllAgr',type:"Add"},
               success: function(result){
                    all_agr.innerHTML = result;
               }
           });
        //выпадающий список с номерами агрегатов
        $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'generateNumAgr',type:"Add"},
               success: function(result){
                    all_num_agr.innerHTML = result;
               }
           });
        //выпадающий список с местами ремонта
        $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'generateRepairPlaces'},
               success: function(result){
                    repair_place.innerHTML = result;
                    var selBox = document.getElementById('placeRepairBox');
                    selectTypeRepair(selBox);
               }
           });
        //Генерация выпадающего списка для добавления нового двигателя 
         $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'generateMotorsType'},
               success: function(result){
                    motor_type.innerHTML = result;
               }
           });
        //Создание нового инвентарного номера
         $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'generateNewInvNum'},
               success: function(result){
                    invAdd_num.innerHTML = result;
               }
           });
    }
    
        //При изменении окна браузера
    function displayWindowSize(){
        let rootCss = document.documentElement;
        var heightMatTable = document.querySelector('#catalogContent').offsetHeight;
        var heightHistoryTable = document.querySelector('#historyRepair').offsetHeight;
        //document.getElementById('resultsContent').setAttribute("style","height:"+(window.innerHeight-510)+"px");
        rootCss.style.setProperty('--transAnim', (heightMatTable/1.5)+"ms");
        //document.getElementById('containerItems').setAttribute("style","height:"+(window.innerHeight-510)+"px");
    }
    
        var selId;
        var selIdMat;
        var selIdMotorObj;
        var selPower;
        var selVoltage ;
        var selSpeed ;
        var selYear ;
        var motor_type_name ;
        var motor_inv_num;
        var motor_bearing_front ;
        var motor_bearing_rear ;
        var selPlaceInstaled ;
    
    var selAreaID;
    var selAggregateID;
    var selEquipmentID;
    
    var curContArea=null;
    var selRowArea = null;
    var curContAggregate=null;
    var selRowAggregate = null;
        /*Выбор персонала в таблице*/
    
    var curAreaName ="";
    var curAggrName ="";
    var curEquipName ="";
    function selectTd(e){
        selId = e.querySelector('#id_motor').innerHTML;
        selIdMat = e.querySelector('#id_motor_material').innerHTML;
        
        selIdMotorObj = e.querySelector('#id_motor_obj').innerHTML;
        var infoContainer = document.querySelector('#infoContent');
        selPower = e.querySelector('#id_power').innerHTML;
        selVoltage = e.querySelector('#id_voltage').innerHTML;
        selSpeed = e.querySelector('#id_speed').innerHTML;
        
        
        if(e.querySelector('#id_year').innerHTML != null){
            selYear = e.querySelector('#id_year').innerHTML;
        }else{
            selYear = 2023;
        }
        
        if(e.querySelector('#columnPlace').innerHTML!=null && e.querySelector('#columnAggr').innerHTML!=null){
           selPlaceInstaled = e.querySelector('#columnPlace').innerHTML+" "+e.querySelector('#columnAggr').innerHTML; 
        }else{
            selPlaceInstaled = "Неизвестно";
        }
        
        
        motor_type_name = e.querySelector('.columnTypeMotor').innerHTML;
        motor_inv_num = e.querySelector('.columnInvNum').innerHTML;
        motor_bearing_front = e.querySelector('#id_bearing_front').innerHTML;
        motor_bearing_rear = e.querySelector('#id_bearing_rear').innerHTML;
        
        imgMat = document.getElementById("motor_image");
        img_bearing_front = document.getElementById("bearing_front_image");
        img_bearing_rear = document.getElementById("bearing_rear_image");
        
        imgMat.src = "sklad/img/"+selIdMat+".png";
        img_bearing_front.src = "Motors/bearing_img/"+motor_bearing_front+".jpg";
        img_bearing_rear.src = "Motors/bearing_img/"+motor_bearing_rear+".jpg";
        
        $( "#img_motor" ).html("");
        imgMat.onerror = function(e) {
            //imgMat.src = "img/error_pictures/noImg.jpg"; 
            $( "#img_motor" ).html( "<model-viewer alt=\"...\" style=\"height:270px;\" src=\"Motors/Models/electric_motor.glb\" shadow-intensity=\"1\" camera-controls touch-action=\"pan-y\" generate-schema></model-viewer>" );
        }
        img_bearing_front.onerror = function(e) {
            img_bearing_front.src = "img/error_pictures/noImg.jpg"; 
        }
        img_bearing_rear.onerror = function(e) {
            img_bearing_rear.src = "img/error_pictures/noImg.jpg"; 
        }
        
        document.cookie = "motorType="+motor_type_name;
        
        $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'selectMotor', idMotor:selId, motorType:motor_type_name},
               success: function(result){
                   infoContainer.innerHTML = result;
               }
           });
        
         var date_now = new Date();
        document.getElementById("dateRepair").value = date_now.toISOString().slice(0,10);
        
        if(selRowNow !=null)
            selRowNow.classList.remove("selected");
        
        selRowNow = e;
        e.classList.add("selected");
        Motor_name.innerHTML = ""+motor_type_name;
        
        info_chkBox.disabled  = false;
        //chart_chkBox.disabled  = false;
        status_chkBox.disabled  = false;
        
        
        ajaxGenerateTableRepairHistory();
    }
    
    function select_area(e){
        selAreaID = e.querySelector('#id_area').innerHTML;
        
        curAreaName = e.querySelector('#area_name').innerHTML;
        document.querySelector('#name_select_place').innerHTML = curAreaName;
        
        /*Открытие и закрытие строчек в таблице*/
        if(curContArea !=null){
            curContArea.style.display = "none";
        }
        
        
        var selContMats = document.getElementById("table_aggregate_"+selAreaID);
        if(selContMats != null){
                selContMats.style.display = "table";
                curContArea = selContMats;
        }
        
        /*Выбор строки в таблице*/
        if(selRowArea !=null)
            selRowArea.classList.remove("selected");
        
        selRowArea = e;
        e.classList.add("selected");
        
        var query_find_mootrs ="select motors.id_mat'Motor_id_mat',status_name,front_bearing_id'front',rear_bearing_id'rear',motor_objects.motor_id'Motor_id',motor_objects.id'motor_object_id',inventory_num,places_of_aggregates.place 'place',materials.name_mat 'motor',motors.power'power',motors.voltage'voltage',motors.speed'speed',motor_objects.installation_year'year',all_aggregates.aggregete_name 'aggregat' from motor_objects left join places_of_aggregates on places_of_aggregates.id = motor_objects.place_id left join motors on motors.id = motor_objects.motor_id left join all_aggregates on all_aggregates.id=motor_objects.aggregate_id left join all_status on all_status.id=motor_objects.status_id inner join materials on materials.id=motors.id_mat where area_id="+selAreaID;
        
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'motorTableGeneration',query:query_find_mootrs},
               success: function(result){
                   $( "#motorsRequest" ).html( result );
               }
           });      
        
    }
    function select_aggregate(e){
        selAggregateID = e.querySelector('#id_aggregate').innerHTML;
        
        curAggrName= e.querySelector('#aggregate_name').innerHTML;
        document.querySelector('#name_select_place').innerHTML = curAreaName+"/"+curAggrName;
        /*Открытие и закрытие строчек в таблице*/
        if(curContAggregate !=null){
            curContAggregate.style.display = "none";
        }

        var selContMats = document.getElementById("table_equipments_"+selAggregateID);
        if(selContMats != null){
                selContMats.style.display = "table";
                curContAggregate = selContMats;
        }
        
        /*Выбор строки в таблице*/
        if(selRowAggregate !=null)
            selRowAggregate.classList.remove("selected");
        
        selRowAggregate = e;
        e.classList.add("selected");
        
        var query_find_mootrs ="select motors.id_mat'Motor_id_mat',status_name,front_bearing_id'front',rear_bearing_id'rear',motor_objects.motor_id'Motor_id',motor_objects.id'motor_object_id',inventory_num,places_of_aggregates.place 'place',materials.name_mat 'motor',motors.power'power',motors.voltage'voltage',motors.speed'speed',motor_objects.installation_year'year',all_aggregates.aggregete_name 'aggregat' from motor_objects left join places_of_aggregates on places_of_aggregates.id = motor_objects.place_id left join motors on motors.id = motor_objects.motor_id left join all_aggregates on all_aggregates.id=motor_objects.aggregate_id left join all_status on all_status.id=motor_objects.status_id inner join materials on materials.id=motors.id_mat where aggr_id="+selAggregateID;
        
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'motorTableGeneration',query:query_find_mootrs},
               success: function(result){
                   $( "#motorsRequest" ).html( result );
               }
           });      
        
    }
    function select_equipment(e){
        selEquipmentID = e.querySelector('#id_equipment').innerHTML;
        
        curEquipName = e.querySelector('#equipment_name').innerHTML;
        document.querySelector('#name_select_place').innerHTML = curAreaName+"/"+curAggrName+"/"+curEquipName;
        
        var query_find_mootrs ="select motors.id_mat'Motor_id_mat',status_name,front_bearing_id'front',rear_bearing_id'rear',motor_objects.motor_id'Motor_id',motor_objects.id'motor_object_id',inventory_num,places_of_aggregates.place 'place',materials.name_mat 'motor',motors.power'power',motors.voltage'voltage',motors.speed'speed',motor_objects.installation_year'year',all_aggregates.aggregete_name 'aggregat' from motor_objects left join places_of_aggregates on places_of_aggregates.id = motor_objects.place_id left join motors on motors.id = motor_objects.motor_id left join all_aggregates on all_aggregates.id=motor_objects.aggregate_id left join all_status on all_status.id=motor_objects.status_id inner join materials on materials.id=motors.id_mat where aggr_id="+selAggregateID+" and equip_id="+selEquipmentID;
        
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'motorTableGeneration',query:query_find_mootrs},
               success: function(result){
                   $( "#motorsRequest" ).html( result );
               }
           });      
        
    }
    
    function add_area(){
        area_name = document.querySelector('#area_name_text').value;
        if (confirm('❗Будет добавлен новый участок: '+area_name)) {
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'addArea',name_area:area_name},
               success: function(result){
                   //alert(result);
                   ajaxGenerateTable();
               }
           });      
        }
    }
    function add_aggregate(){
        aggregate_name = document.querySelector('#aggregate_name_text_'+selAreaID).value;
        if (confirm('❗Будет добавлено новое оборудование: '+aggregate_name+' на участок:'+curAreaName)) {
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'addAgregate',name_aggregate:aggregate_name,area_id:selAreaID},
               success: function(result){
                   //alert(result);
                   ajaxGenerateTable();
               }
           });      
        }
    }
    function add_equipment(){
        equipment_name = document.querySelector('#equipment_name_text_'+selAggregateID).value;
        if (confirm('❗Будет добавлен новый агрегат: '+equipment_name+' на оборудование:'+curAggrName)) {
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'addEquipment',name_equipment:equipment_name,aggregate_id:selAggregateID},
               success: function(result){
                   //alert(result);
                   ajaxGenerateTable();
               }
           });      
        }
    }
    
    const months = ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"];
    function createDocRepairCard(){
        var protocol = document.querySelector('#protocol');
        $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'selectMotorRepairCard', idMotor:selId},
               success: function(result){
                   protocol.innerHTML = result;
                   var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
                    var postHtml = "</body></html>";
                    
                    
                   
                   var inv_numDoc1 = document.getElementById('invNumDoc1');
                   var type_motorDoc1 = document.getElementById('type_motorDoc1');
                   var powerDoc1 = document.getElementById('powerDoc1');
                   var voltageDoc1 = document.getElementById('volatageDoc1');
                   var yearDoc1 = document.getElementById('yearDoc1');
                   var yearVDoc2 = document.getElementById('yearVDoc2');
                   var speedDoc1 = document.getElementById('speedDoc1');
                   
                   var inv_numDoc2 = document.getElementById('invNumDoc2');
                   var type_motorDoc2 = document.getElementById('type_motorDoc2');
                   var powerDoc2 = document.getElementById('powerDoc2');
                   var voltageDoc2 = document.getElementById('volatageDoc2');
                   var speedDoc2 = document.getElementById('speedDoc2');
                   
                   
                    var typeRepairDoc1 = document.getElementById('typeRepairDoc1');
                   var zamechWorkDoc1 = document.getElementById('zamechWorkDoc1');
                   var prichinaDoc1 = document.getElementById('prichinaDoc1');
                    var obstDoc1 = document.getElementById('obstDoc1');
                   var otvetstveniyDoc1 = document.getElementById('otvetstveniyDoc1');
                   var predstavitelDoc1 = document.getElementById('predstavitelDoc1');
                    var otvetstveniyDoc2 = document.getElementById('otvetstveniyDoc2');
                   var predstavitelDoc2 = document.getElementById('predstavitelDoc2');
                   
                   var dayDoc2 = document.getElementById('dayDoc2');
                    var mouthDoc2 = document.getElementById('mouthDoc2');
                   var yearDoc2 = document.getElementById('yearDoc2');
                   var zavodIzgotov = document.getElementById('zavodIzgotovDoc');
                   var placeInstaled = document.getElementById('placeInstaledDoc');
                   var lastRepairDoc = document.getElementById('lastRepairDoc');
                   var dateCrachedDoc = document.getElementById('dateCrachedDoc');
                   
                   
                   
                    var Zamech = document.getElementById("Zamechanie").value;
                    var Prich =document.getElementById("Prichina").value;
                   var Obst = document.getElementById("Obstoyatelstvo").value;
                   
                   
                   inv_numDoc1.innerHTML = motor_inv_num;
                   type_motorDoc1.innerHTML = motor_type_name;
                   powerDoc1.innerHTML = selPower;
                   voltageDoc1.innerHTML = selVoltage;
                   yearDoc1.innerHTML = selYear;
                   yearVDoc2.innerHTML = selYear;
                   speedDoc1.innerHTML = selSpeed;
                   speedDoc1.innerHTML += " Об/мин";
                   typeRepairDoc1.innerHTML = curSelTypeRepairName;
                   zamechWorkDoc1.innerHTML = Zamech;
                   prichinaDoc1.innerHTML = Prich;
                   obstDoc1.innerHTML = Obst;
                   otvetstveniyDoc1.innerHTML = "Ключинский О.С.";
                   predstavitelDoc1.innerHTML = getCookie("last_name")+" "+getCookie("name")[0]+". "+getCookie("second_name")[0]+".";;//смотря кто распечатал
                   otvetstveniyDoc2.innerHTML = "Ключинский О.С.";
                   
                   
                   inv_numDoc2.innerHTML = motor_inv_num;
                   type_motorDoc2.innerHTML = motor_type_name;
                   powerDoc2.innerHTML = selPower;
                   voltageDoc2.innerHTML = selVoltage;
                   speedDoc2.innerHTML = selSpeed;
                    inv_numDoc2.innerHTML = motor_inv_num;
                   placeInstaled.innerHTML = selPlaceInstaled;
                   
                   var now = new Date(document.getElementById("dateRepair").value);
                   
                   //dateCrachedDoc.innerHTML = now.getUTCDate()+"."+now.getUTCMonth+"."+now.getFullYear();
                   
                    dayDoc2.innerHTML = now.getUTCDate();
                   mouthDoc2.innerHTML = months[now.getMonth()];
                   yearDoc2.innerHTML = now.getFullYear();
                   
                   docName = "Инв № ("+motor_inv_num+") Дата ("+dayDoc2.innerHTML+" "+mouthDoc2.innerHTML+" "+yearDoc2.innerHTML+")";
                   var html = preHtml+protocol.innerHTML+postHtml;
                   
                   resultProtocol = html;
               }
           });
    }
    
    function print(){
        var now = new Date(document.getElementById("dateRepair").value);
        
        if (confirm('Вы действительно хотите отправить на ремонт двигатель:\n ◉Тип: '+motor_type_name+'\n ◉Инвентарный №: '+motor_inv_num+'\n🕗Дата отказа: '+now.getUTCDate()+" "+months[now.getMonth()]+" "+now.getFullYear())) {
            
            createDocRepairCard();
            saveHistoryRepair();
            setTimeout(function () {
                        var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(resultProtocol);
                        var saveDocToServer = 'data:application/vnd.ms-word;charset=utf-8,' +resultProtocol;
                        var fileDownload = document.createElement("a");

                        document.body.appendChild(fileDownload);

                        fileDownload.href = source;
                        fileDownload.download = docName+'.doc';
                
                        document.value = fileDownload;
                        
                        var docFileName = docName+'.doc';
                        var docFileContent = fileDownload;
                
                console.log(resultProtocol);
                            $.ajax({
                               type: "POST",
                               url: "Motors/selectedMotor.php",
                               data: {action:'uploadRepairCard', docName:docFileName, docFileCont:saveDocToServer},
                               success: function(result){
                                   console.log(result);
                                   ajaxGenerateTable();
                               }
                           });
                
                        
                
                        fileDownload.click();
                        document.body.removeChild(fileDownload);
                        }, 
                        100);
        }
    }
    
    function saveHistoryRepair(){
        var now = new Date(document.getElementById("dateRepair").value);
        var monthNumber = now.getMonth()+1;
        var strDate = now.getFullYear()+"-"+monthNumber+"-"+now.getUTCDate();
        
        var Prich =document.getElementById("Prichina").value;
        var Obst = document.getElementById("Obstoyatelstvo").value;
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'saveHistoryRepair',date:strDate,type_repair:curSelTypeRepairId,cause:Prich,fact:Obst,place_repair:curSelPlaceRepairId,idMotorObj:selIdMotorObj},
               success: function(result){
                    alert(result);
               }
           });
    }
    
    function changeMotorStatus(){
        var agr = document.getElementById("Places_of_aggregates_input").value;
        var agrNum = document.getElementById("Nums_all_arg_input").value;
        $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'changeMotorStatus',status_id:curSelTypeStatusId,idMotorObj:selIdMotorObj,status_name:curSelTypeStatusName,motor_type:motor_type_name,inv_num:motor_inv_num,agr:agr,agrNum:agrNum},
               success: function(result){
                   alert(result);
                   ajaxGenerateTable();
                   ajaxGenerateTableMotors();
               }
           });
    }
    function changePlaceMotor(){
        if (confirm("Вы хотите переместить двигатель: "+motor_type_name+" Инв. №:"+motor_inv_num+"\nв расположение: "+curAreaName+"/"+curAggrName+"/"+curEquipName)) {
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'changePlaceMotor',idMotorObj:selIdMotorObj,status_name:curSelTypeStatusName,motor_type:motor_type_name,inv_num:motor_inv_num,areaId:selAreaID,aggrId:selAggregateID,equipId:selEquipmentID},
               success: function(result){
                   alert(result);
                   ajaxGenerateTable();
                   ajaxGenerateTableMotors();
               }
           });
                }
    }
    
    function addMotor(){
        var motorType = document.getElementById("motorType_input").value;
        var inv_Num = document.getElementById("invAdd_num").innerHTML;
        var yearM = document.getElementById("year_input").value;

        
        if (confirm('❗Будет добавлен двигатель: '+motorType+'\nИнвентарный №: F-'+inv_Num+"\nВ резерв")) {
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'addMotor',type_motor:motorType,invNum:inv_Num,yearEnter:yearM},
               success: function(result){
                   alert(result);
                   ajaxGenerateTable();
               }
           });      
        }
    }
    
    function schema(){
         $( "#catalogContent" ).html( "" );
    }
    
    function selectTypeRepair(selectBox){
        curSelTypeRepairId = selectBox.options[selectBox.selectedIndex].id;
        curSelTypeRepairName = selectBox.options[selectBox.selectedIndex].value;
    }
    function selectPlaceRepair(selectBox){
        curSelPlaceRepairId = selectBox.options[selectBox.selectedIndex].id;
        curSelPlaceRepairName = selectBox.options[selectBox.selectedIndex].value;
    }
    function selectTypeStatus(selectBox){
        curSelTypeStatusId = selectBox.options[selectBox.selectedIndex].id;
        curSelTypeStatusName = selectBox.options[selectBox.selectedIndex].value;
    }
        
    //Здесь функция скрытие/открытие плиток кнопками навигационной панели под картинкой
    function displayBlockOrNone(_btn,_block,_chk){
        if(_block.parentElement.className != "WH_left_column")
        for(var i =0;i<allRightBlocks.length;i++){
            allRightBlocks[i].classList.add("column_hide");
            if(allRightBlocks[i] != _block.parentElement){
                var allChild = allRightBlocks[i].children;
                for(var j=0;j<allChild.length;j++){
                    if(allChild[j] != _block){
                        var btn = document.getElementById(allChild[j].id+"_btn");
                        var chk = document.getElementById(allChild[j].id+"_chkBox");
                        CloseBar(btn,allChild[j],chk); 
                    }
                }
            }
        }
        _block.parentElement.classList.remove("column_hide");
  			if (_chk.checked) {
    			 _block.classList.remove ('hidden');
                _block.classList.add('slide');
				setTimeout(function () {
      				_block.classList.remove('slide');
    				}, 
					20);
                 _btn.classList.add ('openTab');
			     _btn.classList.remove ('closeTab');
  			} else {
                CloseBar(_btn,_block,_chk);
  			}
        displayWindowSize();
    }
    
    //Поиск и применение действий для кнопок снизу картинки
    function searchPlitkiAndAddEvents(){
        allRightBlocks = document.getElementsByClassName("WH_right_column");
        
        // Управление отображением плитки с информацией о материале
        var info = document.getElementById('info');
        var info_btn = document.getElementById('info_btn');
        info_chkBox.addEventListener("change",function(){displayBlockOrNone(info_btn,info,this);});
        //закртыие панели информации
        infoCloseId.addEventListener("click",function(){CloseBar(info_btn,info,info_chkBox);});
        
        // Управление отображением плитки с характеристиками материала
        var spec = document.getElementById('spec');
        var spec_btn = document.getElementById('spec_btn');
        spec_chkBox.addEventListener("change",function(){displayBlockOrNone(spec_btn,spec,this);});
        //закрытие панели с характеристиками
        specCloseId.addEventListener("click",function(){CloseBar(spec_btn,spec,spec_chkBox); });
        
        // Управление отображением плитки с информацией о перемещении материала
        var trans = document.getElementById('trans');
        var trans_btn = document.getElementById('trans_btn');
        trans_chkBox.addEventListener("change",function(){displayBlockOrNone(trans_btn,trans,this); });
        //закрытие панели транзакций
        transCloseId.addEventListener("click",function(){CloseBar(trans_btn,trans,trans_chkBox); });
        
        // Управление отображением плитки с информацией о перемещении материала
        var places = document.getElementById('all_motors');
        var places_btn = document.getElementById('place_btn');
        places_chkBox.addEventListener("change",function(){displayBlockOrNone(places_btn,places,this); });
        //закрытие панели транзакций
        all_motorsCloseId.addEventListener("click",function(){CloseBar(places_btn,places,places_chkBox); });
        
        // Управление отображением плитки со статусом
        var status = document.getElementById('status');
        var status_btn = document.getElementById('status_btn');
        status_chkBox.addEventListener("change",function(){displayBlockOrNone(status_btn,status,this); });
        //закрытие панели транзакций
        statusCloseId.addEventListener("click",function(){CloseBar(status_btn,status,status_chkBox); });
        
        // Управление отображением плитки с добавлением материала
        var add = document.getElementById('add');
        var add_btn = document.getElementById('add_btn');
        add_chkBox.addEventListener("change",function(){displayBlockOrNone(add_btn,add,this); });
        //закрытие панели транзакций
        addCloseId.addEventListener("click",function(){CloseBar(add_btn,add,add_chkBox); });
        
        // Управление отображением плитки с добавлением материала
        var motor_place = document.getElementById('motor_place');
        var motor_place_btn = document.getElementById('SelectPlace_btn');
        SelectPlace_chkBox.addEventListener("change",function(){displayBlockOrNone(motor_place_btn,motor_place,this); });
        //закрытие панели транзакций
        motor_placeCloseId.addEventListener("click",function(){CloseBar(motor_place_btn,motor_place,SelectPlace_chkBox); });
        
        // Управление отображением плитки с графиком
        //var material_chart = document.getElementById('chart');
        //var material_chart_btn = document.getElementById('chart_btn');
        //chart_chkBox.addEventListener("change",function(){displayBlockOrNone(material_chart_btn,material_chart,this);});
        //закрытие панели графика
        //chartCloseId.addEventListener("click",function(){CloseBar(material_chart_btn,material_chart,chart_chkBox);});
    }
    //Закрытие плиток нажатием на крестик
    function CloseBar(_btn,_block,_chk){
    			_block.classList.add ('slide');
				_block.addEventListener('transitionend', function(e) {
      				_block.classList.add('hidden');
                    
   				 	}, {
     				 capture: false,
    				  once: true,
     				 passive: false
    				});
				_btn.classList.remove ('openTab');
				_btn.classList.add ('closeTab');
        _chk.checked = false;
    }
    
    //Функция для создания таблицы посредством Ajax
    function ajaxGenerateTable(){
        pageUrl= window.location.href;
            $.ajax({
               type: "POST",
               url: "Motors/MotorTableGenerator.php",
               data: {action:"tableAreas",page:pageUrl,typeSort:sortType},
               success: function(result,status,xhr){
                   $( "#catalogContent" ).html( result );
                   
                    var selArea = document.getElementById("table_aggregate_"+selAreaID);
                    if(selArea != null){
                        selArea.style.display = "table";
                        curContArea = selArea;
                    }
                   
                   /*Выбор строки в таблице*/
                    var selAreaRow = document.getElementById("item_area_"+selAreaID);
                    if(selAreaRow !=null)
                        selAreaRow.classList.add("selected");

                    var selAggregate = document.getElementById("table_equipments_"+selAggregateID);
                    if(selAggregate != null){
                        selAggregate.style.display = "table";
                        curContAggregate = selAggregate;
                    }
                   
                   /*Выбор строки в таблице*/
                    var selAggrRow = document.getElementById("item_aggr_"+selAggregateID);
                    if(selAggrRow !=null)
                        selAggrRow.classList.add("selected");
                   
                   DocumentReady();
               }
           });
        

    }
    //Функция для создания таблицы посредством Ajax
    function ajaxGenerateTableMotors(){
        pageUrl= window.location.href;
            $.ajax({
               type: "POST",
               url: "Motors/MotorTableGenerator.php",
               data: {action:"tableMotors",page:pageUrl,typeSort:sortType},
               success: function(result,status,xhr){
                   $( "#motorsContent" ).html( result );
                   DocumentReady();
               }
           });
    }
    function ajaxGenerateTableRepairHistory(){
            $.ajax({
               type: "POST",
               url: "Motors/selectedMotor.php",
               data: {action:'generateHistoryRepair', idMotor:selIdMotorObj},
               success: function(result){
                   $( "#historyRepair" ).html( result );
               }
           });
    }
    
    function changeStatusHistory(id_history,date_repair){
         if (confirm('Отменить ремонт двигателя❓\n ◉Тип: '+motor_type_name+'\n ◉Инвентарный №: '+motor_inv_num+'\n🕗Дата предпологаемого ремонта: '+date_repair)){
            $.ajax({
                   type: "POST",
                   url: "Motors/selectedMotor.php",
                   data: {action:'changeHistoryStatus',idHistory:id_history},
                   success: function(result){
                       alert(result);
                   }
               });
         }
    }
    
    function getCookie(cname) {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }
</script>