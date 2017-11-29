<?php 
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	$app = new \Slim\App;

	//Get All User
	$app->get('/api/forum',function(Request $request, Response $response){
		$sql = "SELECT * FROM forum";

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
	$app->get('/api/forum/{id}',function(Request $request, Response $response){
		$id = $request->getAttribute('id');

		$sql = "SELECT * FROM forum WHERE forum_id=$id";

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
	$app->post('/api/forum/add',function(Request $request, Response $response){
		$forum_id = $request->getParam('forum_id');
		$nama = $request->getParam('nama');
		$status = $request->getParam('status');
		$created = $request->getParam('created');


		$sql = "INSERT INTO forum (forum_id,nama,status,created) VALUES(:forum_id,:nama,:status,:created)";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);
			$stmt->bindParam(':forum_id',$forum_id);
			$stmt->bindParam(':nama',$nama);
			$stmt->bindParam(':status',$status);
			$stmt->bindParam(':created',$created);

			$stmt->execute();
			echo '{"notice": {"text" : "User ditambah"}}';

		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Update User
	$app->put('/api/forum/update/{forum_id}',function(Request $request, Response $response){
		$forum_id = $request->getAttribute('forum_id');
		$nama = $request->getParam('nama');
		$status = $request->getParam('status');
		$created = $request->getParam('created');


		$sql = "UPDATE forum SET 
			nama 		= :nama,
			status 		= :status,
			created 	= :created
		WHERE forum_id=$forum_id";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);

			$stmt->bindParam(':forum_id',$forum_id);
			$stmt->bindParam(':nama',$nama);
			$stmt->bindParam(':status',$status);
			$stmt->bindParam(':created',$created);

			$stmt->execute();
			echo '{"notice": {"text" : "Forum diedit"}}';
			
		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Get Single User
	$app->delete('/api/forum/delete/{id}',function(Request $request, Response $response){
		$id = $request->getAttribute('id');

		$sql = "DELETE FROM forum WHERE forum_id=$id";

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