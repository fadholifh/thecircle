<?php 
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	$app = new \Slim\App;

	//Get All User
	$app->get('/api/komentar',function(Request $request, Response $response){
		$sql = "SELECT * FROM komentar";

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
	$app->get('/api/komentar/{id}',function(Request $request, Response $response){
		$id = $request->getAttribute('id');

		$sql = "SELECT * FROM komentar WHERE komentar_id=$id";

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
	$app->post('/api/komentar/add',function(Request $request, Response $response){
		$post_id = $request->getParam('post_id');
		$isi = $request->getParam('isi');
		$waktu = $request->getParam('waktu');
		$penulis = $request->getParam('penulis');
		$status = $request->getParam('status');


		$sql = "INSERT INTO komentar (post_id,isi,waktu,penulis,status) VALUES(:post_id,:isi,:waktu,:penulis,:status)";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);
			$stmt->bindParam(':post_id',$post_id);
			$stmt->bindParam(':isi',$isi);
			$stmt->bindParam(':waktu',$waktu);
			$stmt->bindParam(':penulis',$penulis);
			$stmt->bindParam(':status',$status);

			$stmt->execute();
			echo '{"notice": {"text" : "komentar ditambah"}}';

		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Update User
	$app->put('/api/komentar/update/{komentar_id}',function(Request $request, Response $response){
		$komentar_id = $request->getParam('komentar_id');
		$post_id = $request->getParam('post_id');
		$isi = $request->getParam('isi');
		$waktu = $request->getParam('waktu');
		$penulis = $request->getParam('penulis');
		$status = $request->getParam('status');


		$sql = "UPDATE komentar SET 
			post_id		= :post_id,
			isi 		= :isi,
			waktu 		= :waktu,
			penulis 	= :penulis,
			status 		= :status
		WHERE komentar_id=$komentar_id";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);
			$stmt->bindParam(':post_id',$post_id);
			$stmt->bindParam(':isi',$isi);
			$stmt->bindParam(':waktu',$waktu);
			$stmt->bindParam(':penulis',$penulis);
			$stmt->bindParam(':status',$status);

			$stmt->execute();
			echo '{"notice": {"text" : "komentar diedit"}}';
			
		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});

	//Delete komentar
	$app->delete('/api/komentar/delete/{id}',function(Request $request, Response $response){
		$id = $request->getAttribute('id');

		$sql = "DELETE FROM komentar WHERE komentar_id=$id";

		try{
			$db = new db();
			//connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);
			$stmt->execute();
			$db = null;
			echo '{"notice": {"text" : "komentar dihapus"}}';

		}catch(PDOException $e){
			echo '{"error" : {"text" : '.$e->getMessage().'}';
		}
	});
?>