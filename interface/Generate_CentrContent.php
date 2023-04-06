<?php
    $page = $_POST['page'];
    
	switch($page){
    	case "News":
			generate_news();
			break;
        case "add_news":
			add_news();
			break;
    	default: 
           echo $page;
			break;
	}
     
    function generate_news(){
        require "../sql_connect.php";
        $query_news = "select icon,text_news from news Order by id desc";
        $stmt = mysqli_query($conn,$query_news);
        
        $rows = mysqli_num_rows ( $stmt );
        if ($rows ==0 )
            echo "<div>Новостей пока нет</div>";
        
         while($row = mysqli_fetch_array($stmt) ){
             echo "<div style=\" display:flex; margin-top: 10px; border-color:#535c69; \">";
             echo "<div style=\" width:50px;height:50px;\"><img src=\"img/news.png\" style=\"width: 50px;\"></div>";
            echo "<div>".$row['text_news']."</div>";
             echo "</div>";
         }
        
    }
    function add_news(){
         require "../sql_connect.php";
        $text_news  = $_POST['text_news'];
        $query_news = "INSERT INTO news (text_news) VALUES ('".$text_news."')";
        $stmt = mysqli_query($conn,$query_news);
    }
    
?>