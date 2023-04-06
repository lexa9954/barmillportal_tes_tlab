<?php
	// WMS Warehouse Management System / Страница о материалах
?>
<div class="WareHouse">

<?php
	// Доступ на страницу только после авторизации
	if(empty($_COOKIE['name'])){
    	header('Location:/index.php');
    }
?>
<!-- Доступ на страницу только после авторизации -->
<script type="text/javascript" src="libs/jquery_barcode/jquery-barcode.js"></script>  
	<!-- Левая колонка с плитками -->
	<div class="WH_left_column">  		   		
   		<!-- Плитка с фотографией и навигационной панелью -->
   		<div class="material_main_panel">
   		<!-- Навигационная панель под картинкой -->
   			<form class="material_navigation" action="">
   			<!-- Кнопка отображения каталога -->
  				<label for="catalog_chkBox" id="catalog_btn" class="material_nav_btn openTab">
  					<input type="checkbox" id="catalog_chkBox" checked>
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</label>
   			<!-- Кнопка отображения информации о материале -->
  				<label for="info_chkBox" id="info_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="info_chkBox" >
  					<?php	require "sklad/sys_img/info.svg";?>
					</label>
   			<!-- Кнопка отображения характеристики материала --> 
  				<label for="spec_chkBox" id="spec_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="spec_chkBox" disabled>
  					<?php	require "sklad/sys_img/spec.svg";?>
					</label>
   			<!-- Кнопка отображения графика перемещения материала -->
  				<label for="chart_chkBox" id="chart_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="chart_chkBox" disabled>
  					<?php	require "sklad/sys_img/chart.svg";?>
					</label>
   			<!-- Кнопка отображения таблицы перемещения материала --> 
  				<label for="trans_chkBox" id="trans_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="trans_chkBox" disabled>
  					<?php	require "sklad/sys_img/trans.svg";?>
					</label>
   			<!-- Кнопка добавления перемещения материала --> 
  				<label for="create_chkBox" id="create_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="create_chkBox" >
  					<?php	require "sklad/sys_img/create.svg";?>
					</label>
   			<!-- Кнопка редактирования перемещения материала --> 
  				<label for="edit_chkBox" id="edit_btn" class="material_nav_btn closeTab">
   					<input type="checkbox" id="edit_chkBox" disabled>
  					<?php	require "sklad/sys_img/edit.svg";?>
					</label>
			</form>
  			
  			<div class="material_img">
   				<img id="material_image" src="sklad/sys_img/noimg.jpg">
   				<div id="material_name">
   					Выберите материал из каталога
   				</div> <!-- Сюда выводить имя выбранного материала -->
			</div>  		  			
   		</div>
   		
   		<!-- Плитка печать этикеток -->
   		<div class="bar  slide hidden" id="info">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/info.svg";?>
				</div>
				<div class="barTitle">Печать этикеток</div>
				<div id="infoCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="infoContent" >
   				<div id="etiketka" style="display:none">
                    <div id="etiketka_back" style=" transform: rotate(180deg); text-align: center; padding: 5px; border-style: solid; border-width: 1px;">
                            <div style="display:flex;">
                                <div style="text-align: left; width:80%;" >
                                <a id="cehPrint">Цех: СПЦ</a><br>
                                <a id="nameMatPrintBack">***</a><br>
                                </div>
                                <img style="width:20%; height:20%;" src="img/ArcelorMittal-Logo.png"/>
                            </div>
                        <svg id="barcode"></svg>	
                    </div>
                    <div id="etiketka_cont" style="text-align: center; padding: 5px; border-style: solid; border-width: 1px;">
                            <div style="display:flex;">
                                <div style="text-align: left; width:80%;" >
                                <a id="cehPrint">Цех: СПЦ</a><br>
                                <a id="nameMatPrint">***</a><br>
                                </div>
                                <img style="width:20%; height:20%;" src="img/ArcelorMittal-Logo.png"/>
                            </div>
                        <svg id="barcode"></svg>	
                    </div>
                </div>
                <div id="etiketka_low" style="display:none">
                    <div id="etiketka_front" style="text-align: center; padding: 5px; border-style: solid; border-width: 1px;">
                        <svg id="barcode"></svg>	    
                        <div style="display:flex;">
                                <div style="text-align: center; width:100%;" >
                                <a id="nameMatPrintLow">***</a><br>
                                </div>
                            </div>
                        
                    </div>
                </div>
                
                Пакет?
                <input id="paket_input" type="checkbox" style=""/><br>
                Длина<br>
                <input id="h_input" type="text" style="width:100%" value="150"/><br>
                Ширина<br>
                <input id="w_input" type="text" style="width:100%" value="300"/><br>
                Количество<br>
                <input id="count_input" type="text" style="width:100%" value="5"/><br><br>
                <input type="button" class="knopka" value="Печать" onclick="printEticetka()"/>
			</div>
   		</div>
   		
   		<!-- Плитка с характеристиками -->
   		<div class="bar slide hidden" id="spec">
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
   				
   			</div>
   		</div>
        
        <!-- Плитка с созданием/добавлением -->
   		<div class="bar slide hidden" id="create">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/create.svg";?>
				</div>
				<div class="barTitle">Добавление / создание</div>
				<div id="creatorCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>		
				</div>
			</div>
			<div class="barContent" id="createContent">
                <input type="checkbox" id="individual_mat" name="subscribe" value="newsletter">
                Индивидуальный
                <br>
                ОЗМ:<br>
                <input id="ozm_input" type="text" value = "0" style="width:100%"/>
                <!--form id="ozm_type" ></form-->
                <br>
                Наименоание:<br><textarea id="name_mat_field" style="width:100%; min-width: 300px; max-width: 300px;"></textarea>
                <br>
                Штрих-код:<br>
                <input id="barcode_input" placeholder="Генерируется" type="text" style="width:100%"/>
                <!--form id="barcodes" ></form-->
                <br>
                Категория:
                <br>
                <form id="categor_type" ></form>
                <br>
                
                <div id="motor_div" style="text-align: right; display:none">
                Мощность (кВт):
                <input id="power_input" type="text" style="width:50%"/><br><br>
                Напряжение:
                <input id="voltage_input" type="text" style="width:50%"/><br><br>
                Обороты:
                <input id="speed_input" type="text" style="width:50%"/><br><br><br>
                </div>
                
                <div style="display:flex;">
                Мин:
                <input id="min_input" type="text" style="width:50%"/>
                Макс:
                <input id="max_input" type="text" style="width:50%"/>
                </div>
                <br>
                Единица измерения:<br>
                <form id="ei_type" style="width:100%"></form>
                <br>
                <br>
   	            <input type="button" class="knopka" value="Добавить" onclick="add_material()"/>
                
            </div>
   		</div>
        
        <!-- Плитка с редактированием -->
   		<div class="bar slide hidden" id="edit">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/edit.svg";?>
				</div>
				<div class="barTitle">Редактирование</div>
				<div id="editorCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="editContent">
                Фото материала:<br>
                <input id="sortpicture" type="file" name="sortpic" accept=".png"/><br>
   				ОЗМ:<br>
                <input id="ozmEdit_input" type="text" style="width:100%"/><br>
                Наименоание:<br><textarea id="nameEdit_input" style="width:100%; min-width: 300px; max-width: 300px;"></textarea>
                <br>
                Штрих-код:<br>
                <input id="barcodeEdit_input"  type="text" style="width:100%"/>
                <br>
                Категория:
                <br>
                <form id="categorEdit_type" ></form>
                <br>
                
                <div style="display:flex;">
                Мин:
                <input id="minEdit_input" type="text" style="width:50%"/>
                Макс:
                <input id="maxEdit_input" type="text" style="width:50%"/>
                </div>
                <br>
                Единица измерения:<br>
                <form id="eiEdit_type" style="width:100%"></form>
                <br>
                <br>
   	            <input type="button" class="knopka" value="Изменить" onclick="edit_material()"/>
                <br>
                <br>
                <div id="addCountMats_div" style="display:none;" >
                <input id="countMats_input" type="text" style="margin: 0 10px 0 0;"/>
                <input type="button" class="knopka" value="Добавить" onclick="addCountMats()"/>
                </div>
   			</div>
            
            <div class="barContent" style="display:none;" id="editContentMatObj">
                Штрих-код:<br>
                <input id="barcodeEditMatObj_input" type="text" style="width:100%"/>
                <br>
                <br>
   	            <input type="button" class="knopka" value="Изменить" onclick="edit_materialObj()"/>
                <br>
   			</div>
   		</div>
   	</div>
   	
   	<!-- Правая колонка с плитками -->
	<div class="WH_right_column" id="column_review">  	
          		<!-- Плитка с каталогом -->
		<div class="bar" id="catalog">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</div>
				<div class="barTitle">Каталог</div>
				        <div id="catalogCloseId" class="barClose">
                    
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="catalogContent">
				<!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->		
			</div>
		</div> 
        
   		<!-- Плитка с графиком -->
   		<div class="bar slide hidden" id="chart">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/chart.svg";?>
				</div>
				<div class="barTitle">График</div>
				<div id="chartCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="chartContent">
                <!--canvas id="myChart"></canvas-->
            </div>
   		</div>
   		
   		<!-- Плитка с транзакциями (инф. о перемещении материалов) -->
  		<div class="bar slide hidden" id="trans">
  			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/trans.svg";?>
				</div>
				<div class="barTitle">История перемещений</div>
				<div id="transCloseId" class="barClose">
  					<?php	require "sklad/sys_img/close.svg";?>				
				</div>
			</div>
			<div class="barContent" id="transContent">
  				<!-- В данный блок интегрируется "selectedMaterial.php" посредством AJAX -->			
			</div>
  		</div> 	
        

   	</div>
</div>

<script type="text/javascript">
    var selAddMatCatId = 0;
    var selCatId =-1;
    var selMatId = 0;
    var selMatObjId = 0;
    var minQty = "";
    var sortType = "";
    var searchMatOzm = "";
    var selRowNow;//выбранная строка в каталоге материалов
    var selMatObjRowNow= null;//выбранная строка в подкаталоге материалов
    var matInfoForGrafic;
    var pageUrl ="";
    var imgMat;
    var allRightBlocks;
    
    var selMatBarcode;
    var selMatName;
    var selMatObjectBarcode;
    
    var curContMats=null;

    $(document).ready(function(){
        StartDocument();
    });
    function DocumentReady(){
        //close_all_sidebar();
        
            
        searchPlitkiAndAddEvents();
        //
        filtrUnselectSelect("selected");
        window.addEventListener("resize", displayWindowSize);
        displayWindowSize();
        
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'generateTypeCategories',type:"Add"},
               success: function(result){
                    categor_type.innerHTML = result;
               }
           });
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'generateTypeEi',type:"Add"},
               success: function(result){
                    ei_type.innerHTML = result;
               }
           });
        
    }
    //Поиск элементов в таблице всех материалов
    function searchElementsAllMaterialsTable(){
        select2.addEventListener("click", searchOzm);
        /*Инициализация кнопок для сортировки*/
        sortByName.addEventListener("click",function(){sortMats("name_mat");});
        sortByDate.addEventListener("click",function(){sortMats("mat_date");});
        sortByCatName.addEventListener("click",function(){sortMats("cg_name");});
        sortByQty.addEventListener("click",function(){sortMats("qty");});
        sortByOZM.addEventListener("click",function(){sortMats("ozm");});
        resetSort.addEventListener("click",resetFiltr);
    }
        //Поиск элементов в таблице всех материалов
    function searchElementsAllMaterialsCatalogTable(){
        select2.addEventListener("click", searchOzm);
        /*Инициализация кнопок для сортировки*/
        sortByName.addEventListener("click",function(){sortMats("name_mat");});
        sortByCatName.addEventListener("click",function(){sortMats("cg_name");});
        sortByOZM.addEventListener("click",function(){sortMats("ozm");});
        resetSort.addEventListener("click",resetFiltr);
    }
    //Поиск и применение действий для кнопок снизу картинки
    function searchPlitkiAndAddEvents(){
        allRightBlocks = document.getElementsByClassName("WH_right_column");
        // Управление отображением плитки с каталогом (таблица материалов)
        var catalog = document.getElementById('catalog');
        var catalog_btn = document.getElementById('catalog_btn');
        catalog_chkBox.addEventListener("change",function(){displayBlockOrNone(catalog_btn,catalog,this);});
        //закрытие панели с каталогом 
        catalogCloseId.addEventListener("click",function(){CloseBar(catalog_btn,catalog,catalog_chkBox);});
        
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
        
        // Управление отображением плитки с графиком
        var material_chart = document.getElementById('chart');
        var material_chart_btn = document.getElementById('chart_btn');
        chart_chkBox.addEventListener("change",function(){displayBlockOrNone(material_chart_btn,material_chart,this);});
        //закрытие панели графика
        chartCloseId.addEventListener("click",function(){CloseBar(material_chart_btn,material_chart,chart_chkBox);});
        
        // Управление отображением плитки с информацией о перемещении материала
        var trans = document.getElementById('trans');
        var trans_btn = document.getElementById('trans_btn');
        trans_chkBox.addEventListener("change",function(){displayBlockOrNone(trans_btn,trans,this); });
        //закрытие панели транзакций
        transCloseId.addEventListener("click",function(){CloseBar(trans_btn,trans,trans_chkBox); });
        
        // Управление отображением плитки с информацией о перемещении материала
        var create = document.getElementById('create');
        var create_btn = document.getElementById('create_btn');
        create_chkBox.addEventListener("change",function(){displayBlockOrNone(create_btn,create,this); });
        //закрытие панели транзакций
        creatorCloseId.addEventListener("click",function(){CloseBar(create_btn,create,create_chkBox);});
        
        // Управление отображением плитки с информацией о перемещении материала
        var edit = document.getElementById('edit');
        var edit_btn = document.getElementById('edit_btn');
        edit_chkBox.addEventListener("change",function(){displayBlockOrNone(edit_btn,edit,this);});
        //закрытие панели транзакций
        editorCloseId.addEventListener("click",function(){CloseBar(edit_btn,edit,edit_chkBox);});
    }
    
    function DynamicMargin(parentTableId,lastColumnClass){
        var vs = parentTableId.scrollHeight > parentTableId.clientHeight; 
        if(!vs){
            var items = parentTableId.querySelectorAll("."+lastColumnClass);
            for(var i=0;i<items.length;i++){
                items[i].style.marginRight = "8px";
            }
        }
    }

    
    //При изменении окна браузера
    function displayWindowSize(){
        //let rootCss = document.documentElement;
        //var heightMatTable = document.querySelector('#catalogContent').offsetHeight;
        document.getElementById('catalogContent').setAttribute("style","height:"+(window.innerHeight-200)+"px");
        //rootCss.style.setProperty('--transAnim', (heightMatTable/1.5)+"ms");
        document.getElementById('containerItems').setAttribute("style","height:"+(window.innerHeight-200)+"px");
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
				setTimeout(function () {
      				_block.classList.remove('slide');
    				}, 
					20);
                //_block.classList.remove('slide');
                 _btn.classList.add ('openTab');
			     _btn.classList.remove ('closeTab');
  			} else {
                CloseBar(_btn,_block,_chk);
  			}
        createGrafik(matInfoForGrafic);
        displayWindowSize();
    }
    //Закрытие плиток нажатием на крестик
    function CloseBar(_btn,_block,_chk){
            setTimeout(function () {
     				_block.classList.add('slide');
    				}, 
					20);
    			//_block.classList.add ('slide');
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
    
    /*Выбор материала в таблице*/
    function selectTd(e){
        
        selMatObjectBarcode="";
        
		// ?? элементов с классом .itemNameTD я не нашел !!
        
        var editContent = document.getElementById("editContent");
        editContent.style.display = "block";
        var editContentMatObj = document.getElementById("editContentMatObj");
        editContentMatObj.style.display = "none";
        
        selMatName = e.querySelector('.columnName').innerHTML;
        selMatId = e.querySelector('#id_mat').innerHTML;
        var nameMatPrint = document.getElementById("nameMatPrint");
        var nameMatPrintBack = document.getElementById("nameMatPrintBack");
        var nameMatPrintLow = document.getElementById("nameMatPrintLow");
        imgMat = document.getElementById("material_image");
        
        SelectMaterial(selMatId,selMatName);
        
        switch(pageUrl){
            //если это страница с материалами
            case "http://mst-app18/index.php?page=AllMaterials":
                SelectMaterial(selMatId,selMatName);
            break;
            //если это страница с двигателями
            case "http://mst-app18/index.php?page=AllEngines":
                
            break;
        }
        
        if(curContMats !=null){
            curContMats.style.display = "none";
        }

        
        var selContMats = document.getElementById(selMatId+'_Cont');
        if(selContMats != null){
            selContMats.style.display = "block";
            curContMats = selContMats;
        }
        


        trans_chkBox.disabled  = false;
        chart_chkBox.disabled  = false;
        spec_chkBox.disabled  = false;
        edit_chkBox.disabled  = false;
        
        if(selRowNow !=null)
            selRowNow.classList.remove("selected");
        
        selRowNow = e;
        e.classList.add("selected");
        material_name.innerHTML = selMatName;
        nameMatPrint.innerHTML = selMatName;
        nameMatPrintBack.innerHTML = selMatName;
        nameMatPrintLow.innerHTML = selMatName;
        
        //плитка для редактирования материала
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'generateTypeCategories',type:"Edit"},
               success: function(result){
                   categorEdit_type.innerHTML = result;
               }
           });
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'generateTypeEi',type:"Edit"},
               success: function(result){
                   eiEdit_type.innerHTML = result;
               }
           });
        
    setTimeout(function () {
        var ozmE = document.getElementById("ozmEdit_input");
        var nameMatE = document.getElementById("nameEdit_input");
        var barcodeE = document.getElementById("barcodeEdit_input");
        var categorE_mat = document.getElementById("categorEdit_input");
        var minE_mat = document.getElementById("minEdit_input");
        var maxE_mat = document.getElementById("maxEdit_input");
        var eiE_mat = document.getElementById("eiEdit_input");
        
        var countMats = e.querySelector("#columnIndividual").innerHTML;
        var addCount_div = document.getElementById("addCountMats_div");

        
        ozmE.value = e.querySelector('.columnOZM').innerHTML;
        nameMatE.value = e.querySelector('.columnName').innerHTML;
        barcodeE.value = e.querySelector('#columnBarcode').innerHTML;
        categorE_mat.value = e.querySelector('.columnCategory').innerHTML;
        minE_mat.value = e.querySelector('#columnMin').innerHTML;
        maxE_mat.value = e.querySelector('#columnMax').innerHTML;
        eiE_mat.value = e.querySelector('.columnEdIzm').innerHTML;
        
        document.cookie = "id_material="+selMatId;
        document.cookie = "id_material="+selMatId;
        
        if(countMats==1){
           addCount_div.style.display = "flex";
           }else{
           addCount_div.style.display = "none";
           }
        
            }, 
        100);
    }
    function selectTdMatObject(e,barcode){
        var editContent = document.getElementById("editContent");
        editContent.style.display = "none";
        var editContentMatObj = document.getElementById("editContentMatObj");
        editContentMatObj.style.display = "block";
        
        var barcodeE = document.getElementById("barcodeEditMatObj_input");
        barcodeE.value = barcode;
        
        selMatObjId = e.querySelector('#id_mat').innerHTML;
        
        selMatObjectBarcode = barcode;
        if(selMatObjRowNow !=null)
            selMatObjRowNow.classList.remove("selected");
        
        selMatObjRowNow = e;
        e.classList.add("selected");
    }
    
    function SelectMaterial(selIdMat,selNameMat){
        console.log("Select Material Graph");
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'infoMatGrafic', idMat:selIdMat},
               success: function(result){
                   matInfoForGrafic = result;
                    createGrafik(result);
                   console.log("Success Select Material Graph");
                   DocumentReady();
               }
           });
        console.log("Select Material Image");
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'imgSelMat', idMat:selIdMat},
               success: function(result){
                    imgMat.src = "sklad/img/"+selIdMat+".png";
                    
                    
                    imgMat.onerror = function(e) {
                       imgMat.src = "img/error_pictures/noImg.jpg"; 
                    }
                   
                    console.log("Success Select Material Image!");
               }
           });
        console.log("Generate Table Transaction");
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'CreateTableTransaction', idMat:selIdMat},
               success: function(result){
                   $( "#transContent" ).html( result );
                   console.log("Success Generate Table Transaction!");
               }
           });
        
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'getBarcode', idMat:selIdMat},
               success: function(result){
                   selMatBarcode=result;
                   JsBarcode("#barcode", result, {
                      width: 1,
                      height: 20,
                       fontSize: 10
                    });
               }
           });
        
        
    }
    
    /*Функция запускается при прогрузке страницы*/
    function StartDocument(){
        pageUrl= window.location.href;
        alert(window.location.search);
        if(pageUrl == "http://mst-app18/index.php?page=catalogMaterials"){
            getAllMats();
           }else{
            ajaxGenerateTable();
           }
    }
    
    

    function getAllMats(){
            $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {page:pageUrl,allMats:"1",searchOzm:searchMatOzm,sort:sortType,categor:selCatId, minQty:minQty},
            
               success: function(result,status,xhr){
                   $( "#catalogContent" ).html( result );
                   console.log("Success Generate Table Materials!");
                   DocumentReady();
                   searchElementsAllMaterialsCatalogTable();    
               }
           });
    }
    //Функция для создания таблицы посредством Ajax
    function ajaxGenerateTable(){
        pageUrl= window.location.href;
        console.log("Generate Table Materials");
            $.ajax({
               type: "POST",
               url: "sklad/tableGeneratorMaterials.php",
               data: {page:pageUrl, searchOzm:searchMatOzm,sort:sortType,categor:selCatId, minQty:minQty},
               success: function(result,status,xhr){
                   $( "#catalogContent" ).html( result );
                   console.log("Success Generate Table Materials!");
                   DocumentReady();
                   searchElementsAllMaterialsTable();
               }
           });
    }
    
    //Функция создания панели для создания материалов
    function creatorMaterials(){
        pageUrl= window.location.href;
        console.log("Create Materials");
            $.ajax({
               type: "POST",
               url: "sklad/creatorPanel.php",
               data: {page:pageUrl},
               success: function(result,status,xhr){
                   $( "#createContent" ).html( result );
                   console.log("Success Create Materials!");
                   DocumentReady();
               }
           });
    }
    /*Рисуем график*/
    function createGrafik(selMatInfo){
        var oldCanvas = document.getElementById("chartContent");
        oldCanvas.innerHTML = '';
        
        var tag = document.createElement("canvas");
        tag.id = "myChart";
        var element = document.getElementById("chartContent");
        element.appendChild(tag);
        
        
        var infoMat = selMatInfo;
        var ctx = document.querySelector('#myChart');
        
        
        var chart = document.getElementById('myChart').getContext('2d'),
    		gradientSpisanie = chart.createLinearGradient(0, 0, 0, 450),
    		gradientVnesenie = chart.createLinearGradient(0, 0, 0, 450),
    		gradientQty = chart.createLinearGradient(0, 0, 0, 450);
        
		gradientSpisanie.addColorStop(0, 'rgba(55, 178, 255, 0.5)');
		gradientSpisanie.addColorStop(0.5, 'rgba(55, 178, 255, 0.2)');
		gradientSpisanie.addColorStop(1, 'rgba(55, 178, 255, 0)');
		
		gradientVnesenie.addColorStop(0, 'rgba(40, 41, 51, 0.5)');
		gradientVnesenie.addColorStop(0.5, 'rgba(40, 41, 51, 0.2)');
		gradientVnesenie.addColorStop(1, 'rgba(40, 41, 51, 0)');
		
		gradientQty.addColorStop(0, 'rgba(255, 0,0, 0.5)');
		gradientQty.addColorStop(0, 'rgba(255, 0,0, 0.5)');
		gradientQty.addColorStop(0.5, 'rgba(255, 0, 0, 0.2)');
		gradientQty.addColorStop(1, 'rgba(255, 0, 0, 0.2)');
		 
		var res = infoMat.split(";");

        var _sod =new Array();
        var _date = new Array();
        var _qty =  new Array();
        var qtyNow = 0;
        var _qtyS = new Array();
        var _qtyV = new Array();
        var _min= new Array();
        var _max= new Array();
        
        for(var i=0;i<res.length-1;i++){
            _sod.push(res[i].split(" ")[0]);
            _date.push(res[i].split(" ")[1]);
            if(_sod[i]==0){
               _qtyS.push(res[i].split(" ")[3]);
                _qtyV.push(0);
                qtyNow -=Number(res[i].split(" ")[3]);
                
            }else{
                _qtyS.push(0);
               _qtyV.push(res[i].split(" ")[3]);
                qtyNow +=Number(res[i].split(" ")[3]);
            }
            _qty.push(qtyNow);
            _min.push(res[i].split(" ")[4]);
            _max.push(res[i].split(" ")[5]);
        }
        
        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 12;
		
        var dataQty = {
            	label: "Наличие",
				backgroundColor: gradientQty,
				pointBackgroundColor: 'white',
				borderWidth: 1,
          		borderColor: '#ff4f4f',			
            	data: _qty,
          		};

        var dataSpisanie = {
            	label: "Списание",
				backgroundColor: gradientSpisanie,
				pointBackgroundColor: 'white',
				borderWidth: 1,			
            	borderColor: '#37b2ff',
            	data: _qtyS,
          		};
		
        var dataVnesenie = {
            	label: "Внесение",
				backgroundColor: gradientVnesenie,
				pointBackgroundColor: 'white',
				borderWidth: 1,			
          		borderColor: '#282933',
            	data: _qtyV,
          		};
		
        var allData = {
          		labels: _date,
          		datasets: [dataQty, dataSpisanie, dataVnesenie]
        		};

        var chartOptions = {
            	responsive: true,
            	maintainAspectRatio: false,
			
				animation: {				
					easing: 'easeInOutQuad',
					duration: 0
					},
                hover: {
                    animationDuration: 0 // duration of animations when hovering an item
                    },
                responsiveAnimationDuration: 0, // animation duration after a resize
			
				horizontalLine: [{
                    y: _max[0],
                    text: "Макс "+_max[0] //данные из БД
                    },
                    {
                    y: _min[0],
                    style: "rgba(255, 0, 0, .4)",
                    text: "Мин "+_min[0] //данные из БД
                    }],
			
				elements: {
					line: {
						tension: 0.4
						}
					},
			
          		legend: {
            		position: 'top',            
					labels: {
              			boxWidth: 15,
              			fontColor: '#6c7279',
						fontFamily: 'Roboto',
						fontSize: 14
            			}
          			},			
			
          		scales: {
            		yAxes: [{
                		ticks: {
							fontColor: '#6c7279',
							fontFamily: 'Roboto',
                    		suggestedMin: _min[0],
                    		suggestedMax: _max[0],
                    		display: true
                			},
                		gridLines: {
                    		color: 'rgba(200, 200, 200, 0.08)',
							lineWidth: 1
                			},
                		scaleLabel: {
                    		display: true,
              				fontColor: '#6c7279',
							fontFamily: 'Roboto',
                    		labelString: "Количество",
                  			}
            			}],
            		xAxes: [{
                		ticks: {
              				fontColor: '#6c7279',
							fontFamily: 'Roboto',							
                    		display: true
                			},
                		gridLines: {
                			color: "rgba(200, 200, 200, 0.05)",
							lineWidth: 1
            				},
            			}]
        			},
			
				point: {
					backgroundColor: 'white'
					},
			
				tooltips: {
					titleFontFamily: 'Open Sans',
					backgroundColor: 'rgba(0,0,0,0.3)',
					titleFontColor: 'white',
					caretSize: 5,
					cornerRadius: 2,
					xPadding: 10,
					yPadding: 10
					}			
        		};
        
		var horizonalLinePlugin = {
                afterDraw: function (chartInstance) {
                    var yScale = chartInstance.scales["y-axis-0"];
                    var canvas = chartInstance.chart;
                    var ctx = canvas.ctx;
                    var index;
                    var line;
                    var style;
					var labelSize;

                    if (chartInstance.options.horizontalLine) {
                        for (index = 0; index < chartInstance.options.horizontalLine.length; index++) {
                            line = chartInstance.options.horizontalLine[index];

                            if (!line.style) {
                                style = "rgba(169,169,169, .6)";
                            } else {
                                style = line.style;
                            }

                            if (line.y) {
                                yValue = yScale.getPixelForValue(line.y);
                            } else {
                                yValue = 0;
                            }

                            ctx.lineWidth = 1;

                            if (yValue) {
          						ctx.beginPath();
          						ctx.moveTo(yScale.width, yValue);
          						ctx.lineTo(canvas.width-35, yValue);
          						ctx.strokeStyle = style;
          						ctx.stroke();
        				    }
          
          					if (chartInstance.options.scales.yAxes[0].ticks.fontSize != undefined){
              					labelSize = parseInt(chartInstance.options.scales.yAxes[0].ticks.fontSize);
          					} else {
          					    labelSize = parseInt(chartInstance.config.options.defaultFontSize);
          					}

        					if (line.text) {
          					ctx.fillStyle = style;
          					//ctx.textBaseline = 'hanging'; //<-- set this
          					ctx.fillText(line.text, 70, yValue-labelSize-4);
        					}
                        }
                        return;
                    };
                }
            };
        
        var lineChart = new Chart(ctx, {
          		type: 'line',
          		data: allData,
          		options: chartOptions,
                plugins: [horizonalLinePlugin]
        		});
                
    }
    
    //добавление нового материала в базу каталога
    function add_material(){
        var ind_mat = document.querySelector("#individual_mat");
        var individual;
        var ozm_mat = document.getElementById("ozm_input").value;
        var name_mat = document.getElementById("name_mat_field").value;
        var barcode_mat = document.getElementById("barcode_input").value;
        var categor_mat = document.getElementById("categor_input").value;
        var min_mat = document.getElementById("min_input").value;
        var max_mat = document.getElementById("max_input").value;
        var ei_mat = document.getElementById("ei_input").value;

        var barcode_value=barcode_mat;
        
        if(ind_mat.checked || selAddMatCatId ==5018){
           individual = 1;
           }else{
           individual = 0;
           }
        
        if(barcode_mat == ""){
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'getGenBarcode',categor:categor_mat},
               success: function(result){
                    barcode_value = result;
               }
           });
        }
        
         setTimeout(function () {
                pageUrl= window.location.href;
                    $.ajax({
                       type: "POST",
                       url: "sklad/selectedMaterial.php",
                       data: {page:pageUrl,indMat:individual,action:'createMaterial',ozm:ozm_mat,name_mat:name_mat,barcode:barcode_value,categor:categor_mat,min_mat:min_mat,max_mat:max_mat,ei_mat:ei_mat},
                       success: function(result_){
                                if(selAddMatCatId ==5018){
                                    var powerAdd = document.getElementById("power_input").value;
                                    var voltageAdd = document.getElementById("voltage_input").value;
                                    var speedAdd = document.getElementById("speed_input").value;
                                    $.ajax({
                                       type: "POST",
                                       url: "Motors/selectedMotor.php",
                                       data: {action:'createMotor',power:powerAdd,voltage:voltageAdd,speed:speedAdd,id_mat:result_},
                                       success: function(result){
                                            alert(result);
                                       }
                                   });
                                }else{
                                    alert("✅Готово");
                                }
                           
                       }
                   });
                    }, 
                100);
    }
    //редактирование выбранного материала из таблицы
    function edit_materialObj(){
        var barcodeE = document.getElementById("barcodeEditMatObj_input").value;
        
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'editMaterialObj',idMat:selMatObjId,barcode:barcodeE},
               success: function(result){
                   alert(result);
               }
           });
        
    }
    
    function edit_material(){
        var ozmE = document.getElementById("ozmEdit_input").value;
        var nameMatE = document.getElementById("nameEdit_input").value;
        var barcodeE = document.getElementById("barcodeEdit_input").value;
        var categorE_mat = document.getElementById("categorEdit_input").value;
        var minE_mat = document.getElementById("minEdit_input").value;
        var maxE_mat = document.getElementById("maxEdit_input").value;
        var eiE_mat = document.getElementById("eiEdit_input").value;
        
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'editMaterial',idMat:selMatId,ozm:ozmE,name_mat:nameMatE,barcode:barcodeE,categor:categorE_mat,min_mat:minE_mat,max_mat:maxE_mat,ei_mat:eiE_mat},
               success: function(result){
                    var file_data = $('#sortpicture').prop('files')[0];   
                    var form_data = new FormData();                  
                    form_data.append('changeImg', file_data);    
                    $.ajax({
                        url: 'Upload_img.php', // <-- point to server-side PHP script 
                        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         
                        type: 'post',
                        success: function(){
                            alert(result);
                        }
                     });
                   
                   
               }
           });
        
    }
    
    function categorChangeEvent(){
        var categor_mat = document.getElementById("categor_input").value;
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:'getCategorId',categor:categor_mat},
               success: function(result){
                   selAddMatCatId = result;
                   
                   var div = document.querySelector("#motor_div");
                   
                   if(selAddMatCatId ==5018){
                       div.style.display = "block";
                   }else{
                       div.style.display = "none";
                   }
               }
           });
    }
    
    function addCountMats(){
        var count = document.getElementById("countMats_input").value;
        var barcodeE = document.getElementById("barcodeEdit_input").value;
        pageUrl= window.location.href;
        $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {page:pageUrl,action:"addMatsCount",barcode_sel:barcodeE,countMats:count},
               success: function(result){
                   alert(result);
               }
           });
        
    }
    
    function find_mat_barcode(code){
        var val = code.value;
        
            $.ajax({
               type: "POST",
               url: "sklad/selectedMaterial.php",
               data: {action:pageUrl},
               success: function(result){
                   alert(result);
               }
           });
    }
    
    function printEticetka(){
        var mywindow = window.open('', 'PRINT', 'height=800,width=600');
        var h = document.getElementById("h_input").value;
        var w = document.getElementById("w_input").value;
        var e = document.getElementById("etiketka_cont");
        var eb = document.getElementById("etiketka_back");
        var ef = document.getElementById("etiketka_front");
        var cehPrint = document.getElementById("cehPrint");
        var count = document.getElementById("count_input").value;
        
        e.style.width = w+"px";
        e.style.height = h/2+"px";
        eb.style.width = w+"px";
        eb.style.height = h/2+"px";
        e.style.fontSize = w/40+"px";
        eb.style.fontSize = w/40+"px";
        ef.style.fontSize = w/30+"px";
        
        if(selMatObjectBarcode !=""){
                   JsBarcode("#barcode", selMatObjectBarcode, {
                    width: w/300,
                    height: h/7.5,
                    fontSize: w/30
                });
           }else{
                    JsBarcode("#barcode", selMatBarcode, {
                    width: w/300,
                    height: h/7.5,
                    fontSize: w/30
                });
           }

        
        mywindow.document.write('<html><head><title>Этикетка для материала</title>');
        mywindow.document.write('</head><body style="height:'+h+'px; width:'+w+'px">');
        
        for(var i =0;i<count;i++){
            if(paket_input.checked){
                mywindow.document.write(document.getElementById("etiketka").innerHTML);
               }else{
                mywindow.document.write(document.getElementById("etiketka_low").innerHTML);
               }
            mywindow.document.write('<br>');
        }
        
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();
    }

</script>
