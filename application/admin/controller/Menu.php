<?php
/**
 * Created by PhpStorm.
 * User: linsh
 * Date: 2018/5/30
 * Time: 22:05
 */

namespace app\admin\controller;


class Menu extends BaseAdmin
{
    /**
     * @return mixed菜单列表
     */
    public function index(){
        $pid = (int)input('get.pid');
        $data['lists'] = $this->db->table('admin_meuns')->where(array('pid'=>$pid))->lists();

        $backid = 0;
        if ($pid > 0){
            $parent = $this->db->table('admin_meuns')->where(array('mid'=>$pid))->item();
            $backid = $parent['pid'];
        }
        $this->assign('pid',$pid);
        $this->assign('backid',$backid);

        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 保存菜单
     */
    public function save(){
        $pid = (int)input('post.pid');
        $orders = input('post.orders/a');
        $titel = input('post.title/a');
        $controller = input('post.controller/a');
        $method = input('post.method/a');
        $ishidden = input('post.ishidden/a');
        $status = input('post.status/a');

        foreach ($orders as $key =>$value) {
            $data['pid'] = $pid;
            $data['orders'] = $value;
            $data['title'] = $titel[$key];
            $data['controller'] = $controller[$key];
            $data['method'] = $method[$key];
            $data['ishidden'] = isset($ishidden[$key])? 1 :0;
            $data['status'] = isset($status[$key])?1:0;

            if ($key == 0 && $data['title']){
                $this->db->table('admin_meuns')->insert($data);
            }
            if ($key > 0){
                if ($data['title'] == '' && $data['controller'] == '' && $data['method'] == ''){
                    //删除
                    $this->db->table('admin_meuns')->where(array('mid'=>$key))->delete();
                }else {
                    //修改
                    $this->db->table('admin_meuns')->where(array('mid'=>$key))->update($data);
                }
            }

        }
        exit(json_encode(array('code'=>0,'msg'=>"保存成功")));

    }

    public function deletes(){
        $mid = (int)input('post.mid');
        $pid = $this->db->table('admin_meuns')->field('pid')->where(array('mid'=>$mid))->item();
        if ($pid > 0){
            $this->db->table('admin_meuns')->where(array('mid'=>$mid))->delete();
        }
        $res = $this->db->table('admin_meuns')->where(array('pid'=>$mid))->delete();

        if (!$res){
            exit(json_encode(array('code'=>1,'msg'=>"删除失败")));
        }else{
            exit(json_encode(array('code'=>0,'msg'=>"删除成功")));
        }
    }
}