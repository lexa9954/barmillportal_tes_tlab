<!-- ↓ Меню изменения пароля пользователя ↓ -->
<div class="menu_pass">		
	<div id="" class="txtInline">
		<div>Регистрация</div>
		<div id="profile_pass_lbl">...</div>
	</div>
    
	<form id="register_form_pass" style="height: 250px; margin:10px;" action="access_control/registration_form.php" method="post">	
            <!--поле ввода нового пароля-->
			<input id="tab_num_id" name="tab_num" type="number" class="prof_pass_style"  placeholder="Табельный номер" autocomplete="off"><br>
			<!--поле ввода старого пароля-->
			<!--input name="second_name" type="text" class="prof_pass_style"  placeholder="Фамилия" autocomplete="off"><br>
			<!--поле ввода нового пароля-->
			<!--input name="first_name" type="text" class="prof_pass_style"  placeholder="Имя" autocomplete="off"><br>
            <!--поле ввода нового пароля-->
			<!--input name="last_name" type="text" class="prof_pass_style"  placeholder="Отчество" autocomplete="off"><br>
            <!--поле ввода нового пароля-->
            <div id="fioContainer" style="margin:0px 20px;">
  				<!-- В данный блок интегрируется "selectedMaterial.php" посредством AJAX -->			
			</div>
			<input name="amei" type="number" class="prof_pass_style"  placeholder="AMEI" autocomplete="off"><br>
                    <!--поле ввода нового пароля-->
			<input name="email" type="text" class="prof_pass_style"  placeholder="Эл. почта" autocomplete="off"><br>
			<!--поле повторного ввода нового пароля-->
			<button class="knopka" id="btn_send_reg_value" type="button">Отправить заявку</button>		
        
            <div id="resultOfRegistration" style="margin:20px;     text-align-last: center;">
  				<!-- В данный блок интегрируется "selectedMaterial.php" посредством AJAX -->			
			</div>
	</form>

</div>

<script>	/* Скрипт валидации нового пароля */
    /* Функция отправки данных формы в "change_pass" по нажатию на кнопку "Изменить пароль" */
	btn_send_reg_value.addEventListener("click", formSubmit);
	function formSubmit(){
        var $form = $(this);
        $.ajax({
               type: $form.attr('method'),
               url: "access_control/registration_form.php" ,
               data: $form.serialize(),
               success: function(result){
                   $( "#resultOfRegistration" ).html( result );
               }
           });
		//document.getElementById("register_form_pass").submit();
	}


    
    const selectElement = document.querySelector('#tab_num_id');

    selectElement.addEventListener('change', (event) => {
            $.ajax({
               type: "POST",
               url: "profile/selectPeople.php",
               data: {action:'registrationPeople', tab_num:event.target.value},
               success: function(result){
                   $( "#fioContainer" ).html( result );
               }
           });
    });
    
    
</script>	