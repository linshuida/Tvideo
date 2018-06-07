<?php
namespace app\admin\controller;

use app\admin\common\Base;
use util\data\Sysdb;

class Test extends BaseAdmin
{
    public function index(){
        $this->db = new Sysdb();
        $res = $this->db->table('admin')->field('id,username')->lists();
        dump($res);
        $res2 = $this->db->table('admin')->field('id,username')->cates('username');
        dump($res2);
    }
}