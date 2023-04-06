<?php
	// Exam Page / Страница о результатах тестиования
?>

<div class="Exam">

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
  			<div class="material_img">
   				<img id="people_image" src="sklad/sys_img/noimg.jpg">
   				<div id="people_name" style="margin: 0px 0px 10px 0px;">
   					ФИО
   				</div> <!-- Сюда выводить имя выбранного результата -->
			</div>  		  			
   		</div>
   		
        <!-- Плитка с подробной информацией -->
   		<div class="bar" id="info">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/info.svg";?>
				</div>
				<div class="barTitle">Проверка знаний</div>
			</div>
			<div class="barContent" id="infoContent">
                <br>
                Дата внеочередного экзамена:<br>
                <input id="date_exam" type="date" value = "0" style="width:100%"/>
                <br>
                <br>
   	            <input type="button" class="knopka" value="Начать внеочередную проверку" onclick="print()"/>
			</div>
   		</div>
        
   		<!-- Плитка с подробной информацией -->
   		<div class="bar" id="info">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/info.svg";?>
				</div>
				<div class="barTitle">Подробная информация</div>
			</div>
			<div class="barContent" id="infoContent">
                <div id="info_people"></div>
                <div  id="protocol" name-"protocol" style=" display: none;"></div >
                <br>
                № Протокола:<br>
                <input id="ozm_input" type="text" value = "0" style="width:100%"/>
                <br>
                <br>
                <input type="button" class="knopka" value="Документ Готов!" onclick="document_success()"/>
                <br>
                <br>
   	            <input type="button" class="knopka" value="Печать протокола" onclick="print()"/>
			</div>
   		</div>
        

   	</div>
   	
   	<!-- Правая колонка с плитками -->
	<div class="WH_right_column" id="column_review">  		
  		<!-- Плитка с результатами -->
		<div class="bar" id="catalog">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</div>
				<div class="barTitle">Результаты экзаменов</div>
			</div>
			<div class="barContent" id="catalogContent">
				<!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->		
			</div>
		</div>  	
   	</div>
</div>

<script type="text/javascript">
    var selRowNow;
    var resultProtocol;
    var docName ="null";
    var chat_id_people;
    
    $(document).ready(function(){
        ajaxGenerateTable();
    });
    function DocumentReady(){
        //close_all_sidebar();
        window.addEventListener("resize", displayWindowSize);
        displayWindowSize();
    }
    
        //При изменении окна браузера
    function displayWindowSize(){
        //let rootCss = document.documentElement;
        //var heightMatTable = document.querySelector('#catalogContent').offsetHeight;
        document.getElementById('resultsContent').setAttribute("style","height:"+(window.innerHeight-210)+"px");
        //rootCss.style.setProperty('--transAnim', (heightMatTable/1.5)+"ms");
        document.getElementById('containerItems').setAttribute("style","height:"+(window.innerHeight-210)+"px");
    }
    
        /*Выбор персонала в таблице*/
    function selectTd(e){
		// ?? элементов с классом .itemNameTD я не нашел !!
        var fio = e.querySelector('.nonColumnFIO').innerHTML;
        var selId = e.querySelector('#id_people').innerHTML;
        chat_id_people = e.querySelector('#id_chat').innerHTML;
        
        var protocol = document.querySelector('#protocol');
        var selId = e.querySelector('#id_people').innerHTML;
        var info_people = document.querySelector('#info_people');
        
        imgMat = document.getElementById("people_image");
        info_people = 
        
            $.ajax({
               type: "POST",
               url: "Exam/selectedPeople.php",
               data: {action:'selectPeople', idPeople:selId},
               success: function(result){
                   protocol.innerHTML = result;
                   
                    var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
                    var postHtml = "</body></html>";
                        
                   
                   
                   const months = ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"];
                   
                   var protocol_date = e.querySelector('.columnDateExam');
                   var day = document.getElementById('dayDoc');
                   var Month_year = document.getElementById('Month_yearDoc');
                   var fioTable = document.getElementById('fioTableDoc');
                   var fioUdost = document.getElementById('fioUdo');
                   
                   var new_Date = new Date(Date.parse(protocol_date.innerHTML));
                   
                   day.innerHTML = String(new_Date.getDate()).padStart(2, '0');
                   Month_year.innerHTML = months[new_Date.getMonth()]+" "+new_Date.getFullYear();
                   fioTable.innerHTML =  fio;
                   fioUdost.innerHTML = fio;
                   docName = fio;
                   var html = preHtml+protocol.innerHTML+postHtml;
                   
                   resultProtocol = html;
                   DocumentReady();
               }
           });
        
        if(selRowNow !=null)
            selRowNow.classList.remove("selected");
        
        selRowNow = e;
        e.classList.add("selected");
        people_name.innerHTML = fio;
    }
    
    function print(){
                    var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(resultProtocol);
                   var fileDownload = document.createElement("a");
                   document.body.appendChild(fileDownload);
        
                   fileDownload.href = source;
                   fileDownload.download = docName+'.doc';
                   fileDownload.click();
                   document.body.removeChild(fileDownload);
    }
    
    function document_success(){
        
            $.ajax({
               type: "GET",
               url: "php_app_telBot.php",
               data: {botId:"5677729076:AAGu7OD_oHzxpkemUvKT4NW_8bYdd5cygt0",chatId:chat_id_people,text:"Ваш удостоверение готово! Заберите его в АБК 1 этаж, кабинет электриков."},
               success: function(result,status,xhr){
                    alert(result);
               }
           });
    }
    
    //Функция для создания таблицы посредством Ajax
    function ajaxGenerateTable(){
        pageUrl= window.location.href;
            $.ajax({
               type: "POST",
                url: "Exam/ExamTableGenerator.php",
               data: {page:pageUrl},
               success: function(result,status,xhr){
                   $( "#catalogContent" ).html( result );
                   DocumentReady();
               }
           });
    }
</script>