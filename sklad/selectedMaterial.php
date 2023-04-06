<?php

$action = $_POST['action'];
$wh_id = 0;
if (!empty($_POST["page"])){
    $pageURL = $_POST['page'];
    $parts = parse_url($pageURL);
    parse_str($parts['query'], $params);
    $warehouse = $params['warehouse'];
}
switch($action){
    case 'infoMatGrafic':
        SelectMatVariables($_POST['idMat']);
    break;
    case 'imgSelMat':
        imgSelMat($_POST['idMat']);
    break;
    case 'CreateTableTransaction':
        SelectedMatTransactions($_POST['idMat']);
    break;
    case 'QueryGetValues':
        SelectMatVariablesCreatorPanel($_POST['_idMat']);
    break;
    case 'getBarcode':
        getBarcode($_POST['idMat']);
    break;
    case 'generateTypeCategories':
        GenerateTypeCategories();
    break;
    case 'generateTypeOZM':
        GenerateTypeOZM();
    break;
    case 'generateTypeEi':
        GenerateTypeEi();
    break;
    case 'generateBarcodes':
        GenerateBarcodes();
    break;
    case 'createMaterial':  
        CreateMaterial($_POST['ozm'],$_POST['name_mat'],$_POST['barcode'],$_POST['categor'],$_POST['min_mat'],$_POST['max_mat'],$_POST['ei_mat'],$_POST['indMat']);
    break;
    case 'editMaterial':  
        EditMaterial($_POST['idMat'],$_POST['ozm'],$_POST['name_mat'],$_POST['barcode'],$_POST['categor'],$_POST['min_mat'],$_POST['max_mat'],$_POST['ei_mat']);
    break;
    case 'editMaterialObj':
        EditMaterialObj($_POST['idMat'],$_POST['barcode']);
    break;
    case 'addMatsCount':  
        AddMatCount($_POST['barcode_sel'],$_POST['countMats']);
    break;
    case 'getGenBarcode':  
        getGenerateBarcode($_POST['categor']);
    break;
    case 'getCategorId':
        getCategorId($_POST['categor']);
        break;
}
function getCategorId($nameC){
    include   "../sql_connect.php";
    $query_= "SELECT `id` FROM `categories` WHERE cg_name="."'$nameC'";
    $stmt = mysqli_query($conn,$query_);
    
    while($row = mysqli_fetch_array($stmt)){
        echo $row['id'];
    }
    
    mysqli_close($conn);
}

function getBarcode($id){
    include   "../sql_connect.php";
    $query_= "SELECT `bar_code` FROM `materials` WHERE id=$id";
    $stmt = mysqli_query($conn,$query_);
    
    while($row = mysqli_fetch_array($stmt)){
        echo $row['bar_code'];
    }
    mysqli_close($conn);
}

function SelectMatVariables($id){
    include   "../sql_connect.php";
    $matDateArr = array();
    $spisanieDobavlenieArr = array();
    $matQtyArr = array();
    $minArr = array();
    $maxArr = array();
    $query_ = "select mat_date,spisanie_or_dobavlenie,mat_qty,min,max from history join materials on materials.id=history.mat_id where mat_id =$id";
    $stmt = mysqli_query($conn,$query_);
    while($row = mysqli_fetch_array($stmt)){
        $mat_date = $row['mat_date'];
        $spisanie_or_dobavlenie = $row['spisanie_or_dobavlenie'];
        $mat_qty = $row['mat_qty'];
        $min = $row['min'];
        $max = $row['max'];
        
        $matDateArr = $mat_date;
        $spisanieDobavlenieArr = $spisanie_or_dobavlenie;
        $matQtyArr = $mat_qty;
        $minArr = $min;
        $maxArr = $max;
        echo "$spisanieDobavlenieArr $matDateArr $matQtyArr $minArr $maxArr;";
    }
    mysqli_close($conn);
}
function imgSelMat($id){
    include   "../sql_connect.php";
    $query_ = "select ozm from materials where id ='$id'";
    $stmt = mysqli_query($conn,$query_);
    
    while($row = mysqli_fetch_array($stmt)){
        echo $row['ozm'];
    }

    mysqli_close($conn);
}


function SelectedMatTransactions($id){
    $query_ = "select peoples.Second_name,peoples.First_name,peoples.Last_name,mat_date,mat_qty,spisanie_or_dobavlenie,ediniciIzmerenija.ei_name   
    from history join peoples on history.people = peoples.id join materials on history.mat_id = materials.id 
    join ediniciIzmerenija on materials.ei_id=ediniciIzmerenija.id 
    where mat_id=$id";
    
    CreateTableTransactions($query_);
}


function CreateTableTransactions($stmt){
    echo "<table class=\"tableMats\">
                <thead id=\"material_table_head\" class=\"material_table_head\">
                	<tr>
                        <th class=\"columnDate\">
							<div class=\"columnHeader\">Дата</div>
							</th>
                        <th class=\"colSod\">
							</label>
							<div class=\"columnHeader\">Действие</div>
							</th>
                        <th class=\"columnQty\">
							<div class=\"columnHeader\">Количество</div>
							</th>
                        <th class=\"columnEdIzm\">
							<div class=\"columnHeader\">Ед.Изм.</div>
							</th>
                        <th class=\"colFio\">
							<div class=\"columnHeader\">ФИО</div>
							</th>
                	</tr>
                </thead>
                <tbody id=\"containerItems\">";
                    include   "../sql_connect.php";
                    $resQuery = mysqli_query($conn,$stmt);
                    
    				while($row = mysqli_fetch_array($resQuery)){
                        $sod = "";
                        if($row['spisanie_or_dobavlenie'])
                            $sod="Внёс"; 
                        else
                            $sod="Забрал";
  
        				echo "
                		<tr class=\"tableRow\" onclick=\"selectTd(this)\">
                            <td class=\"columnDate\">",$row['mat_date'],"</td>
                            <td class=\"colSod\">",$sod,"</td>
                            <td class=\"columnQty value\">",$row['mat_qty'],"</td>
                            <td class=\"columnEdIzm\">",$row['ei_name'],"</td>
                    		<td class=\"colFio\">",$row['Last_name']," ",$row['First_name']," ",$row['Second_name'],"</td>	
               	 		</tr>
        				";
    				}
                    mysqli_close($conn);
    				echo "
				</tbody>
            </table>";
}


function SelectMatVariablesCreatorPanel($id){
    include   "../sql_connect.php";
    
    $query_ = "select id_mat,status,status_name,wh_name,ceh_name,agregat_name,hran_name,remPloshadka_name,agregatUzel_name,mesto 
from material_objects 
join status_mat on status_mat.id = status
left join all_wh on all_wh.id = mesto_wh
left join all_ceh on all_ceh.id = mesto_ceh
left join all_agregats on all_agregats.id = mesto_agregat
left join all_mesto_hran on all_mesto_hran.id = mesto_hran
left join all_remPloshadka on all_remPloshadka.id = mesto_rem_ploshadka
left join all_agrUzel on all_agrUzel.id = mesto_agregat_uzel where id_mat =$id";
    $stmt = mysqli_query($conn,$query_);
    while($row = mysqli_fetch_array($stmt)){
        echo $row['status_name'];
        switch($row['status']){
            case 1:
                echo $row['wh_name'];
                echo $row['hran_name'];
            break;
            case 2:
                echo $row['ceh_name'];
                echo $row['remPloshadka_name'];
            break;
            case 3:
                echo $row['agregat_name'];
                echo $row['agregatUzel_name'];
            break;
            case 4:
                echo "Утиль";
            break;
        }
        echo "</br>";
    }
    mysqli_close($conn);
}

function GenerateTypeCategories(){ 
    require "../sql_connect.php";
    if($_POST['type'] == "Add"){
        echo "	
        <input id=\"categor_input\" type=\"text\" list=\"typeCategoriesBox\" onchange=\"categorChangeEvent()\" style=\"height: 25px; width: -webkit-fill-available\"/>
		<datalist id=\"typeCategoriesBox\" >";
    }else if($_POST['type'] == "Edit"){
        echo "	
        <input id=\"categorEdit_input\" type=\"text\" list=\"typeCategoriesEditBox\"  style=\"height: 25px; width: -webkit-fill-available\"/>
		<datalist id=\"typeCategoriesEditBox\" >";
    }
    

    		$query_select_categor ="select id,cg_name from categories order by cg_name";
    		$stmt = mysqli_query($conn,$query_select_categor);
	
    		while($row = mysqli_fetch_array($stmt)){
                $id = $row['id'];
                $nameRepair =$row['cg_name'];
				CreateItem($nameRepair,$id);
    		}
    
    		mysqli_close($conn);
        echo "
		</datalist>";
}
function GenerateTypeOZM(){ 
    require "../sql_connect.php";
		echo "	
        <input id=\"ozm_input\" type=\"text\"  list=\"typeOZMBox\" style=\"height: 25px; width: -webkit-fill-available\"/>
		<datalist id=\"typeOZMBox\" >";
    		$query_select_categor ="select id,ozm from materials where not ozm=0";
    		$stmt = mysqli_query($conn,$query_select_categor);
	
    		while($row = mysqli_fetch_array($stmt)){
                $id = $row['id'];
                $nameRepair =$row['ozm'];
				CreateItem($nameRepair,$id);
    		}
    
    		mysqli_close($conn);
        echo "
		</datalist>";
}
function GenerateTypeEi(){ 
    require "../sql_connect.php";
    if($_POST['type'] == "Add"){
		echo "	
        <input id=\"ei_input\" type=\"text\" list=\"typeEiBox\"  style=\"width:100%;\"/>
		<datalist id=\"typeEiBox\" >";
    }else if($_POST['type'] == "Edit"){
		echo "	
        <input id=\"eiEdit_input\" type=\"text\" list=\"typeEiBox\"  style=\"width:100%;\"/>
		<datalist id=\"typeEiBox\" >";
    }
    

    		$query_select_categor ="select id,ei_name from ediniciIzmerenija";
    		$stmt = mysqli_query($conn,$query_select_categor);
	
    		while($row = mysqli_fetch_array($stmt)){
                $id = $row['id'];
                $nameRepair =$row['ei_name'];
				CreateItem($nameRepair,$id);
    		}
    
    		mysqli_close($conn);
        echo "
		</datalist>";
}
function GenerateBarcodes(){ 
    require "../sql_connect.php";
		echo "	
        <input id=\"barcode_input\" type=\"text\" list=\"barcodesBox\" onChange=\"find_mat_barcode(this);\"  style=\"width:100%;\"/>
		<datalist id=\"barcodesBox\" >";
    		$query_select_categor ="select id,bar_code from materials";
    		$stmt = mysqli_query($conn,$query_select_categor);
	
    		while($row = mysqli_fetch_array($stmt)){
                $id = $row['id'];
                $nameRepair =$row['bar_code'];
				CreateItem($nameRepair,$id);
    		}
    
    		mysqli_close($conn);
        echo "
		</datalist>";
}
function CreateItem($name,$id){
    echo "<option id=\"$id\" value=\"$name\">";
        //echo $name;
    echo "</option  >";
}

function getGenerateBarcode($nameCat){
    require "../sql_connect.php";
    $cat_id=0;
    $mat_id=0;
    $query_get_cat_id = "select id from categories where cg_name='".$nameCat."'";
    $stmt = mysqli_query($conn,$query_get_cat_id);
            while($row = mysqli_fetch_array($stmt)){
                $cat_id = $row['id'];
            }
    $query_get_mat_id = "select max(id) from materials";
    $stmt = mysqli_query($conn,$query_get_mat_id);
            while($row = mysqli_fetch_array($stmt)){
                $mat_id = $row['max(id)']+1;
            }
    
    echo $cat_id."-".$mat_id;
}
function CreateMaterial($ozm,$name,$barcode,$categor,$min,$max,$ei,$individual){
        
    require "../sql_connect.php";

    $query_create="select id from materials where bar_code='".$barcode."'";
    $stmt = mysqli_query($conn,$query_create);
    
    $rows = mysqli_num_rows ( $stmt );
    if ($rows ==0 ){
            $cat_id=0;
            $ei_id=0;

            $query_get_cat_id = "select id from categories where cg_name='".$categor."'";
            $query_get_ei_id = "select id from ediniciIzmerenija where ei_name='".$ei."'";

            $stmt = mysqli_query($conn,$query_get_cat_id);
            while($row = mysqli_fetch_array($stmt)){
                $cat_id = $row['id'];
            }
            $stmt = mysqli_query($conn,$query_get_ei_id);
            while($row = mysqli_fetch_array($stmt)){
                $ei_id = $row['id'];
            }

            $query_new_mat = "insert into  materials (`name_mat`,`bar_code`,`categor`,`min`,`max`,`ei_id`,`ozm`,`individual`) values('".$name."','".$barcode."',".$cat_id.",".$min.",".$max.",".$ei_id.",".$ozm.",".$individual.")";
            if ($conn->query($query_new_mat) === TRUE) {
                $last_id = $conn->insert_id;
                echo $last_id;
              //echo "✅Готово";
            } else {
                echo "❌Ошибка: " . $sql . "\n" . $conn->error."\n".$query_new_mat;
                return;
        }
    }else{
            echo "❗Данный материал уже имеется в каталоге материалов!";
        }
}

function EditMaterial($id,$ozm,$name,$barcode,$categor,$min,$max,$ei){
    require "../sql_connect.php";
        $cat_id=0;
        $ei_id=0;
        $query_get_cat_id = "select id from categories where cg_name='".$categor."'";
        $query_get_ei_id = "select id from ediniciIzmerenija where ei_name='".$ei."'";

        $stmt = mysqli_query($conn,$query_get_cat_id);
        while($row = mysqli_fetch_array($stmt)){
            $cat_id = $row['id'];
        }
        $stmt = mysqli_query($conn,$query_get_ei_id);
        while($row = mysqli_fetch_array($stmt)){
            $ei_id = $row['id'];
        }

    
        $query_edit="update materials set name_mat='".$name."', bar_code='".$barcode."',categor=".$cat_id.",min=".$min.",max=".$max.",ei_id=".$ei_id.",ozm=".$ozm." where id=".$id;

        if (mysqli_query($conn, $query_edit)) {
            echo "✅Готово";
        } else {
            echo "❌Ошибка: " . mysqli_error($conn);
        }
}
function EditMaterialObj($id,$barcode){
        require "../sql_connect.php";
    $query_edit="update material_objects set barcode_dlc='".$barcode."' where id=".$id;

        if (mysqli_query($conn, $query_edit)) {
            echo "✅Готово";
        } else {
            echo "❌Ошибка: " . mysqli_error($conn);
        }
}

function AddMatCount($barcode,$countmat){
    require "../sql_connect.php";
    $pageURL = $_POST['page'];
    $parts = parse_url($pageURL);
    parse_str($parts['query'], $params);
    $warehouse = $params['warehouse'];
    
    $mat_id = 0;
    $query_selMat = "select id from materials where bar_code='".$barcode."'";
    $stmt = mysqli_query($conn,$query_selMat);
    while($row = mysqli_fetch_array($stmt)){
        $mat_id = $row['id'];
    }
    
    $matObj_id = 0;
    $query_lastMatObj = "select max(id)'last_id' from material_objects";
    $stmt = mysqli_query($conn,$query_lastMatObj);
    while($row = mysqli_fetch_array($stmt)){
        $matObj_id = $row['last_id'];
    }
    
     for($i=0;$i<$countmat;$i++){
         $matObj_id ++;
         $barcode_gen = $barcode."_".$matObj_id;
         $query_new_mat = "insert into  material_objects (`id_mat`,`barcode_dlc`) values(".$mat_id.",'".$barcode_gen."')";
            if ($conn->query($query_new_mat) === TRUE) {
              echo "✅Готово";
            } else {
                echo "❌Ошибка: " . $sql . "\n" . $conn->error."\n".$query_new_mat;
     }
     }
                

    
    
}

?>
