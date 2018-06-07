<?php
/**
 * Created by PhpStorm.
 * User: linsh
 * Date: 2018/5/27
 * Time: 0:35
 */

namespace app\admin\controller;


class Home extends BaseAdmin
{
    public function index(){
        $menus = false;
        $role = $this->db->table('admin_groups')->where(array('gid'=>$this->_admin['gid']))->item();
        if ($role){
            $role['rights'] = (isset($role['rights']) && $role['rights'])?json_decode($role['rights'],true) : [];
        }
        if ($role['rights']){
            $where = 'mid in('.implode(',',$role['rights']).') and ishidden=0 and status=0';
            $menus = $this->db->table('admin_meuns')->where($where)->cates('mid');
            $menus && $menus =$this->getTreeItems($menus);
        }
        $site = $this->db->table('admin_sites')->where(array('names'=>'site'))->item();
        $site && $site['siteValues'] = json_decode($site['siteValues']);
        $this->assign('site',$site);
        //dump($menus);
        $this->assign('role',$role);
        $this->assign('meuns',$menus);
        return $this->fetch();
    }
    public function welcome(){
        return $this->fetch();
    }

    private function getTreeItems($items){
        $tree = array();
        foreach ($items as $item) {
            if (isset($items[$item['pid']])){
                $items[$item['pid']]['children'][] = &$items[$item['mid']];
            }else{
                $tree[] = &$items[$item['mid']];
            }
        }
        return $tree;
    }
}