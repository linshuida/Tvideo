<?php
/**
 * Created by PhpStorm.
 * User: linsh
 * Date: 2018/5/27
 * Time: 17:19
 */

namespace app\admin\controller;
use think\Db;
use util\data\Sysdb;

class Admin extends BaseAdmin
{
    /**
     * @return mixed管理员列表
     */
    public function index(){
        $data['lists'] = $this->db->table('admin')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * @return mixed添加管理员
     */
    public function add(){
        $id = (int)input('get.id');
        $data['item'] = $this->db->table('admin')->where(array('id'=>$id))->item();


        $data['groups'] = $this->db->table('admin_groups')->cates('gid');
       // $data['admin'] = $this->db->table('admin')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 保存添加管理员
     */
    public function save(){
        $id = (int)input('post.id');
        $data['username'] = trim(input('post.username'));
        $data['gid'] = (int)input('post.gid');
        $password = trim(input('post.password'));
        $data['truename'] = trim(input('post.truename'));
        $data['status'] = (int)input('post.status');


        if (!$data['username']){
            exit(json_encode(array('code'=>1,'msg'=>"用户名不能为空")));
        }
        if (!$data['gid']){
            exit(json_encode(array('code'=>1,'msg'=>"角色不能为空")));
        }
        if ($id == 0 && !$password){
            exit(json_encode(array('code'=>1,'msg'=>"密码不能为空")));
        }
        if (!$data['truename']){
            exit(json_encode(array('code'=>1,'msg'=>"真实姓名不能为空")));
        }
        //$data['password'] = md5($data['username'].$password);
        if ($password){
            $data['password'] = md5($password);
        }

        $res = true;
        if ($id == 0){
            $item = $this->db->table('admin')->where(array('username'=>$data['username']))->item();
            if ($item) {
                exit(json_encode(array('code'=>1,'msg'=>"该用户已存在")));
            }
            $data['add_time'] = time();
            $res = $this->db->table('admin')->insert($data);
        }else {
            $this->db->table('admin')->where(array('id'=>$id))->update($data);
        }

        //return $this->fetch();

        if (!$res){
            exit(json_encode(array('code'=>1,'msg'=>"添加失败")));
        }
        exit(json_encode(array('code'=>0,'msg'=>"添加成功")));
    }

    public function delete(){
        $id = input('post.id');
        $res = $this->db->table('admin')->where(array('id'=>$id))->delete($id);
        if (!$res){
            exit(json_encode(array('code'=>1,'msg'=>"删除失败")));
        }else{
            exit(json_encode(array('code'=>0,'msg'=>"删除成功")));
        }
    }
}