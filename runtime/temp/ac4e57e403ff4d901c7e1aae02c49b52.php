<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"D:\wamp64\www\Tvideo./application/admin\view\videos\index.html";i:1528354746;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>影片列表</title>
    <link rel="stylesheet" type="text/css" href="/Tvideo/public/static/plugins/layui/css/layui.css">
    <script type="text/javascript" src="/Tvideo/public/static/plugins/layui/layui.js"></script>
    <style>
        .layui-nav .layui-nav-item {
            line-height: 45px;
        }

    </style>
</head>
<body>
<div class="header" >
    <!--
        <span>管理员列表</span>
    -->
    <ul class="layui-nav" lay-filter="">
        <li class="layui-nav-item"><a href="">影片列表</a></li>
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

<div class="layui-form-item" style="padding: 15px 0 0 15px;">
    <div class="layui-input-inline">
        <input type="text" id="wd" placeholder="请输入影片名字搜索" value="<?php echo $data['wd']; ?>" class="layui-input">
    </div>
    <button class="layui-btn" onclick="searchs()">
        <i class="layui-icon">&#xe615;</i> 搜索
    </button>
</div>

<table class="layui-table" style="padding-left: 15px">
    <!--<colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>-->
    <thead>
    <tr>
        <th>ID</th>
        <th>频道</th>
        <th>资费</th>
        <th>地区</th>
        <th>影片名称</th>
        <th>pv</th>
        <th>评分</th>
        <th>状态</th>
        <th>添加时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($data['data']['lists']) || $data['data']['lists'] instanceof \think\Collection || $data['data']['lists'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['data']['lists'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
        <td><?php echo $vo['id']; ?></td>
        <td><?php echo isset($data['labels'][$vo['channel_id']])?$data['labels'][$vo['channel_id']]['title']:''; ?></td>
        <td><?php echo isset($data['labels'][$vo['charge_id']])?$data['labels'][$vo['charge_id']]['title']:''; ?></td>
        <td><?php echo isset($data['labels'][$vo['area_id']])?$data['labels'][$vo['area_id']]['title']:''; ?></td>
        <td><?php echo $vo['title']; ?></td>
        <td><?php echo $vo['pv']; ?></td>
        <td><?php echo $vo['score']; ?></td>
        <td><?php echo $vo['status']==0?"<span style='color: #FF5722;'>下线</span>":"发布"; ?></td>
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

<div id="pages"></div>

<script>
    //注意：导航 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function(){
        var element = layui.element;
        //…
    });
    layui.use(['layer','laypage'],function () {
        layer = layui.layer;
        $ = layui.jquery;
        laypage = layui.laypage;


        //执行一个laypage实例
        laypage.render({
            elem: 'pages' //注意，这里的 test1 是 ID，不用加 # 号
            ,count: '<?php echo $data['data']['total']; ?>' //数据总数，从服务端得到
            ,curr:'<?php echo $data['page']; ?>'
            ,limit: '<?php echo $data['pageSize']; ?>'
            ,layout:['prev','page','next','count','skip']
            ,jump: function(obj, first){
                //首次不执行
                if(!first){
                    //do something
                    searchs(obj.curr);
                    //window.location.href="?page="+obj.curr;
                }
            }
        });
    });
    function add(id) {
        layer.open({
            type: 2,
            title: id>0?'编辑影片':'添加影片',
            shade: 0.3,
            area: ['800px','500px'],
            content: '<?php echo url("videos/add"); ?>?id='+id //iframe的url
        });
    }
    function del(id) {
        layer.confirm('确定删除？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post('<?php echo url("videos/delete"); ?>',{'id':id},function (res) {
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
    function searchs(curpage) {
        var wd = $.trim($('#wd').val());
        var url = "<?php echo url('videos/index'); ?>?page="+curpage;
        if (wd){
            url += '&wd='+wd;
        }
        window.location.href=url;
    }
</script>
</body>
</html>