<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"D:\wamp64\www\Tvideo./application/admin\view\roles\index.html";i:1528089738;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>角色管理</title>
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
        <li class="layui-nav-item"><a href="">角色列表</a></li>
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
        <th>角色名称</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($data['roles']) || $data['roles'] instanceof \think\Collection || $data['roles'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['roles'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
        <td><?php echo $vo['gid']; ?></td>
        <td><?php echo $vo['title']; ?></td>
        <td>
            <button class="layui-btn layui-btn-sm" onclick="add(<?php echo $vo['gid']; ?>)">
                <i class="layui-icon">&#xe642;</i>编辑
            </button>
            <button class="layui-btn layui-btn-sm " onclick="del(<?php echo $vo['gid']; ?>)">
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
    
    function add(gid) {
        layer.open({
            type: 2,
            title: gid>0?'编辑角色':'添加角色',
            shade: 0.3,
            area: ['480px','420px'],
            content: '<?php echo url("roles/add"); ?>?gid='+gid //iframe的url
        });
    }
    
    function del(gid) {
        layer.confirm('确定删除？', {
            icon:3,
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post('<?php echo url("roles/delete"); ?>',{'gid':gid},function (res) {
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