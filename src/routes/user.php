<?php 
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	$app = new \Slim\App;

	//Get All User
	$app->get('/api/user',function(Request $request, Response $response){
		$sql = "SELECT * FROM user";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->query($sql);
			$users = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo json_encode($users);
		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Get Single User
	$app->get('/api/user/{id}',function(Request $request, Response $response){
		$id = $request->getAttribute('id');

		$sql = "SELECT * FROM user WHERE nim=$id";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->query($sql);
			$user = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo json_encode($user);
		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Add User
	$app->post('/api/user/add',function(Request $request, Response $response){
		$nim = $request->getParam('nim');
		$email = $request->getParam('email');
		$password = $request->getParam('password');
		$nama = $request->getParam('nama');
		$alamat = $request->getParam('alamat');
		$ttl = $request->getParam('ttl');
		$img = $request->getParam('img');
		$no_hp = $request->getParam('no_hp');
		$work = $request->getParam('work');
		$bio = $request->getParam('bio');
		$registered = $request->getParam('registered');
		$status = $request->getParam('status');


		$sql = "INSERT INTO user (nim,email,password,nama,alamat,ttl,img,no_hp,work,bio,registered,status) VALUES(:nim,:email,:password,:nama,:alamat,:ttl,:img,:no_hp,:work,:bio,:registered,:status)";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);
			$stmt->bindParam(':nim',$nim);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':password',$password);
			$stmt->bindParam(':nama',$nama);
			$stmt->bindParam(':alamat',$alamat);
			$stmt->bindParam(':ttl',$ttl);
			$stmt->bindParam(':img',$img);
			$stmt->bindParam(':no_hp',$no_hp);
			$stmt->bindParam(':work',$work);
			$stmt->bindParam(':bio',$bio);
			$stmt->bindParam(':registered',$registered);
			$stmt->bindParam(':status',$status);

			$stmt->execute();
			echo '{"notice": {"text" : "User ditambah"}}';

		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Update User
	$app->put('/api/user/update/{nim}',function(Request $request, Response $response){
		$nim = $request->getAttribute('nim');
		$email = $request->getParam('email');
		$password = $request->getParam('password');
		$nama = $request->getParam('nama');
		$alamat = $request->getParam('alamat');
		$ttl = $request->getParam('ttl');
		$img = $request->getParam('img');
		$no_hp = $request->getParam('no_hp');
		$work = $request->getParam('work');
		$bio = $request->getParam('bio');
		$registered = $request->getParam('registered');
		$status = $request->getParam('status');


		$sql = "UPDATE user SET 
			email 		= :email,
			password 	= :password,
			nama 		= :nama,
			alamat 		= :alamat,
			ttl 		= :ttl,
			img 		= :img,
			no_hp 		= :no_hp,
			work 		= :work,
			bio 		= :bio,
			registered 	= :registered,
			status 		= :status
		WHERE nim=$nim";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':password',$password);
			$stmt->bindParam(':nama',$nama);
			$stmt->bindParam(':alamat',$alamat);
			$stmt->bindParam(':ttl',$ttl);
			$stmt->bindParam(':img',$img);
			$stmt->bindParam(':no_hp',$no_hp);
			$stmt->bindParam(':work',$work);
			$stmt->bindParam(':bio',$bio);
			$stmt->bindParam(':registered',$registered);
			$stmt->bindParam(':status',$status);

			$stmt->execute();
			echo '{"notice": {"text" : "User diedit"}}';
			
		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Get Single User
	$app->delete('/api/user/delete/{id}',function(Request $request, Response $response){
		$id = $request->getAttribute('id');

		$sql = "DELETE FROM user WHERE nim=$id";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);
			$stmt->execute();
			$db = null;
			echo '{"notice": {"text" : "User dihapus"}}';

		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});
?>