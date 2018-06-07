<?php
/**
 * Created by PhpStorm.
 * User: linsh
 * Date: 2018/6/5
 * Time: 0:23
 */

namespace app\admin\controller;


class Site extends BaseAdmin
{
    public function index(){
        $site = $this->db->table('admin_sites')->where(array('names'=>'site'))->item();
        $site && $site['siteValues'] = json_decode($site['siteValues']);
        $this->assign('site',$site);
        return $this->fetch();
    }
    public function save(){
        $title = trim(input('post.title'));
        $site = $this->db->table('admin_sites')->where(array('names'=>'site'))->item();
        if (!$site){
            $this->db->table('admin_sites')->insert(array('names'=>'site','siteValues'=>json_encode($title)));
        }else{
            $value['siteValues'] = json_encode($title);
            $this->db->table('admin_sites')->where(array('names'=>'site'))->update($value);
        }
        exit(json_encode(array('code'=>0,'msg'=>"保存成功")));
    }
}