<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"D:\wamp64\www\Tvideo./application/admin\view\admin\index.html";i:1527688395;}*/ ?>
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
        <li class="layui-nav-item" style="float: right;"><button class="layui-btn" onclick="add()"><i class="layui-icon">&#xe608;</i> 添加</button></li>
        <!--<li class="layui-nav-item layui-this"><a href="">产品</a></li>
        <li class="layui-nav-item"><a href="">大数据</a></li>
        <li class="layui-nav-item">
            <a href="javascript:;">解决方案</a>
            <dl class="layui-nav-child"> &lt;!&ndash; 二级菜单 &ndash;&gt;
                <dd><a href="">移动模块</a></dd>
                <dd><a href="">后台模版</a></dd>
                <dd><a href="">电商平台</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item"><a href="">社区</a></li>-->
    </ul>
</div>


<table class="layui-table">
    <!--<colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>-->
    <thead>
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>真实姓名</th>
        <th>角色</th>
        <th>状态</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($data['lists']) || $data['lists'] instanceof \think\Collection || $data['lists'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['lists'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
        <td><?php echo $vo['id']; ?></td>
        <td><?php echo $vo['username']; ?></td>
        <td><?php echo $vo['truename']; ?></td>
        <td><?php echo $vo['gid']; ?></td>
        <td><?php echo $vo['status']==0?"<span style='color: #FF5722;'>禁用</span>":"正常"; ?></td>
        <td><?php echo date('Y-m-d H:i:s',$vo['add_time']); ?></td>
        <td>
            <button class="layui-btn layui-btn-sm" onclick="add(<?php echo $vo['id']; ?>)">
                <i class="layui-icon">&#xe642;</i>编辑
            </button>
            <button class="layui-btn layui-btn-sm " onclick="del(<?php echo $vo['id']; ?>)">
                <i class="layui-icon">&#xe640;</i>删除
            </button>
        </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
</table>

<script>
    //注意：导航 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function(){
        var element = layui.element;
        //…
    });
    layui.use(['layer'],function () {
        layer = layui.layer;
        $ = layui.jquery;
    });
    function add(id) {
        layer.open({
            type: 2,
            title: id>0?'编辑管理员':'添加管理员',
            shade: 0.3,
            area: ['480px','420px'],
            content: '<?php echo url("admin/add"); ?>?id='+id //iframe的url
        });
    }
    function del(id) {
        layer.confirm('确定删除？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post('<?php echo url("admin/delete"); ?>',{'id':id},function (res) {
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