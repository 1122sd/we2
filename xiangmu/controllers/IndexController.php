<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Account;
use yii\helpers\Url;
//use app\models\ContactForm;

class IndexController extends Controller
{
    public $layout='menu.php';//替换yii原模板
    public $enableCsrfValidation = false; //接post值时开启
    public function actionIndex(){
        //登录成功跳转此页面否则禁止进入
        $session  = Yii::$app->session;
        $username = $session->get('username');
        if($username){
            return $this->render("index.html",['username'=>$username]);
        }else{
            echo "<script> alert('请先登录') ;</script>";
            return $this->redirect("index.php?r=login/login");
        }
    }

    //微信公众号添加
    public function actionIndex_1(){
        //登录成功跳转此页面否则禁止进入
        $session  = Yii::$app->session;
        $username = $session->get('username');//接session值用于判断是否已经登录
        $request = Yii::$app->request;//用于判断对否有post值传进来
        if($username){
            if($request->isPost){
                $wx_name   = $request->post('wx_name');//微信公众号
                $wx_appid  = $request->post('wx_appid');//18位
                $wx_secret = $request->post('wx_secret');//32位
                $wx_remark   = $request->post('wx_remark');//备注
                $wx_time   = date('Y-m-d H:i:s',time());//备注

                //此处应做微信公众号是否填写正确以及是否相应的值是否符合要求

                /*$article= new\app\models\Account();
                $article->wx_name   = "$wx_name";
                $article->wx_appid  = "$wx_appid";
                $article->wx_secret = "$wx_secret";
                $article->wx_remark = "$wx_remark";
                $article->wx_time   = "$wx_time";*/

                //实例化model 获取随机数
                $account = new Account();
                $rand = $account->rand();
                $url = Url::toRoute(['pub/duijie','p_rand'=>$rand],true);

                $token = "wangfeng";  //生成token

                $uid = $session->get('user_id');  //获取用户id
                $connection = \Yii::$app->db;
                $command = $connection->createCommand("INSERT INTO `we_account` (`wx_name`, `wx_appid`, `wx_secret`, `wx_remark`, `wx_time`, `wx_url`, `wx_token`,`wx_rand`, `u_id`) VALUES ('$wx_name', '$wx_appid', '$wx_secret', '$wx_remark', '$wx_time','$url', '$token', '$rand', '$uid')");
                if($command->execute()){
                  return $this->redirect("index.php?r=index/index_2");
              }else{
                  return $this->render("index_1.html") ;
              }
            }else{
                return $this->render("index_1.html") ;
            }
        }else{
            echo "<script> alert('请先登录') ;</script>";
            return $this->redirect("index.php?r=login/login");
        }
    }

    //管理微信公众号(查询分页展示)
    public function actionIndex_2(){
        header('content-type:text/html;charset=utf-8');
        $request = Yii::$app->request;//用于判断对否有post值传进来
        $sum   = Account::find()->asArray()->count(); //查询总条数  echo $titles;die;

        $strip = 5;                                  //设置每页展示条数
        $pages = ceil($sum/$strip);                 //计算总页数    echo $pages;
            if($request->get('page')){
                $page = $request->get('page');
               // echo $page;
            }else {
                $page = 1;//获取当前页
            }
        $offset = ($page-1)*$strip;//计算偏移量
        $up     = $page<=1?1:$page-1;//上一页
        $down   = $page>=$pages?$pages:$page+1; //下一页
        $data   = Account::find()->offset($offset)->limit($strip)->asArray()->all(); //查询总条数  echo $titles;die;
        if($request->get('page')){
            $arr['data']  = $data;
            $arr['pages'] = $pages;
            $arr['page']  = $page;
            $arr['up']    = $up;
            $arr['down']  = $down;
            echo json_encode($arr);
        }else {
            return $this->render("index_2.html",['data'=>$data,'pages'=>$pages,'page'=>$page,'up'=>$up,'down'=>$down]) ;

        }
        //查询数据展示
    }
    //删除账号
    public function actionSel(){
        $request = Yii::$app->request;//用于判断对否有post值传进来
        $mid = $request->post('mid');
        $data= Account::findOne($mid)->delete();
        // user::deleteAll($id);
        if($data){
            //查询下一条以json格式传过去
           echo 1;
        }else{
           echo 2;
        }
    }
    //公众号查看详细信息
    public function actionIndex_3(){
        $request = Yii::$app->request;//用于判断对否有post值传进来
        $id = $request->post('id');
        $dat =  Account::find()->where(['wx_id'=>$id])->asArray()->one();
        //      print_r($dat);
//        $dat = Account::findOne($id);
        echo json_encode($dat);
    }

    public function actionIndex_4()
    {
        $connection = \Yii::$app->db;
        $session = Yii::$app->session;
        $id = $session->get('user_id');
        $command = $connection->createCommand("SELECT wx_name,wx_id FROM we_account WHERE u_id='$id'");
        $post = $command->queryAll();
        return $this->renderPartial('index_3.html',array('arr'=>$post));
    }
}
