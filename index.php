<?php
define("DEMO", 1); // Если 1, то используются демоданные

require_once 'src/bootstrap.php';
$api = new Contractor();


$inn = '1234567890'; //ИНН контрагента

//Ищем ID контрагента в базе биллинга по ИНН
$contractorId = $api->FindByINNandKPP($inn);
echo "<pre>";
print_r($contractorId);
echo "</pre>";

//Получаем массив с информацией по заданному контрагенту
$arInfo = $api->InfoByID($contractorId);
echo "<pre>";
print_r($arInfo);
echo "</pre>";