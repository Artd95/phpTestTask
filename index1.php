<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200;400;500&display=swap" rel="stylesheet">
	<title>Практическое задание</title>
	<style>
		body{font-family: 'Mulish', sans-serif;}
		table{border-collapse: collapse; margin: auto;text-align:center;}
		table thead tr {color: #ffffff; font-weight: bold; background: #00bf80;}
		table thead tr td {border: 1px solid #01ab73;}
		table tbody tr td {border: 1px solid #e8e9eb;}
		table tbody tr:nth-child(2n) {background: #f4f4f4;}
		table tbody tr:hover {background: #ebffe8;}
		#search{text-align:center;}
		</style>
</head>

<?php
	require_once 'connection.php'; 																// подключаем скрипт подключения к бд
	$link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link)); 											// подключаемся к бд
	
	$result =  mysqli_query($link, "SELECT MAX(Cost) as max_cost FROM list");					// запрос в бд на поиск макс. значения розничной стоимости
	$row = mysqli_fetch_row($result);															/* выбирает строку из запр., где из нее делает
	                                                                                            массив и возвращает его, где индексы массива соответсвуют номерам столбцов*/
	$maxCost=$row[0];
	mysqli_free_result($result); 																// очищаем запрос

	$result =  mysqli_query($link, "SELECT MIN(WholesaleCost) as min_wholesale_cost FROM list");// запрос в бд на поиск мин. значения оптовой стоимости
	$row = mysqli_fetch_row($result);															/* выбирает строку из запр., где из нее делает 
	                                                                                            массив и возвращает его, где индексы массива соответсвуют номерам столбцов*/
	$minWholesaleCost=$row[0];																	// очищаем запрос
	mysqli_free_result($result);

	$result = mysqli_query($link, "SELECT * FROM list") or die("Ошибка " . mysqli_error($link));// выполняем запрос к бд на вывод всей таблицы
	if($result){
    	$rows = mysqli_num_rows($result); 														// колич-во строк полученных в результате запроса "SELECT"
    	for ($i = 0 ; $i < $rows ; ++$i){														// цикл пробегающий по строкам рез-та запроса
        	$row = mysqli_fetch_row($result); 													/* выбирает строку из запр., где из нее делает 
	                                                                                            массив и возвращает его, где индексы массива соответсвуют номерам столбцов*/
        	echo "<tr>";
        	for ($j = 0 ; $j < count($row) ; ++$j){												// цикл пробегающий по эл-там строки рез-та запроса
            	if (($row[4]+$row[5])<=20 && $j==6){											// условие проверки на малое количество товара на складах
                	echo "<td>$row[$j]</td>
                        <td>
                        <b>Срочно докупите!!!</b></td>";    
            	}
            	else if (($row[4]+$row[5])>20 && $j==6){
               		echo "<td>$row[$j]</td>
                      <td></td>";    
            	}
            	else if ($j==1){
               		echo "<td style=\"text-align:left\">$row[$j]</td>";    
            	}
            	else if ($row[$j]==$maxCost && $j==2){											// условие проверки максимальной розничной стоимости
                	echo "<td style=\"background:red\" title = \"Максимальное значение розничтной цены\">$row[$j]</td>";    
            	}
            	else if ($row[$j]==$minWholesaleCost && $j==3){									// условие проверки минимальной оптовой стоимости
                	echo "<td style=\"background:green\" title = \"Минимальное значение оптовой цены\">$row[$j]</td>";    
            	}
            	else{
                	echo "<td>$row[$j]</td>";
            	}
        	}
        	echo "</tr>";
    	}
    	mysqli_free_result($result);															// очищаем результат
    	mysqli_close($link);
	}
?>	
		</tbody>
	</table>
	<br>
	<table>
		<thead>
			<tr>
	    		<th>Cредняя <br>стоимость</th>
	    		<th>Cредняя <br>оптовая стоимость</th>
	    		<th>Общее количество <br>товара на складах, ед.</th>
	      	<tr>
		</thead>
		<tbody>
			<tr>

<?php
	require_once 'connection.php'; 																// подключаем скрипт подключения к бд
	$link = mysqli_connect($host, $user, $password, $database) 
            or die("Ошибка " . mysqli_error($link)); 											// подключаемся к бд
	
	$result = mysqli_query($link, "SELECT AVG(Cost) AS average_cost FROM list
	") or die("Ошибка " . mysqli_error($link)); 												// выполняем запрос к бд
	if($result){
    	$rows = mysqli_num_rows($result); 														// кол-во строк полученных в результате запроса "SELECT" 
    	$row = mysqli_fetch_row($result); 														/* выбирает строку из запрос, где из строки данных таблицы 																						   делает массив и возвращает его, где индексы массива 																								соответсвуют номерам столбцов*/
    	$averageCost=number_format($row[0], 2, '.', '');										// делает необходимый формат числа
    	mysqli_free_result($result);															// очищаем результат
	}
	
	$result = mysqli_query($link, "SELECT AVG(WholesaleCost) AS average_whCost FROM list
	") or die("Ошибка " . mysqli_error($link)); 												// выполняем запрос к бд
	if($result){
    	$rows = mysqli_num_rows($result); 														// кол-во строк полученных в результате запроса "SELECT" 
    	$row = mysqli_fetch_row($result);														/* выбирает строку из запрос, где из строки данных таблицы 																						   делает массив и возвращает его, где индексы массива 																								соответсвуют номерам столбцов*/
    	$averageWholesaleCost=number_format($row[0], 2, '.', '');								// делает необходимый формат числа
    	mysqli_free_result($result);															// очищаем результат
	}

	$result = mysqli_query($link, "SELECT SUM(WarehouseOne+WarehouseTwo) AS result
	FROM list") or die("Ошибка " . mysqli_error($link)); // выполняем запрос к бд
	if($result){
    	$rows = mysqli_num_rows($result); 														// кол-во строк полученных в результате запроса "SELECT" 
    	$row = mysqli_fetch_row($result); 														/* выбирает строку из запр., где из нее делает 
	                                                                                            массив и возвращает его, где индексы массива соответсвуют номерам столбцов*/
    	$number=$row[0];
    	mysqli_free_result($result);															// очищаем результат
	}

	mysqli_close($link);
	echo "<td>$averageCost</td>
     <td>$averageWholesaleCost</td>
     <td>$number</td>";
?>
			</tr>
		</tbody>
	</table>
</body>