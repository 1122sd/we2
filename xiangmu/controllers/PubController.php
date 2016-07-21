<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Message;

class PubController extends Controller
{
	public function actionDuijie()
	{
		$request = Yii::$app->request;
		$rand = $request->get('p_rand');
		$connection = \Yii::$app->db;
		//$command = $connection->createCommand("SELECT * FROM we_account where wx_rand='42653'");
		$command = $connection->createCommand("SELECT * FROM we_account where wx_rand='$rand'");
		$posts = $command->queryone();
		$tokens = $posts['wx_token'];

		$echoStr = $_GET["echostr"];
		$signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$token = $tokens;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			echo $echoStr;
			$aa = new message();
			echo $aa->responseMsg();
			return true;
		}else{
			return false;
		}
	}

	public $enableCsrfValidation = false; //接post值时开启
	public function actionMessage()
	{
		$request = Yii::$app->request;
		$wx_id = $request->post('wx_id');
		$wx_keys = $request->post('wx_keys');
		$wx_content = $request->post('wx_content');
		$connection = \Yii::$app->db;
        $command = $connection->createCommand("INSERT INTO `wx_message` (`ms_keys`, `ms_content`, `wx_id`) VALUES ('$wx_keys', '$wx_content', '$wx_id')");
        if($command->execute()){
        	return $this->redirect("index.php?r=index/index_4");
        }
	}

}