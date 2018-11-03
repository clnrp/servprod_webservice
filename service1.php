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
	
	public function add_user($user, $first_name, $email, $password, $list, $latitude, $longitude, $image) {
		try {
			$manager = new MongoDB\Driver\Manager ( "mongodb://localhost:27017" );
			
			$bulk = new MongoDB\Driver\BulkWrite ();
			$id = new MongoDB\BSON\ObjectID ();
			$folder = '/home/cleoner/Imagens/servprod/'.(string)$id.'/';
			mkdir($folder);
			
			$doc = [ 
					'_id' => $id,
					'user' => $user,
					'first_name' => $first_name,
					'email' => $email,
					'password' => $password,
					'list' => $list
			];
			
			if($latitude != null && $longitude != null){
			    $doc['latitude'] = $latitude;
			    $doc['longitude'] = $longitude;
			    //$doc['location'] = array($latitude, $longitude);
		    }
		    
			if ($image != null) {
				$image_name = 'login'.(string)time().'.jpg';
				
				$decoded = base64_decode($image);
				file_put_contents($folder.$image_name, $decoded);
                $doc ['image_name'] = '$image_name';
			}
			
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
			file_put_contents('/home/cleoner/Imagens/servprod/image'.(string)time().'.jpg', $decoded);
			return true;
		} catch ( Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
	    return false;
	}
	
	public function get_image($name) {
		try {
			$image = file_get_contents('/home/cleoner/Imagens/servprod/'.$name);
			$encode = base64_encode($image);
		} catch ( Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
		return $encode;
	}
	
	public function test() {
		$month  = date('Yd');
		file_put_contents('/home/cleoner/Imagens/servprod/image'.(string)time().'.txt', "teste123");
		return "teste...";
	}
	
	public function search($item) {
		try {
			$list = array();
			$manager = new MongoDB\Driver\Manager ( "mongodb://localhost:27017" );
			$query = new MongoDB\Driver\Query (['list' => $item]);
			
			$rows = $manager->executeQuery ("test.test1", $query);
			
			foreach($rows as $r){
				array_push($list, $r);
			}
			
		} catch ( MongoDB\Driver\Exception\Exception $e ) {
			echo "Exception:", $e->getMessage (), "\n";
		}
		
		return json_encode($list);
	}
}

?>
