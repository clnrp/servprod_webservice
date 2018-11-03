<?php
 
$options = array('location' => 'http://127.0.0.1/servprod/service1.php', 'uri' => 'http://127.0.0.1/servprod/');

try {
	$client = new SoapClient(null, $options);
	
	try {
		$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
		$bulk = new MongoDB\Driver\BulkWrite;
		//$bulk->delete(['email' => 'test']);
		//$manager->executeBulkWrite('test.test1', $bulk);
		

		/*$query = new MongoDB\Driver\Query (['list' => "lavagem de carro"]);
		$rows = $manager->executeQuery ("test.test1", $query);
		
		$list = array();
		foreach($rows as $r){
			array_push($list, $r);
		}
		echo json_encode($list);*/
		
	} catch ( MongoDB\Driver\Exception\Exception $e ) {
		echo "Exception:", $e->getMessage (), "\n";
	}
	
	$res = $client->search("lavagem de carro");
	echo $res;
	
	//$v = ['cli', 5, 1, ''];
	//$r = $client->search();
	
	
} catch ( MongoDB\Driver\Exception\Exception $e ) {
	echo "Exception:", $e->getMessage (), "\n";
}

?>
