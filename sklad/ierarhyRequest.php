
<?php

$action = "";
if (!empty($_POST["action"]))
    $action = $_POST['action'];

switch($action){
    case "genIerarhy":
        GenerateIerarhy();
    break;
    case "addArea":
        addArea();
    break;
    case "addAggr":
        addAggr();
    break;
    case "addPlace":
        addPlace();
    break;
}

function GenerateIerarhy(){
    require "../sql_connect.php";
    
    $query_areas = "select id,area_name from all_areas";
    $stmt = mysqli_query($conn,$query_areas);
    $rows = mysqli_num_rows ( $stmt );
    if ($rows ==0 )
            echo "Отсутствует иерархия оборудования";    
    
    echo "<ul>";
    
    while($row = mysqli_fetch_array($stmt) ){
        echo "
        <li>".$row['area_name'].
            "<ul>";
        
        $query_aggregate = "select id,aggregate_name from all_aggregate where area_id=".$row['id'];
        $stmt_agg = mysqli_query($conn,$query_aggregate);
        while($row_agg = mysqli_fetch_array($stmt_agg) ){
            echo "<li>".$row_agg['aggregate_name']."</li>";
            
            $query_place = "select place_name from all_places where aggregate_id=".$row_agg['id'];
            $stmt_place = mysqli_query($conn,$query_place);
            
            while($row_place = mysqli_fetch_array($stmt_place) ){
                echo "<ul>".$row_place['place_name']."</ul>";
            }
            
            echo "<br><ul><input type=\"text\" id=\"place_".$row_agg['id']."\"> <input type=\"button\" value=\"Добавить место\" onClick=\"addNewPlace(".$row_agg['id'].")\"></ul>";
        }
        
        echo "<br><li><input type=\"text\" id=\"aggr_".$row['id']."\"> <input type=\"button\" value=\"Добавить агрегат\" onClick=\"addNewAggr('".$row['id']."')\"></li></ul>";
        
    }
    echo "<br><li><input id=\"addAreaText\" type=\"text\"> <input type=\"button\" value=\"Добавить участок\" onClick=\"addNewArea()\"></li>
    </ul>";
    
}

function addArea(){
    require "../sql_connect.php";
    
    $name_area = $_POST['areaName'];
    
    $query_new_area = "insert into  all_areas (`area_name`) values('".$name_area."')";
            if ($conn->query($query_new_area) === TRUE) {
              echo "✅Готово";
            } else {
                echo "❌Ошибка: " . $sql . "\n" . $conn->error."\n".$query_new_area;
            }
}

function addAggr(){
    require "../sql_connect.php";
    $id_area = $_POST['areaId'];
    $name_aggr = $_POST['aggrName'];
    
    $query_new_aggr = "insert into  all_aggregate (`aggregate_name`,`area_id`) values('".$name_aggr."',".$id_area.")";
            if ($conn->query($query_new_aggr) === TRUE) {
              echo "✅Готово";
            } else {
                echo "❌Ошибка: " . $sql . "\n" . $conn->error."\n".$query_new_aggr;
            }
}

function addPlace(){
    require "../sql_connect.php";
    $id_aggr = $_POST['placeId'];
    $name_place = $_POST['placeName'];
    
    $query_new_place = "insert into  all_places (`place_name`,`aggregate_id`) values('".$name_place."',".$id_aggr.")";
            if ($conn->query($query_new_place) === TRUE) {
              echo "✅Готово";
            } else {
                echo "❌Ошибка: " . $sql . "\n" . $conn->error."\n".$query_new_place;
            }
}

?>