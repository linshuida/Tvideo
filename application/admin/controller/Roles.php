<?php
/**
 * Created by PhpStorm.
 * User: linsh
 * Date: 2018/6/2
 * Time: 18:00
 */

namespace app\admin\controller;


class Roles extends BaseAdmin
{
    /**
     * @return mixed角色列表
     */
    public function index(){
        $data['roles'] = $this->db->table('admin_groups')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function add(){
        $gid = (int)input('get.gid');
        $role = $this->db->table('admin_groups')->where(array('gid'=>$gid))->item();
        $role && $role['rights'] && $role['rights'] =json_decode($role['rights']);
        $this->assign('role',$role);
        $menus_list = $this->db->table('admin_meuns')->where(array('status'=>0))->cates('mid');
        $menus = $this->getTreeItems($menus_list);
        $results = array();
        foreach ($menus as $value) {
            $value['children'] = isset($value['children']) ? $this->formatMenus($value['children']):false;
            $results[] = $value;
        }
        $this->assign('menu',$results);
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
    private function formatMenus($items,&$res = array()){
        foreach ($items as $item) {
            if (!isset($item['children'])){
                $res[] = $item;
            }else{
                $tem = $item['children'];
                unset($item['children']);
                $res[] = $item;
                $this->formatMenus($tem,$res);
            }
        }
        return $res;
    }

    public function save(){
        $gid = (int) input('post.gid');

        $data['title'] = trim(input('post.title'));
        $menu = input('post.menu/a');
        if (!$data['title']){
            exit(json_encode(array('code'=>1,'msg'=>'请输入角色名字')));
        }
        $menu && $data['rights'] =json_encode(array_keys($menu));
        if ($gid){
            $this->db->table('admin_groups')->where(array('gid'=>$gid))->update($data);
        }else{
            $this->db->table('admin_groups')->insert($data);
        }

        exit(json_encode(array('code'=>0,'msg'=>"保存成功")));
    }

    public function delete(){
        $gid = (int)input('post.gid');
        $this->db->table('admin_groups')->where(array('gid'=>$gid))->delete();
        exit(json_encode(array('code'=>0,'msg'=>"删除成功")));
    }
}