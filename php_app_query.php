<?php
    require "sql_connect.php";

    $query = $_GET['query'];

    $stmt = mysqli_query($conn,$query);

    $rows = mysqli_num_rows ( $stmt );
if($rows==0)
    return;
    $post = array();
    while($row = mysqli_fetch_assoc($stmt))
    {
        $posts[] = $row;
    }

     foreach ($posts as $row) 
        { 
            foreach ($row as $element)
            {
                echo $element.";";
            }
         echo "&";
        }



?>