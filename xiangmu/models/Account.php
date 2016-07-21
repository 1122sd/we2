<?php
namespace app\models;
use yii\db\ActiveRecord;

class account extends ActiveRecord{
	//生成随机数
    public function rand()
    {
        $re = '';
        $res = '';
        $num = 16;
        $num1 = 8;
        $s = 'abcdefghijklmnopqrstuvw123456789012345678901234567890xyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $a = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        while(strlen($re)<$num) {
            $re .= $s[rand(0, strlen($s)-1)]; //从$s中随机产生一个字符
        }
        while(strlen($res)<$num1) {
            $res .= $a[rand(0, strlen($a)-1)]; //从$s中随机产生一个字符
        }
        $rand = rand(999,99999);
        return $rand;
    }
}