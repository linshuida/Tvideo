<?php
/**
 * Created by PhpStorm.
 * User: linsh
 * Date: 2018/5/27
 * Time: 0:53
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;
use util\data\Sysdb;

class BaseAdmin extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->_admin = session('admin');
        if (!$this->_admin){
            header('location: ../Account/login');
            exit;
        }
        $this->assign('admin',$this->_admin);
        $this->db = new Sysdb();
    }
}