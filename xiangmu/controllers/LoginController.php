<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;
//use app\models\ContactForm;

class LoginController extends Controller
{
    public $layout='menu.php';//禁yii原模板
    public $enableCsrfValidation = false; //接post值时开启
	    //用户登录
    public function init(){
        parent::init();
        $session = YII::$app->session;
//$session->open();
        if ($session->has('username')){
            return $this->redirect(['/index/index']);
        }
    }
    //用户登录
    public function actionLogin(){
        $request = Yii::$app->request;
        //判断是否存在session

        if($request->isPost){//接收登录信息
            $username = $request->post('username');
            $pwd      = md5($request->post('pwd')) ;
            $titles   =  User::find()->asArray()->where(['u_name'=>$username,'u_pwd'=>$pwd])->one() ;
            if($titles){
                $session = Yii::$app->session;
                $session->set('username', $username);
                $session->set('user_id', $titles['u_id']);
                return $this->redirect("index.php?r=index/index");
            }else{
                echo "<script> alert('用户名或者密码错误') ;</script>";
                return $this->render("login.html");
            }
        }else{
            return $this->render("login.html");
        }
    }

    //退出登录
    public function actionExit(){
        $session = Yii::$app->session;
        $data = $session->remove('username');//删除某一条session数据
        //    $data = $session->destroy();//销毁全部数据
        if($data){
            return $this->render("login.html");
        }else{
            return $this->render("login.html");
        }

    }

}
