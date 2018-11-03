<?php

$resultado = file_get_contents('http://localhost/servprod/index.php?action=soma&n1=2&n2=5');
$resultado= json_decode($resultado, true);
echo $resultado;

?>