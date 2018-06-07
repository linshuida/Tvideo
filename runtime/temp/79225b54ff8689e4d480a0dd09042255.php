<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"D:\wamp64\www\Tvideo./application/admin\view\home\index.html";i:1528356184;}*/ ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台首页</title>
    <link rel="stylesheet" type="text/css" href="/Tvideo/public/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/Tvideo/public/static/plugins/layui/layui.js"></script>
    <style>
        .layui-side-scroll .layui-nav {
            border-radius: 0px;
        }
    </style>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo"><a href="<?php echo url('home/index'); ?>" style=" color: #fff;/* width: 140px;float: left*/"><?php echo $site['siteValues']; ?>-<span style="font-size: 12px">后台管理系统</span></a></div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <!--<ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>-->
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <!--<img src="http://t.cn/RCzsdCq" class="layui-nav-img">-->
                    <?php echo $admin['username']; ?>【<?php echo $role['title']; ?>】
                </a>
                <!--<dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>-->
            </li>
            <li class="layui-nav-item"><a style="cursor: Pointer;" onclick="loginout()">退出</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll" >
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test" id="menu" lay-shrink="all">
                <?php if(is_array($meuns) || $meuns instanceof \think\Collection || $meuns instanceof \think\Paginator): $i = 0; $__LIST__ = $meuns;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;" ><?php echo $vo['title']; ?></a>
                    <?php if(isset($vo['children']) && $vo['children']){?>
                    <dl class="layui-nav-child">
                        <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cvo): $mod = ($i % 2 );++$i;?>
                        <dd><a href="javascript:;" onclick="menuFire(this)" src="../<?php echo $cvo['controller']; ?>/<?php echo $cvo['method']; ?>" ><?php echo $cvo['title']; ?></a></dd>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                   <?php }?>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <!--<li class="layui-nav-item">
                    <a href="javascript:;">权限管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" onclick="menuFire(this)" src="<?php echo url('menu/index'); ?>">菜单管理</a></dd>
                        <dd><a href="javascript:;" onclick="menuFire(this)" src="<?php echo url('roles/index'); ?>">角色管理</a></dd>
                        <dd><a href="">超链接</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="">系统设置</a></li>
                <li class="layui-nav-item"><a href="">发布商品</a></li>-->
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
       <iframe src="<?php echo url('home/welcome'); ?>" frameborder="0" scrolling="auto" style="width: 100%;height: 100%;"></iframe>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
</div>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;
    });
    layui.use(['layer'],function () {
        $ = layui.jquery;
    });

    function resetMenuHeight() {
        var height = document.documentElement.clientHeight - 180;
    }
    function menuFire(obj) {
        //获取url
        var src = $(obj).attr('src');
        //设置iframe的URL
        $('iframe').attr('src',src);
    }

    function loginout() {
        layer.confirm('确定退出？', {
            btn: ['确定','取消'] //按钮
        }, function() {
            $.get('<?php echo url("account/loginout"); ?>', function (res) {
                if (res.code > 0) {
                    layer.alert(res.msg, {icon: 2});
                } else {
                    layer.msg(res.msg);
                    setTimeout(function () {
                        window.location.href = "<?php echo url('account/login'); ?>";
                    }, 1000);
                }
            }, 'json')
        })
    }
</script>
</body>
</html>