<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET İŞLEMİ İLE TEK VERİ ÇEKME BAŞLANGIÇ
	$app->get('/api/user/{id}', function (Request $request, Response $response)
	{
		$id = $request->getAttribute("id");
		$sql = "SELECT * FROM users where 1 and id=$id";

		try
		{
			$db= new db();
			$db = $db->connect();
			$stmt = $db->query($sql);
			$users = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db=null;
			return json_encode($users);
		} 
		catch(PDOException $e)
		{
			return '{"error":{"text": '.$e->getMessage().'}}';
		}
	});
// GET İŞLEMİ İLE TEK VERİ ÇEKME BİTİŞ

// GET İŞLEMİ İLE TÜM VERİLERİ ÇEKME BAŞLANGIÇ
	$app->get('/api/users/', function (Request $request, Response $response)
	{
		$sql = "SELECT * FROM users WHERE 1";
		try
		{
			$db= new db();
			$db = $db->connect();
			$stmt = $db->query($sql);
			$users = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db=null;
			
			// Türkçe json_encode çözümü başlangıç
			function utf8ize($d) 
			{
			    if (is_array($d)) 
			    	foreach ($d as $k => $v) 
			            $d[$k] = utf8ize($v);

			    else if(is_object($d))
			        foreach ($d as $k => $v) 
			            $d->$k = utf8ize($v);

			    else 
			        return utf8_encode($d);

			    return $d;
			}
			// Türkçe json_encode çözümü Bitiş

			return json_encode(utf8ize($users));
		} 
		catch(PDOException $e)
		{
			return '{"error":{"text": '.$e->getMessage().'}}';
		}
	});
// GET İŞLEMİ İLE TÜM VERİLERİ ÇEKME BİTİŞ


// POST İŞLEMİ İLE VERİ EKLEME BAŞLANGIÇ
	$app->post('/api/user/add', function (Request $request, Response $response)
	{

		$name 		= $request->getParam('name');
		$surname 	= $request->getParam('surname');
		$phone 		= $request->getParam('phone');

		$sql = "INSERT INTO users (name,surname,phone) 
				VALUES(:name,:surname,:phone)";

		try
		{
			$db= new db();
			$db = $db->connect();
			$stmt = $db->prepare($sql);

			$stmt->bindParam(':name',$name);
			$stmt->bindParam(':surname',$surname);
			$stmt->bindParam(':phone',$phone);

			$stmt->execute();

			return '{"notice":{"text": "Kullanıcı eklendi"}}';
		} 
		catch(PDOException $e)
		{
			return '{"error":{"text": '.$e->getMessage().'}}';
		}
	});
// POST İŞLEMİ İLE VERİ EKLEME BİTİŞ


// PUT İŞLEMİ İLE VERİ GÜNCELLEME BAŞLANGIÇ
	$app->put('/api/user/update/{id}', function (Request $request, Response $response)
	{
		$id 		= $request->getAttribute('id');;
		$name 		= $request->getParam('name');
		$surname 	= $request->getParam('surname');
		$phone 		= $request->getParam('phone');

		$sql = "UPDATE users SET 
					name 		=:name,
					surname 	=:surname,
					phone 		=:phone
				WHERE id = $id";
			
		try
		{
			$db= new db();
			$db = $db->connect();
			$stmt = $db->prepare($sql);

			$stmt->bindParam(':name',$name);
			$stmt->bindParam(':surname',$surname);
			$stmt->bindParam(':phone',$phone);

			$stmt->execute();

			return '{"notice":{"text": "Kullanıcı güncellendi"}}';
		} 

		catch(PDOException $e)
		{
			return '{"error":{"text": '.$e->getMessage().'}}';
		}
	});
// PUT İŞLEMİ İLE VERİ GÜNCELLEME BİTİŞ



// DELETE İŞLEMİ İLE VERİ SİLME BAŞLANGIÇ
	$app->delete('/api/user/delete/{id}', function (Request $request, Response $response)
	{
		$id = $request->getAttribute("id");
		$sql = "delete FROM users where id=$id";

		try
		{
			$db= new db();
			$db = $db->connect();
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$db=null;

			return '{"notice":{"text": "Kullanıcı silindi"}}';
		} 
		catch(PDOException $e)
		{
			return '{"error":{"text": '.$e->getMessage().'}}';
		}
	});
// DELETE İŞLEMİ İLE VERİ SİLME BİTİŞ