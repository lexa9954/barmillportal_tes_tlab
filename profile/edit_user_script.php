<script>	/*Скрипт для открытия/скрытия окон меню по нажатию на вкладку*/
		var profile = document.getElementById("profile"),
  		btnChangeImg = document.getElementById("btnChangeImg"),
		btnChangePass = document.getElementById("btnChangePass"),
        btnChangeNotification = document.getElementById("btnChangeNotific"),
		profile_img_lbl = document.getElementById("profile_img_lbl"),
		profile_pass_lbl = document.getElementById("profile_pass_lbl");
	    profile_notific_lbl = document.getElementById("profile_notific_lbl");
    
        var classSelectedNow,lblSelectedNow;
    
		/* При нажатии на вкладку "фотография профиля" */
		btnChangeImg.addEventListener('click', function() {
            changeDisplayViewBtn(profile_img_lbl,'change_img');
		})
		/* При нажатии на вкладку "Пароль" */
		btnChangePass.addEventListener('click', function() {
            changeDisplayViewBtn(profile_pass_lbl,'change_pass');
		})
        /* При нажатии на вкладку "Уведомления" */
        btnChangeNotification.addEventListener('click', function() {
            changeDisplayViewBtn(profile_notific_lbl,'change_notific');
		})
    
    function changeDisplayViewBtn(Lbl_elem,Toggle_elem){
            /* удалить у блока с id 'profile' класс 'change_img' для скрытия вкладки "Пароль" */
            if(classSelectedNow !=null && classSelectedNow !=Toggle_elem ){
                profile.classList.remove(classSelectedNow);
                lblSelectedNow.innerHTML = 'Изменить';
            }
                
			/* добавить блоку с id 'profile' класс 'change_pass' для раскрытия вкладки "Фотография профиля" */
			profile.classList.toggle(Toggle_elem);
			/* Далее тернарник для изменения текста "изменить/отменить" вкладки "Пароль" в зависимости состояния вкладки "скрыта/раскрыта"*/
			Lbl_elem.innerHTML == 'Изменить' ?
			Lbl_elem.innerHTML = 'Отмена' :
			Lbl_elem.innerHTML = 'Изменить';
        
            classSelectedNow = Toggle_elem;
            lblSelectedNow = Lbl_elem;
    }
</script>