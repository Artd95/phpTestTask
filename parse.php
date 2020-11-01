<?php

require_once 'connection.php'; // подключаем скрипт подключения к бд
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link)); // подключаемся к бд
$handle = fopen("data/pricelist.csv", "r"); // файловый указатель на файлс с данными
while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) { //цикл пробегающий по строкам csv-файла, остановится после того как функция вернет false в рез-те окончания файла или наличии ошибки.
    $num = count($data);
    echo "<br>";
    for ($c=0; $c < $num; $c++) {
        echo $data[$c] . "\n";
		if ($c==0){
        	$name=$data[$c];}
        else if ($c==1) {
        	$cost=str_replace ( ',' , '.' , $data[$c]);}
        else if ($c==2) {
            $wholesaleCost=$data[$c];}
        else if ($c==3) {
            $warehouseOne=$data[$c];}
        else if ($c==4) {
            $warehouseTwo=$data[$c];}
        else {
        	$country=$data[$c];}	
        }
    $query ="INSERT INTO list VALUES('$name', '$cost','$wholesaleCost','$warehouseOne','$warehouseTwo','$country',NULL)"; //создаем строку запроса
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); // выполняем запрос к бд
    if($result){
        echo "<span style='color:blue;'>Данные добавлены</span>";
    }
}
fclose($handle);
mysqli_close($link);

?>