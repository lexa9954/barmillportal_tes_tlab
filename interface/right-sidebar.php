<div id="right_sidebar">
<!-- Кнопка профиль -->  
    <div class="ava_toggle-btn" onclick="move_right_sidebar()">
		<?php if(empty($_COOKIE['name'])): ?>
			<img class="ava" src="img/noimage-150x150.png" alt="Avatar">
    	<?php else: ?>      	
			<?php 
			//Подключение к БД
			require "sql_connect.php";
			$COOKIE_AMEI = $_COOKIE['AMEI'];
			$sql = "SELECT img_tmp,img_name FROM img_ava WHERE id_people = (SELECT id FROM peoples WHERE amei = '$COOKIE_AMEI')";
        
            $stmt = mysqli_query( $conn, $sql);
            $img = mysqli_fetch_array( $stmt);
            
			$target = $img['img_tmp'];
			$fName = $img['img_name'];
            if($target == "")
                $target="img\\no-avatar.jpg";
                
			echo "<img class=\"ava\" src=\"$target$fName\" alt=\"Avatar\">";
			?>       	
		<?php endif;?>        	
    </div> 
    	
	<!-- Авторизация на сайте -->
    <div class="container">
		<?php if(empty($_COOKIE['name'])): ?>
        <div class="ask-log-pass">Введите AMEI</div>
        <input type="number" class="form-control" oninput="inputAmeiField()" name="AMEI" id="AMEI" placeholder="AMEI"><br>
        
        <div id="auth" class="auth" style="display:none;">
            <input type="password" class="form-control" name="pass" id="pass" 	placeholder="password" autocomplete="on"><br>
            <input id="auth_btn" onclick="authClickBtn()" class="knopka" type="button" value="Авторизоваться">
            <br>
            <p><a href="http://mst-app18/index.php" onclick="removePass()" style="color:white">Забыл пароль</a></p>
        </div>
        <div id="register" class="auth" style="display:none;">
            <!--input type="text" class="form-control" name="Email" id="Email" placeholder="E-mail"><br-->
            <input id="request_btn" onclick="requestClickBtn()" class="knopka" type="button" value="Подать заявку">
        </div>
        
        
        <?php if(!empty($_SESSION['loginError'])){
            $message = $_SESSION['loginError'];
        }
        ?>
        
		<?php else: ?>		 
			<ul>
				<li><p class="exit">Привет <?=$_COOKIE['name']?></p></li>
				<li><a href="index.php?page=profile" onclick="close_all_sidebar()">Профиль</a></li>
				<li><a href="access_control/exit.php">Выйти</a></li>
			</ul>			
		<?php endif;?>
		<?php 
		/* Код необходимый чтобы сбросить ошибку если пользователь покинул страницу с ошибкой */
			if(!empty($_SESSION['loginError'])){
			unset($_SESSION['loginError']);
			}
		?>
	</div>			
</div>	

<script>
    //переменные этого документа
    var amei_field = document.querySelector('#AMEI');
    var pass_field = document.querySelector('#pass');
    
    //переменные формы centr-sidebar.php
    
    //Отображение полей в зависимости от ввода AMEI

    function inputAmeiField(){
        if(amei_field.value ==""){
            document.getElementById("auth").style.display = "none";
            document.getElementById("register").style.display = "none";
            return;
        }
            $.ajax({
               type: "POST",
               url: "profile/selectPeople.php",
               data: {action:'checkPeople', amei:amei_field.value},
               success: function(result){
                   console.log(result);
                   if(result=="user_not_found"){
                       document.getElementById("auth").style.display = "none";
                       document.getElementById("register").style.display = "flex";
                   }else if(result == "request_not_found"){
                       document.getElementById("auth").style.display = "none";
                       document.getElementById("register").style.display = "flex";
                   }else if(result == "request_checking"){
                       document.getElementById("auth").style.display = "none";
                       document.getElementById("register").style.display = "none";
                       alert('По введенному AMEI заявка уже была принята, что бы активировать аккаунт зайдите в любого телеграм бота!');
                   }else if(result =="access_auth"){
                        document.getElementById("auth").style.display = "flex";
                       document.getElementById("register").style.display = "none";
                   }
               }
           });
    }
    
    //
    function authClickBtn() {
            $.ajax({
               type: "POST",
               url: "access_control/auth.php",
               data: {action:'checkPeople', amei:amei_field.value, pass:pass_field.value},
               success: function(result){
                   //alert(result);
                    document.getElementById("auth").style.display = "none";
                    document.getElementById("register").style.display = "none";
                   location.reload();
               }
           });
    }
    
    
    var input = document.getElementById("pass");
    // Execute a function when the user presses a key on the keyboard
    input.addEventListener("keypress", function(event) {
      // If the user presses the "Enter" key on the keyboard
      if (event.key === "Enter") {
        // Cancel the default action, if needed
        event.preventDefault();

            $.ajax({
               type: "POST",
               url: "access_control/auth.php",
               data: {action:'checkPeople', amei:amei_field.value, pass:pass_field.value},
               success: function(result){
                   //alert(result);
                    document.getElementById("auth").style.display = "none";
                    document.getElementById("register").style.display = "none";
                   location.reload();
               }
           });
      }
    });
    
    function requestClickBtn() {
                    $.ajax({
               type: "POST",
               url: "PHPMailer/sendMail.php",
               data: {email:"lexa9954@gmail.com"},
               success: function(result){
                   //alert(result);
               }
           });
        
        close_all_sidebar();
        move_centr_sidebar();
        startRegForm();

    }
    
    function removePass(){
        if (confirm("Вы точно забыли пароль?") == true) {
                  $.ajax({
                       type: "POST",
                       url: "profile/selectPeople.php",
                       data: {action:"removePass",amei:amei_field.value},
                       success: function(result){
                           alert(result);
                       }
                   });
        }


    }

    
    
</script>	