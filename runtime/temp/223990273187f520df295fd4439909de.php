<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"D:\wamp64\www\Tvideo./application/admin\view\menu\index.html";i:1528356974;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="/Tvideo/public/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/Tvideo/public/static/plugins/layui/layui.js"></script>
    <style>
        .layui-nav .layui-nav-item {
            line-height: 45px;
        }
    </style>
</head>
<body>
<div class="header">
    <!--
        <span>管理员列表</span>
    -->
    <ul class="layui-nav" lay-filter="">
        <li class="layui-nav-item"><a href="">管理员列表</a></li>
<!--
        <li class="layui-nav-item" style="float: right;"><button class="layui-btn" onclick="add()"><i class="layui-icon">&#xe608;</i> 添加</button></li>
-->
    </ul>
</div>

<form class="layui-form">

    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
    <?php if($pid>0): ?>
    <button class="layui-btn layui-btn-sm layui-btn-primary" onclick="back(<?php echo $backid; ?>); return false;" style="float: right;margin: 5px 0;">返回上级</button>
    <?php endif; ?>
<table class="layui-table">
    <!--colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>-->
    <thead>
    <tr>
        <th>ID</th>
        <th>排序</th>
        <th>菜单名称</th>
        <th>ccontroller</th>
        <th>method</th>
        <th>是否隐藏</th>
        <th>是否禁用</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($data['lists']) || $data['lists'] instanceof \think\Collection || $data['lists'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['lists'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
        <td><?php echo $vo['mid']; ?></td>
        <td><input type="text" value="<?php echo $vo['orders']; ?>" name="orders[<?php echo $vo['mid']; ?>]" class="layui-input"></td>
        <td class=""><input type="text" value="<?php echo $vo['title']; ?>" name="title[<?php echo $vo['mid']; ?>]" placeholder="请输入标题"class="layui-input"></td>
        <td><input type="text" value="<?php echo $vo['controller']; ?>" name="controller[<?php echo $vo['mid']; ?>]" class="layui-input"></td>
        <td><input type="text" value="<?php echo $vo['method']; ?>" name="method[<?php echo $vo['mid']; ?>]" class="layui-input"></td>
        <td ><input type="checkbox" name="ishidden[<?php echo $vo['mid']; ?>]" value="1" title="隐藏" <?php echo !empty($vo['ishidden'])?'checked':''; ?>></td>
        <td ><input type="checkbox" name="status[<?php echo $vo['mid']; ?>]" value="1" title="禁用" <?php echo !empty($vo['status'])?'checked':''; ?>></td>
        <td>
            <button class="layui-btn layui-btn-sm" style="margin-bottom: 10px;" onclick="child(<?php echo $vo['mid']; ?>); return false;">子菜单</button>
            <br/><button class="layui-btn layui-btn-sm" onclick="deletes(<?php echo $vo['mid']; ?>); return false;">删除</button>
        </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>

    <tr>
        <td></td>
        <td><input type="text" name="orders[0]" class="layui-input"></td>
        <td class=""><input type="text" name="title[0]" placeholder=""class="layui-input"></td>
        <td><input type="text" name="controller[0]" class="layui-input"></td>
        <td><input type="text" name="method[0]" class="layui-input"></td>
        <td ><input type="checkbox" name="ishidden[0]" value="1" title="隐藏" ></td>
        <td ><input type="checkbox" name="status[0]" value="1" title="禁用" ></td>
        <td></td>
    </tr>


    </tbody>
</table>
</form>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button class="layui-btn layui-btn-lg" onclick="save(); return false;" >保存</button>
    </div>
</div>
<script>
    layui.use('element', function(){
        var element = layui.element;
        //…
    });
    //Demo
    layui.use(['layer','form'], function(){
        var form = layui.form;
        layer = layui.layer;
        $ = layui.jquery;
    });
    
    function child(pid) {
        window.location.href="<?php echo url('menu/index'); ?>?pid="+pid;
    }
    function back(pid) {
        window.location.href="<?php echo url('menu/index'); ?>?pid="+pid;
    }
    
    function save() {
        $.post('<?php echo url("menu/save"); ?>',$('form').serialize(),function (res) {
            if (res>0){
                layer.alert(res.msg,{icon:2});
            }else {
                layer.alert(res.msg);
                setTimeout(function () {
                    window.location.reload();
                },1000)
            }
        },'json');
    }
    function deletes(mid){
        layer.confirm('确定删除？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post('<?php echo url("menu/deletes"); ?>',{'mid':mid},function (res) {
                if (res.code >0 ){
                    layer.alert(res.msg,{icon:2});
                }else {
                    layer.alert(res.msg);
                    setTimeout(function () {
                        window.location.reload();
                    },1000);
                }
            },'json');
        });
    }

</script>

</body>
</html>