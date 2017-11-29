<?php 
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	$app = new \Slim\App;

	//Get All tag
	$app->get('/api/tag',function(Request $request, Response $response){
		$sql = "SELECT * FROM tag";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->query($sql);
			$tags = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo json_encode($tags);
		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Get Single tag
	$app->get('/api/tag/{id}',function(Request $request, Response $response){
		$id = $request->getAttribute('id');

		$sql = "SELECT * FROM tag WHERE tag_id=$id";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->query($sql);
			$tag = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			echo json_encode($tag);
		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Add User
	$app->post('/api/tag/add',function(Request $request, Response $response){
		$tag_id = $request->getParam('tag_id');
		$nama = $request->getParam('nama');
		$status = $request->getParam('status');
		

		$sql = "INSERT INTO tag (tag_id,nama,status) VALUES(:tag_id,:nama,:status)";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);
			$stmt->bindParam(':tag_id',$tag_id);
			$stmt->bindParam(':nama',$nama);
			$stmt->bindParam(':status',$status);

			$stmt->execute();
			echo '{"notice": {"text" : "tag ditambah"}}';

		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Update tag
	$app->put('/api/tag/update/{tag_id}',function(Request $request, Response $response){
		$tag_id = $request->getAttribute('tag_id');
		$nama = $request->getAttribute('nama');
		$status = $request->getAttribute('status');


		$sql = "UPDATE tag SET 
			nama 		= :nama,
			status 		= :status
		WHERE tag_id=$tag_id";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);

			$stmt->bindParam(':nama',$nama);
			$stmt->bindParam(':status',$status);

			$stmt->execute();
			echo '{"notice": {"text" : "tag diedit"}}';
			
		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Get Single tag
	$app->delete('/api/tag/delete/{id}',function(Request $request, Response $response){
		$id = $request->getAttribute('id');

		$sql = "DELETE FROM tag WHERE tag_id=$id";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);
			$stmt->execute();
			$db = null;
			echo '{"notice": {"text" : "tag dihapus"}}';

		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});
?>