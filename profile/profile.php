<div id="profile" class="<?php
	 //Здесь присваивается класс "change_pass" блоку "profile" для отоброжения меню изменения пароля с результатом запроса изменения пароля через глобальные переменные посредством сессии
	 if(!empty($_SESSION['wrongPass'])){
		 echo "change_pass";
	 }
	 if(!empty($_SESSION['correctPass'])){
		 echo "change_pass";
	 }
?>"
>

<?php
//Если время существования кукисов закончилось пользователя выкидывает и переотправляет на индексную страницу
if(empty($_COOKIE['name'])){

    //Вызов блока меню регистрации
    require "profile/menu_registration.php";
    
    
}else{
    // ↓ Блок кода для отображения существующей аватарки (возможно выводить информацию о пользователе сюда же)↓
	//Подключение к БД
	require "sql_connect.php";	
	//создаем переменную и присваиваем значение поля AMEI кукисов для облегчения запроса к БД
	$COOKIE_AMEI = $_COOKIE['AMEI'];
	//запрос в БД для получения пути и имени файла картинки профиля
	$sql = "SELECT img_tmp,img_name FROM img_ava WHERE id_people = (SELECT id FROM peoples WHERE amei = '$COOKIE_AMEI')";	
	$stmt = mysqli_query( $conn, $sql);
    
	//формирование массива со зачениями пути и имени файла картинки из ответа от БД
	$img = mysqli_fetch_array( $stmt);
	//создания переменной пути к файлу
	$target = $img['img_tmp'];
	//создание переменной имени файла
	$fName = $img['img_name'];
		
    if($fName == "")
        $fName="img\\no-avatar.jpg";
	//создаем на странице тег с путем к файлу из переменных пути и имени файла
	echo "<img class=\"profile_img\" src=\"$target$fName\" alt=\"Avatar\">";
// ↑ Блок кода для отображения существующей аватарки (возможно выводить информацию о пользователе сюда же) ↑
    
    //Вызов блока меню изменения изображения профиля
    require "profile/menu_img.php";
    //Вызов блока меню изменения пароля профиля
    require "profile/menu_pass.php";
    //Вызов блока меню изменения уведомлений профиля
    require "profile/menu_notification.php";
    
    require "profile/edit_user_script.php";
    
}
	

    
?>

</div>

