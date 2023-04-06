<div id="centr_sidebar">
    
	<!-- подача заявки на регистрацию -->
    <div id="regForm" class="containerReg" style="display:none">
        <div class="ask-log-pass" style="margin:0">Введите AMEI</div>
        <input type="number" style="margin:5px 0; width:100%" class="form-control" name="AMEI_field" id="AMEI_field" placeholder="AMEI"><br>

        <div id="err_amei_send" style="display:none;">
            <div class="ask-log-pass">Введенный AMEI в информационной системе BarMill не найден</div>
            <div class="ask-log-pass" style="margin:0">Введите Табельный номер</div>
            <input type="number" style="margin:5px 0; width:100%" class="form-control" name="tab_num" id="tab_num" placeholder="Табельный №"><br>
        </div>
        
        <div class="ask-log-pass" style="margin:0">Введите Email</div>
        <input type="text" class="form-control" style="margin:5px 0; width:100%" name="Email" id="Email" placeholder="E-mail"><br>
        <input id="send_btn" class="knopka" type="button" value="Отправить">
        
        <p><a id="error_msg1"></a></p>
        
	</div>		
    
    <!-- смена пароля -->
    <div id="changePassForm" class="containerReg" style="display:none">
        <div class="ask-log-pass" style="margin:0">Введите старый пароль</div>
        <input type="text" class="form-control" name="old_pass" id="old_pass" style="margin:5px 0; width:100%" placeholder="Старый пароль"><br>
        <div class="ask-log-pass" style="margin:0">Введите новый пароль</div>
        <input type="text" class="form-control" name="last_pass" id="new_pass1" style="margin:5px 0; width:100%" placeholder="Новый пароль"><br>
        <div class="ask-log-pass" style="margin:0">Повторите новый пароль</div>
        <input type="text" class="form-control" name="last_pass" id="new_pass2" style="margin:5px 0; width:100%" placeholder="Новый пароль"><br>
        <input id="changePass_btn" class="knopka" type="button" value="Изменить">
    </div>
    

</div>	

<script>
    var amei_field_send = document.querySelector('#AMEI_field');
    var tab_num_field_send = document.querySelector('#tab_num');
    var email_field_send = document.querySelector('#Email');
    
    var old_pass = document.querySelector('#old_pass');
    var new_pass1 = document.querySelector('#new_pass1');
    var new_pass2 = document.querySelector('#new_pass2');
    //формы 
    var registrationForm = document.querySelector('#regForm');
    
    //
    var changingPassForm = document.querySelector('#changePassForm');
    
    function startRegForm(){
        amei_field_send.value = amei_field.value;
        amei_changed();
        registrationForm.style.display = 'block';
    }
    
    function closeAllforms(){
        registrationForm.style.display = 'none';
    }
    
    amei_field_send.oninput = function(){
        amei_changed();
    };
    
    function amei_changed(){
        if(amei_field.value ==""){
            document.getElementById("err_amei").style.display = "none";
            return;
        }
        
            $.ajax({
               type: "POST",
               url: "profile/selectPeople.php",
               data: {action:'checkPeople', amei:amei_field_send.value},
               success: function(result){
                   console.log(result);
                   if(result=="user_not_found"){
                       document.getElementById("err_amei_send").style.display = "block";
                   }else if(result == "request_not_found"){
                       document.getElementById("err_amei_send").style.display = "none";
                   }else if(result == "request_checking"){
                       document.getElementById("err_amei_send").style.display = "none";
                       alert("По введенному AMEI заявка уже была принята и находится в обработке,\nдля продолжения войдите в телеграмм бот с использованием вашего табельного номера");
                   }else if(result =="access_auth"){
                       document.getElementById("err_amei_send").style.display = "none";
                   }
               }
           });
    }
    
    send_btn.onclick = function() {
            $.ajax({
               type: "POST",
               url: "profile/selectPeople.php",
               data: {action:'regPeople', amei:amei_field_send.value, Email:email_field_send.value, tab_num:tab_num_field_send.value},
               success: function(result){
                   alert(result);
                    document.getElementById("auth").style.display = "none";
                    document.getElementById("register").style.display = "none";
                   
                   close_all_sidebar();
                   location.reload();
               }
           });
        
    };  
    
    // Отправка данных на сервер
    function send(){
    console.log("Отправка запроса");
    var req = new XMLHttpRequest();
    req.open('POST', "/PHPMailer/sendMail.php", true);
    req.onload = function() {
        if (req.status >= 200 && req.status < 400) {
        json = JSON.parse(this.response); // Ебанный internet explorer 11
            console.log(json);

            // ЗДЕСЬ УКАЗЫВАЕМ ДЕЙСТВИЯ В СЛУЧАЕ УСПЕХА ИЛИ НЕУДАЧИ
            if (json.result == "success") {
                // Если сообщение отправлено
                alert("Сообщение отправлено");
            } else {
                // Если произошла ошибка
                alert("Ошибка. Сообщение не отправлено");
            }
        // Если не удалось связаться с php файлом
        } 
        else 
        {
            alert("Ошибка сервера. Номер: "+req.status);
        }}; 
        req.onerror = function() {alert("Ошибка отправки запроса");};
        alert("Ошибка сервера. Номер: "+req.status);
    }
    
    changePass_btn.onclick = function(){
        
        if(new_pass1.value != new_pass2.value){
            alert('Новый пароль не совпадает');
            return;
        }
            
            $.ajax({
               type: "POST",
               url: "profile/selectPeople.php",
               data: {action:'changePass',oldPass:old_pass.value, newPass:new_pass1.value},
               success: function(result){
                   if(result == 'fail_pass'){
                       alert('Пароль не изменён! Так как прежний пароль введён неправильно.');
                   }else{
                       alert(result);
                       close_all_sidebar();
                   }
                   
               }
           });
    };
    

    
    
</script>	