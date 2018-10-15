<?php

$filename = "reg.txt";   // Файл, куда записывается информация о пользователе (все поля из формы)
$arr = file($filename);

$filename1 = "log.txt";   // Сюда пишется результат регистрации (success/error) с указанием даты и времени
$date = date("d.m.Y H:i:s");
$log = fopen($filename1, "a");

if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['surname']) || empty($_POST['psw']) || empty($_POST['rpsw'])) { 
 
    $result = array(
    	 "name" => "Регистрация не завершена",
       "email" => "Не все поля заполнены"
       ); 
   
    $log = fopen($filename1, "a");
    fwrite($log, $date."  error\r\n");
    fclose($log);
} elseif (($_POST['psw'] != $_POST['rpsw'])) {    // Проверка на совпадение паролей
      $result = array(
       "name" => "Регистрация не завершена",
       "email" => "Пароли должны совпадать"
       ); 
} 
    
  

else { 
  
  if(!preg_match("|^[0-9a-z_-]+@[0-9a-z_^\.]+\.[a-z]{2,6}$|i", $_POST['email']))   // Проверка на правильность заполнение формы "Почта"
    {
      $result = array(
       "name" => "Регистрация не завершена",
       "email" => "Поле 'ПОЧТА' должно соответствовать формату somebody@somewhere.ru"
       ); 
      
    } else {
   

    foreach($arr as $line) {
       
          $data = explode("::",$line);
          $temp[] = $data[3];
        }  
       
      if(in_array($_POST['email'], $temp)) {    // Проверка на совпадение email'а (Сверяет с reg.txt) 
   
           $result = array(
           "name" => "Данный email уже зарегистрирован",
    	     "email" => ""
          );
    
    fwrite($log, $date."  error\r\n");
    fclose($log);
       } else {                                // Запись информации в файл
   
              $fd = fopen($filename, "a");
              $str = $_POST['name']."::".
              $_POST['surname']."::".
              $_POST['psw']."::".
              $_POST['email']."::"."\r\n";
              
              
              fwrite($fd,$str);
              fclose($fd);

              $result = array(
              "name" => "Регистрация прошла успешно",
    	        "email" => ""
    );
              
              fwrite($log, $date."  success\r\n");
              fclose($log);
}
}
} 
 echo json_encode($result);                   

?>
