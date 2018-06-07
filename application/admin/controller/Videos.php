<?php
/**
 * Created by PhpStorm.
 * User: linsh
 * Date: 2018/6/6
 * Time: 0:57
 */

namespace app\admin\controller;


class Videos extends BaseAdmin
{
    public function index(){
        $data['pageSize'] = 5;
        $data['page'] = max(1,(int)input('get.page'));
        $data['wd'] = trim(input('get.wd'));
        $where = array();
        $data['wd'] && $where = 'title like "%'.$data['wd'].'%"';
        $data['data'] = $this->db->table('videos')->where($where)->orders('id desc')->pages($data['pageSize']);

        $label_ids = [];
        foreach ($data['data']['lists'] as $item) {
            !in_array($item['channel_id'],$label_ids) && $label_ids[] = $item['channel_id'];
            !in_array($item['charge_id'],$label_ids) && $label_ids[] = $item['charge_id'];
            !in_array($item['area_id'],$label_ids) && $label_ids[] = $item['area_id'];
        }
        $label_ids && $data['labels'] = $this->db->table('video_label')->where('id in ('.implode(',',$label_ids).')')->cates('id');


        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 添加影片
     */
    public function add(){
        $data['channel'] = $this->db->table('video_label')->where(array('flag'=>'channel'))->lists();
        $data['charge'] = $this->db->table('video_label')->where(array('flag'=>'charge'))->lists();
        $data['area'] = $this->db->table('video_label')->where(array('flag'=>'area'))->lists();
        $id = (int)input('get.id');
        $data['item'] = $this->db->table('videos')->where(array('id'=>$id))->item();


        $this->assign('data',$data);

        return $this->fetch();
    }

    /**
     * 图片上传
     */
    public function upload_img(){
        $file = request()->file('file');
        if ($file == null){
            exit(json_encode(array('code'=>1 ,'msg'=>"上传为空")));
        }
        $info = $file->move(ROOT_PATH.'public'.DS.'uploads');
        $ext = strtolower($info->getExtension());
        if (!in_array($ext,array('jpg', 'jpeg', 'gif', 'bmp', 'png'))){
            exit(json_encode(array('code'=>1 ,'msg'=>"图片格式不正确")));
        }
        $img = '/Tvideo/public/uploads/'.$info->getSavename();
        exit(json_encode(array('code'=>0 ,'msg'=>$img)));

    }

    public function save(){
        $id = (int)input('post.id');
        $data['title'] = trim(input('post.title'));
        $data['channel_id'] = (int)input('post.channel_id');
        $data['charge_id'] = (int)input('post.charge_id');
        $data['area_id'] = (int)input('post.area_id');
        $data['url'] = trim(input('post.url'));
        $data['keywords'] = trim(input('post.keywords'));
        $data['descs'] = trim(input('post.descs'));
        $data['status'] = (int)input('post.status');
        $data['imgs'] = trim(input('post.imgs'));

        if ($data['title'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>"影片名字不能为空")));
        }
        if ($data['url'] == ''){
            exit(json_encode(array('code'=>1,'msg'=>"影片地址不能为空")));
        }

        if ($id){
            $this->db->table('videos')->where(array('id'=>$id))->update($data);
        }else{
            $data['add_time'] = time();
            $this->db->table('videos')->insert($data);
        }
        exit(json_encode(array('code'=>0,'msg'=>"保存成功")));
    }

    public function delete(){
        $id = (int)input('post.id');
        $this->db->table('videos')->where(array('id'=>$id))->delete();
        exit(json_encode(array('code'=>0,'msg'=>"删除成功")));
    }
}