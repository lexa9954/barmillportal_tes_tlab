<?php
                            /* Загрузка картинки */
                            if(isset($_FILES['changeImg'])){
                                $errors = array();
                                $file_name = $_FILES['changeImg']['name'];
                                $file_size = $_FILES['changeImg']['size'];
                                $file_tmp = $_FILES['changeImg']['tmp_name'];
                                $file_type = $_FILES['changeImg']['type'];

                                $uploaddir = 'sklad/img/';
                               //$uploadfile = $uploaddir . basename($_FILES['image']['name']);
                                $newfilename = basename($_FILES['changeImg']['name']);
                                $uploadfile = $uploaddir . $newfilename;

                                $exploded = explode('.',$file_name);
                                $file_ext=strtolower(end($exploded));	

                                if($file_size> 2097151){
                                    $errors[] = 'Файл должен быть не более 2 Мб';
                                }

                                $temp = explode(".", $_FILES["changeImg"]["name"]);
                                $newfilename = $_COOKIE["id_material"].'.' . end($temp);

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
                        ?>