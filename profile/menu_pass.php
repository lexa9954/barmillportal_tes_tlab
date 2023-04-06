<!-- ↓ Меню изменения пароля пользователя ↓ -->
<div class="menu_pass">		
	<div id="btnChangePass" class="txtInline">
		<div>Пароль</div>
		<div id="profile_pass_lbl">Изменить</div>
	</div>
	<form id="profile_form_pass" action="access_control/change_pass.php" method="post">		
			<?php /* Здесь проверяем глобальные переменные передаваемые через сессию из change_pass и выводим их значение если пароль был введен верно выводим сообщение что пароль изменен успешно, если пароль введен не верно выводим соответствующее сообщение*/
					if(!empty($_SESSION['wrongPass'])){
					$message = $_SESSION['wrongPass'];
					echo "<div class=\"errorText\">$message</div>";
					}
					if(!empty($_SESSION['correctPass'])){
					$message = $_SESSION['correctPass'];
					echo "<div class=\"errorText\">$message</div>";
					}
			?>
			<!--поле ввода старого пароля-->
			<input type="password" class="prof_pass_style" name="old_pass" id="old_pass" placeholder="Старый пароль" autocomplete="off"><br>
			<!--поле ввода нового пароля-->
			<input type="password" class="prof_pass_style" name="new_pass" id="new_pass" placeholder="Новый пароль" autocomplete="off"><br>
			<!--поле повторного ввода нового пароля-->
			<input type="password" class="prof_pass_style" name="repeat_pass" id="repeat_pass" placeholder="Повторите пароль" autocomplete="off"><br>
			<button class="knopka" id="btn_change_pass" type="button">Изменить пароль</button>		
	</form>
</div>
<?php /* Код необходимый чтобы сбросить ошибку если пользователь покинул страницу с ошибкой */
	if(!empty($_SESSION['correctPass'])){
		unset($_SESSION['correctPass']);
	}
	if(!empty($_SESSION['wrongPass'])){
		unset($_SESSION['wrongPass']);
	}
?>

<script>	/* Скрипт валидации нового пароля */
	var old_pass = document.getElementById("old_pass");
	var new_pass = document.getElementById("new_pass");
	var repeat_pass = document.getElementById("repeat_pass");
	var btn_change_pass = document.getElementById("btn_change_pass");

	/* Условие чтобы новый пароль отличался от старого */
	new_pass.onkeyup = function() {
		if(new_pass.value === old_pass.value){
			/* если пароли одинаковы - запрет подтверждения пароля и подсветка поля нового пароля красным */
			new_pass.style.backgroundColor = "#e2a6a6";
			repeat_pass.style.display = "none";
		}else{
			/* если пароли отличаются - разрешение подтверждения пароля и подсветка поля нового пароля зеленым */
			new_pass.style.backgroundColor = "#90d69e";
			repeat_pass.style.display = "block";
	  	}
	}
	
	/* Условие чтобы повторно введенный новый пароль совпадал с новым паролем */
	repeat_pass.onkeyup = function() {	
		if(new_pass.value === repeat_pass.value){
			/* если пароли одинаковы - подсветка полей зеленым, и отображение кнопки отправки пароля */
			btn_change_pass.style.display = "block";
			repeat_pass.style.backgroundColor = "#90d69e";
			new_pass.style.backgroundColor = "#90d69e";
		}else{
			/* если пароли отличаются - подсветка полей красным, и скрытие кнопки отправки пароля */
			btn_change_pass.style.display = "none";			repeat_pass.style.backgroundColor = "#e2a6a6";
		}	      
	}
	
	
	/* Функция отправки данных формы в "change_pass" по нажатию на кнопку "Изменить пароль" */
	btn_change_pass.addEventListener("click", formSubmit);
	function formSubmit(){
		document.getElementById("profile_form_pass").submit();
	}
</script>	