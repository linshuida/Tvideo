<?php
/**
 * Created by PhpStorm.
 * User: linsh
 * Date: 2018/6/5
 * Time: 16:11
 */

namespace app\admin\controller;


class Labels extends BaseAdmin
{
    public function index(){
        return $this->fetch();
    }

    /**
     * 频道管理
     */
    public function channel(){
        $channel = $this->db->table('video_label')->where(array('flag'=>'channel'))->lists();
        //dump($channel['lists']);
        $this->assign('data',$channel);
        return $this->fetch();
    }

    /**
     * @return mixed资费管理
     */
    public function charge(){
        $charge = $this->db->table('video_label')->where(array('flag'=>'charge'))->lists();
        //dump($channel['lists']);
        $this->assign('data',$charge);
        return $this->fetch();
    }

    /**
     * @return mixed地区管理
     */
    public function area(){
        $area = $this->db->table('video_label')->where(array('flag'=>'area'))->lists();
        //dump($channel['lists']);
        $this->assign('data',$area);
        return $this->fetch();
    }

    public function save(){
        $flag = trim(input('post.flag'));
        $orders = input('post.orders/a');
        $titel = input('post.title/a');
        $status = input('post.status/a');

        foreach ($orders as $key =>$value) {
            $data['flag'] = $flag;
            $data['orders'] = $value;
            $data['title'] = $titel[$key];
            $data['status'] = isset($status[$key])?1:0;

            if ($key == 0 && $data['title']){
                $this->db->table('video_label')->insert($data);
            }
            if ($key > 0){
                if ($data['title'] == ''){
                    //删除
                    $this->db->table('video_label')->where(array('id'=>$key))->delete();
                }else {
                    //修改
                    $this->db->table('video_label')->where(array('id'=>$key))->update($data);
                }
            }

        }
        exit(json_encode(array('code'=>0,'msg'=>"保存成功")));
    }

    public function deletes(){
        $id = (int)input('post.id');
        $res = $this->db->table('video_label')->where(array('id'=>$id))->delete();
        if (!$res){
            exit(json_encode(array('code'=>1,'msg'=>"删除失败")));
        }else{
            exit(json_encode(array('code'=>0,'msg'=>"删除成功")));
        }
    }
}