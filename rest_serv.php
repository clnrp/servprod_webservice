<?php
$options = array (
		'uri' => 'http://127.0.0.1/servprod/' 
);
$server = new SoapServer ( null, $options );

$server->setClass ( 'ServiceServProd' );

// Processa a requisição SOAP e envia uma resposta para o cliente.
$server->handle ();

class ServiceServProd {
	
	public function login($email, $passwd) {
		try {
			
			$manager = new MongoDB\Driver\Manager ( "mongodb://localhost:27017" );
			$query = new MongoDB\Driver\Query (['email' => $email]);
			
			$rows = $manager->executeQuery ("test.test1", $query);
			
			if (count ( $rows->toArray () ) > 0) {
				return true;
			}
		} catch ( MongoDB\Driver\Exception\Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
		
		return false;
	}
	
	public function add_user($email, $passwd, $list) {
		try {
			$manager = new MongoDB\Driver\Manager ( "mongodb://localhost:27017" );
			
			$bulk = new MongoDB\Driver\BulkWrite ();
			
			$doc = [ 
					'_id' => new MongoDB\BSON\ObjectID (),
					'email' => $email,
					'password' => $passw,
					'list_servprod' => $list
			];
			$bulk->insert ( $doc );
			// $bulk->update(['name' => 'h5'], ['$set' => ['p' => 52000]]);
			// $bulk->delete(['name' => 'x']);
			
			$manager->executeBulkWrite ( 'test.test1', $bulk );
			return true;
		} catch ( MongoDB\Driver\Exception\Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
		
		return false;
	}
	
	public function change_user() {
		try {
			$manager = new MongoDB\Driver\Manager ( "mongodb://localhost:27017" );
			
			$bulk = new MongoDB\Driver\BulkWrite ();
			$bulk->update ( ['name' => 'h5'], ['$set' => ['p' => 52000]] );
			// $bulk->delete(['name' => 'x']);
			$manager->executeBulkWrite ( 'test.test1', $bulk );
			return true;
		} catch ( MongoDB\Driver\Exception\Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
		
		return false;
	}
	
	public function list_of_servprod($email) {
		try {
			$list = [ ];
			$manager = new MongoDB\Driver\Manager ( "mongodb://localhost:27017" );
			$query = new MongoDB\Driver\Query ( ['email' => $email] );
			
			$rows = $manager->executeQuery ( "test.test1", $query );
			
			if (count ( $rows->toArray () ) > 0) {
			}
		} catch ( MongoDB\Driver\Exception\Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
		
		return $vet;
	}
	
	public function list_all() {
		try {
			$manager = new MongoDB\Driver\Manager ( "mongodb://localhost:27017" );
			$query = new MongoDB\Driver\Query ([]);
			
			$rows = $manager->executeQuery ("test.test1", $query);
		} catch ( MongoDB\Driver\Exception\Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
		
		return $rows->toArray();
	}
	
	public function send_image($image) {
		try {
			$decoded = base64_decode($image);
			file_put_contents('/home/cleoner/spfiles/image'.$month.'.jpg', $decoded);
			return true;
		} catch ( Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
	    return false;
	}
	
	public function get_image($name) {
		try {
			$image = file_get_contents('/home/cleoner/spfiles/'.$name);
			$encode = base64_encode($image);
		} catch ( Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
		return $encode;
	}
	
	public function test() {
		$month  = date('Yd');
		file_put_contents('/home/cleoner/spfiles/image'.$month.'.txt', "teste123");
		return "teste...";
	}
}

?>
