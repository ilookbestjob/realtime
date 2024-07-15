<?php
header("Access-Control-Allow-Origin:*");
$stDB="";
$sServer="";
$sUser="";
$sPass="";
$sPort=3306;

$connection=mysqli_connect($sServer,$sUser,$sPass,$stDB,$sPort);

if (!$connection) exit("Ошибка подключения к БД");

mysqli_query($connection,"set names utf8");


$sql="select * from const";
$sql_result=mysqli_query($connection,$sql);


$reult=[];
while($row=mysqli_fetch_assoc($sql_result)){

$result[]=$row;

}

echo json_encode($result);