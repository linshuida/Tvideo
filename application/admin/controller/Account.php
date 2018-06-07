<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24
 * Time: 15:40
 */

namespace app\admin\controller;


use app\admin\common\Base;
use util\data\Sysdb;

class Account extends Base
{
    public function login(){

        return $this->fetch();
    }
    public function dologin(){
        $username = trim(input('post.username'));
        $password = trim(input('post.password'));
        $verifycode = trim(input('post.verifycode'));

        if ($username == ""){
            exit(json_encode(array('code'=>1,'msg'=>"用户名不为空")));
        }
        if ($password == ""){
            exit(json_encode(array('code'=>1,'msg'=>"密码不为空")));
        }
        if ($verifycode == ""){
            exit(json_encode(array('code'=>1,'msg'=>"验证码不为空")));
        }
        //验证验证码
        if (!captcha_check($verifycode)){
            exit(json_encode(array('code'=>1,'msg'=>"验证码错误")));
        }
        //验证用户名
        $this->db = new Sysdb();
        $admin = $this->db->table('admin')->where(array('username'=>$username))->item();
        if (!$admin){
            exit(json_encode(array('code'=>1,'msg'=>"用户不存在")));
        }
        //验证密码
        if (md5($password) != $admin['password']){
            exit(json_encode(array('code'=>1,'msg'=>"密码不正确")));
        }
        //验证是否已经被禁用
        if ($admin['status'] == 0){
            exit(json_encode(array('code'=>1,'msg'=>"当前用户已禁用")));
        }
        //设置用户session
        session('admin',$admin);
        exit(json_encode(array('code'=>0,'msg'=>"登录成功")));


        //return $this->fetch('dologin');
    }

    public function loginout(){
        session('admin',null);
        exit(json_encode(array('code'=>0,'msg'=>"退出成功")));
    }
}