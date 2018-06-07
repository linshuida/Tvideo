<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"D:\wamp64\www\Tvideo./application/admin\view\site\index.html";i:1528132276;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>网站设置</title>
    <link rel="stylesheet" type="text/css" href="/Tvideo/public/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/Tvideo/public/static/plugins/layui/layui.js"></script>
    <style>
        .layui-nav .layui-nav-item {
            line-height: 45px;
        }
        .layui-form {
            padding:15px;
        }
    </style>
</head>
<body>

<div class="header">
    <!--
        <span>管理员列表</span>
    -->
    <ul class="layui-nav" lay-filter="">
        <li class="layui-nav-item"><a href="">网站设置</a></li>
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

<form class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">网站名称</label>
        <div class="layui-input-inline">
            <input type="text" name="title" value='<?php echo $site['siteValues']; ?>' required  lay-verify="required" placeholder="请输入网站名称" autocomplete="off" class="layui-input">
        </div>
    </div>

</form>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button class="layui-btn" lay-submit lay-filter="formDemo" onclick="save()">立即提交</button>
        <!--
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        -->
    </div>
</div>

<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;
    });
    layui.use('element', function(){
        var element = layui.element;
        //…
    });
    layui.use(['layer'],function () {
        layer = layui.layer;
        $ = layui.jquery;
    });
    function save() {
        var title = $.trim($('input[name="title"]').val());
        if (title == ''){
            console.log(title);
            layer.msg("请输入网站名称",{icon:2});
            return;
        }
        $.post('<?php echo url("site/save"); ?>',$('form').serialize(),function (res) {
            if (res.code>0){
                layer.alert(res.msg,{icon:2});
            }else {
                layer.alert(res.msg,{icon:2});
                setTimeout(function () {
                    window.location.reload();
                },1000);
            }
        },"json");
    }
</script>
</body>
</html>