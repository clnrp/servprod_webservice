<?php

// http://localhost/servprod/index.php?action=soma&n1=2&n2=5
function soma($numero1,$numero2) {
	return $numero1+$numero2;
}
//echo soma($_GET['n1'],$_GET['n2']);

function sub($numero1,$numero2) {
	return $numero1-$numero2;
}

function get_list()
{
	$list = array(array("id" => 1, "name" => "n1"), array("id" => 2, "name" => "n2"), array("id" => 3, "name" => "n3"), array("id" => 4, "name" => "n4"));
	return $list;
}

$possible_url = array("soma", "sub", 'get_list');

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
{
	switch ($_GET["action"])
	{
		case "soma":
			$value = soma($_GET['n1'],$_GET['n2']);
			break;
		case "sub":
			$value = sub($_GET['n1'],$_GET['n2']);
			break;
		case "get_list":
			$value = get_list();
			break;
	}
}

exit(json_encode($value));

?>