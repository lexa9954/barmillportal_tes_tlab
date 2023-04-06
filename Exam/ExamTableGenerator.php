<?php
Start();



function Start(){
    $pageUrl = $_POST["page"];
    $parts = parse_url($pageUrl);
    parse_str($parts['query'], $params);
    $ekzamenType = $params['ekzamen'];

    $query_select_peoples = "select chat_id,doljnost_name,Protocol_num,first_name,last_name,second_name,Type_quest_text,success_quest_percent,last_date,time_exam,TabNumberSap from Exam_date join peoples on peoples.id=Exam_date.people_id join Exam_typeQuest on Exam_typeQuest.id=Exam_date.type_quest_id inner join all_doljnosti on all_doljnosti.id=peoples.Doljnost_id left JOIN log_auth_var on log_auth_var.id_people=peoples.id where Exam_date.last_date=(select max(Exam_date.last_date) from Exam_date where peoples.id=Exam_date.people_id) and Exam_date.type_quest_id = $ekzamenType ORDER BY `Exam_date`.`last_date` DESC";

    CreateTableResultsExam($query_select_peoples);
}


/* ▼ Создание таблицы ▼ */
function CreateTableResultsExam($query){
    echo "
            <table class=\"tableMats\" id=\"resultsContent\">
                <thead id=\"material_table_head\" class=\"material_table_head\">
                	<tr>
                        <th style=\"width: 0px;\">
                        		<label for=\"resetSort\" class=\"resetSort\" onclick=\"close_all_sidebar()\" id=\"resetSort-svg\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/resetSort.svg';	echo "							
							</label>
						</th>
                        
                        <th class=\"columnTimeExam\">
							<div class=\"columnHeader\">№ протокола</div>				
                    	</th>
                        
                        <th class=\"columnTabNum\">
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"resetSort\">
							
							<label for=\"select2\" class=\"select2\"  onclick=\"show_overlay()\" id=\"searchOZM\">";				
  								require dirname(__FILE__) . '/../sklad/sys_img/searchOZM.svg';	echo "
							<input type=\"radio\" name=\"lname\" value=\"not_changed\" id=\"select2\">
							<input type=\"number\" id=\"lname\" name=\"lname\" onkeydown=\"searchOzmEnter(event)\" min=\"111\" max=\"9999999999\">
							</label> 
							
							<div class=\"columnHeader\">Таб№</div>
						</th>
                    
                    	<th class=\"columnLN\">
							<div class=\"columnHeader\">ФИО</div>	
							<label  id=\"sortByLN\">";
  								require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "
							</label>
						</th>
						
                        <th class=\"columnDateExam\">
							<div class=\"columnHeader\">Дата</div
                            <label id=\"sortByDate\">";
        					    require dirname(__FILE__) . '/../sklad/sys_img/sort.svg';	echo "    
							</label>	
						</th>
						
                    	<th class=\"columnExamType\">
							<div class=\"columnHeader\">Экзамен</div>				
                    	</th>
						
                    	<th class=\"columnPercent\" >
							<div class=\"columnHeader\">% Сдачи</div>
						</th>
                        <th class=\"columnTimeExam\" >
							<div class=\"columnHeader\">Время затрачено</div>	
						</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
    require "../sql_connect.php";
                    $result = mysqli_query($conn,$query);
                    
                    while($row = mysqli_fetch_array($result) ){
                        $classMin = "itemMatTR";
                        if($row['success_quest_percent']<70){
                            $classMin = "zeroItemMatTR";
                        }
            				
                            $fio = $row['last_name'] .' '.mb_substr($row['first_name'],0,1) .'. '.mb_substr($row['second_name'],0,1).'.';
                                                    echo "
                		<tr id=\"item\" class=\"tableRow $classMin\" onclick=\"selectTd(this)\">
                            <td id=\"id_people\" style=\"width: 0px;\">",$row['id'],"</td>
                            <td id=\"id_chat\" style=\"width: 0px; display:none;\">",$row['chat_id'],"</td>
                            <td class=\"columnTimeExam\">",$row['Protocol_num'],"</td>
                            <td class=\"columnTabNum\">",$row['TabNumberSap'],"</td>
                            <td class=\"columnLN\">",$fio,"</td>
                            <td class=\"columnDateExam\">",$row['last_date'],"</td>
                    		<td class=\"columnExamType\">",$row['Type_quest_text'],"</td>
                    		<td class=\"columnPercent\">",$row['success_quest_percent'],"</td>
                            <td class=\"columnTimeExam\">",date('i:s',$row['time_exam']),"</td>
                            
                            <td class=\"nonColumnFIO\" style=\"display:none;\">",$row['last_name'].' '.$row['first_name'] .' '.$row['second_name'],"</td>
               	 		</tr>
        				"; 
                        
                   
                    }
    				echo "
				</tbody>
            </table>";	
}
/* ▲ Создание таблицы ▲ */

?>