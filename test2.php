<?php
	require_once 'connection.php'; 																				// подключаем скрипт подключения к бд
	$cost=$_GET['cost'];
	$cost_min=$_GET['cost_min'];
	$cost_max=$_GET['cost_max'];
	$value=$_GET['value'];
	$number=$_GET['number'];
	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link)); 		// подключаемся к бд
    if ($value==="0"){
        $value=">";
    } else {
        $value="<";
    }
	$result = mysqli_query($link, "SELECT * FROM list WHERE $cost>=$cost_min AND $cost<=$cost_max 
                        AND WarehouseOne+WarehouseTwo $value $number") or die("Ошибка " . mysqli_error($link));  // выполняем запрос к бд на вывод всей таблицы
  	$data = array();
  	while($row = mysqli_fetch_assoc($result)){                                                                   // оформим каждую строку результата как ассоц. массив
          $data[] = $row;                                                                                    	 // допишем стр. из выборки как новый эл. рез. массива
  	}
  	header("Content-Type: application/json");
  	print json_encode($data);                                                                                      // и отдаём как json
	mysqli_free_result($result);                                                                                 // очищаем результат
	mysqli_close($link);                                                                                         // отключение от бд
?>	