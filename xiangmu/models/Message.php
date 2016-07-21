<?php
namespace app\models;
use yii\db\ActiveRecord;

class message extends ActiveRecord{
    //查询数据
	public function responseMsg()
    {
    	/*$connection = \Yii::$app->db;
		$command = $connection->createCommand("SELECT * FROM we_message where wx_id='42653'");
		//$command = $connection->createCommand("SELECT * FROM we_account where wx_rand='$rand'");
		$posts = $command->queryone();
		$aa = implode('', $posts);
		return $aa;*/
		//get post data, May be due to the different environment
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
        /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
               libxml_disable_entity_loader(true);
           	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                   $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	return $resultStr;
                }else{
                	return "Input something...";
                }

        }else {
        	return "";
        	exit;
        }
    }
}