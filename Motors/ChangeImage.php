<?php
echo "<form style=\"align-self: end;\" action=\"\" method=\"post\" enctype=\"multipart/form-data\">	
                        <input style=\"display:none;\" type=\"file\" id=\"changeImg\" name=\"changeImg\" accept=\".jpg\">";

                            /* Загрузка картинки */
                            if(isset($_FILES['changeImg'])){
                                $errors = array();
                                $file_name = $_FILES['changeImg']['name'];
                                $file_size = $_FILES['changeImg']['size'];
                                $file_tmp = $_FILES['changeImg']['tmp_name'];
                                $file_type = $_FILES['changeImg']['type'];

                                $uploaddir = '';
                               //$uploadfile = $uploaddir . basename($_FILES['image']['name']);
                                $newfilename = basename($_FILES['changeImg']['name']);
                                $uploadfile = $uploaddir . $newfilename;

                                $exploded = explode('.',$file_name);
                                $file_ext=strtolower(end($exploded));	

                                if($file_size> 2097151){
                                    $errors[] = 'Файл должен быть не более 2 Мб';
                                }

                                $temp = explode(".", $_FILES["changeImg"]["name"]);
                                $newfilename = $_POST['motorType'].'.' . end($temp);

                                /* Если нет ошибок грузим файл на сервер, присваивая имя файла AMEI */
                                if(empty($errors)==true){
                                    if (move_uploaded_file($_FILES["changeImg"]["tmp_name"], $uploaddir . $newfilename)) {
                                        echo "<script>alert(\"aaa\");</script>";
                                    } else {
                                        echo "<script>alert(\"aaa\");</script>";
                                    }
                                }else{
                                    print $errors;
                                }	

                            }

                      echo "<div style=\"cursor: pointer; align-self: end; margin: 0 50px;\">
                            <label style=\"cursor: pointer;\"  for=\"changeImg\">Выбрать файл<?php require \"sklad/sys_img/pencil.svg\"?></label>";
echo "<button style=\"background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;\" type=\"submit\">✅</button>
                        </div>
                    </form>";	
?>

<!--?php
echo "<form style=\"align-self: end;\" action=\"\" method=\"post\" enctype=\"multipart/form-data\">	
                        <input style=\"display:none;\" type=\"file\" id=\"changeImg\" name=\"changeImg\" accept=\".jpg\">";
                        
                            /* Загрузка картинки */
                            if(isset($_FILES['changeImg'])){
                                $errors = array();
                                $file_name = $_FILES['changeImg']['name'];
                                $file_size = $_FILES['changeImg']['size'];
                                $file_tmp = $_FILES['changeImg']['tmp_name'];
                                $file_type = $_FILES['changeImg']['type'];

                                $uploaddir = 'Motors/motor_img/';
                               //$uploadfile = $uploaddir . basename($_FILES['image']['name']);
                                $newfilename = basename($_FILES['changeImg']['name']);
                                $uploadfile = $uploaddir . $newfilename;

                                $exploded = explode('.',$file_name);
                                $file_ext=strtolower(end($exploded));	

                                if($file_size> 2097151){
                                    $errors[] = 'Файл должен быть не более 2 Мб';
                                }

                                $temp = explode(".", $_FILES["changeImg"]["name"]);
                                $newfilename = $_POST['motorType'].'.' . end($temp);

                                /* Если нет ошибок грузим файл на сервер, присваивая имя файла AMEI */
                                if(empty($errors)==true){
                                    if (move_uploaded_file($_FILES["changeImg"]["tmp_name"], $uploaddir . $newfilename)) {
                                        
                                    } else {
                                        echo "Ошибка!";
                                    }
                                }else{
                                    print $errors;
                                }	

                            }
                      echo "<div style=\"cursor: pointer; align-self: end; margin: 0 50px;\">
                            <label style=\"cursor: pointer;\"  for=\"changeImg\">"; require "sklad/sys_img/pencil.svg";
                        echo "</label>
                            <button style=\"background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;\" type=\"submit\">✅</button>
                        </div>
                    </form>";		
  ?-->