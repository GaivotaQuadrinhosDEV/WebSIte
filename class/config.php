<?php

$mysql = new mysqli('localhost','root', '','u571395036_Gaivota');
$mysql->set_charset('utf8');

if($mysql == FALSE){
    echo "Banco desconectado";
}
