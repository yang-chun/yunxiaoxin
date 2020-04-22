<?php /*a:2:{s:63:"E:\xampp\htdocs\rhaphp\themes/pc/extension/excelfile\index.html";i:1587524995;s:68:"E:\xampp\htdocs\rhaphp\themes/pc/extension/..\admin\common\base.html";i:1587532401;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <title>云小薪平台管理系统</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="/public/static//admin/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="/public/static//admin/css/admin_base.css" />
    <script type="text/javascript" src="/public/static//jquery/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="/public/static//layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/static//layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="/public/static//icon/icon.css" />
    
    <style>
        <?php if($setScreen ==1): ?>
        .container_body, .wrap{width: 100%;}
        .sidebar{float:left;width: 12%;}
        .content{float: left;width: 98.3%;min-height: 600px;background: #fff;margin-left: 15px;margin-top: 15px;margin-right: 15px}
        .main-logo{margin-left: 5px;}
        .menu dl dt .type-ico{margin-left: 5%}
        .menu dl dd a{padding-left: 22%;}
        #addon_menu .item-icon{margin-left: 5%;}
        .addon_menu-left-nav-a .item-icon{left: 0;}
        .addon_menu-left-nav-a {padding-left: 23%;}
        a{
            text-decoration: none!important;
        }
        <?php endif; ?>
        .layui-logo img{
          width: 70%;
        }
    </style>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">
      <img src="/public/static/images/logo.png" alt="">
    </div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="/">首页</a></li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="/public/static/images/user_img.jpg" class="layui-nav-img">
          <?php echo htmlentities($admin['admin_name']); ?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="<?php echo url('mp/index/updatemp'); ?>">更改配置</a></dd>
          <dd><a href="">修改密码</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="<?php echo url('admin/Login/out'); ?>">退出</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?>
        <li class="layui-nav-item <?php if($t['shows'] == '1'): ?>layui-nav-itemed<?php endif; ?>" > <!-- layui-nav-itemed -->
          <a class="" href="javascript:;"><?php echo htmlentities($t['name']); ?></a>
          <dl class="layui-nav-child ">
            <?php if(is_array($t['child']) || $t['child'] instanceof \think\Collection || $t['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $t['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?>
            <dd style="padding-left:10px;" class="<?php if($c['shows'] == '1'): ?>layui-this<?php endif; ?>"><a href="<?php echo url($c['url']); ?>"><?php echo htmlentities($c['name']); ?></a></dd>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </dl>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </div>
  </div>

      <div class="layui-body" >
        <!-- 内容主体区域 -->
        <div class="content" id="tradeSearchBd">
            <?php if(isset($menu_tile) OR $menu_title != ''): ?>
            <div class="content-hd">
                <h2><?php echo htmlentities($menu_title); ?></h2>
            </div>
            <?php endif; ?>
            
<link rel="stylesheet" type="text/css" href="/public/static//admin/css/pc-style.css" />
<div class="layui-card-body">
    <div class="test-table-reload-btn" style="margin-bottom: 10px;">
        <div class="layui-inline">
            <input class="layui-input" name="keyword" value="<?php echo htmlentities($keyword); ?>" placeholder="请输入身份证号或姓名">
        </div>
        <button class="layui-btn" id="search">搜索</button>
    </div>
    <div class="layui-form layui-border-box">
        <table cellspacing="0" cellpadding="0" border="0" class="layui-table">
            <thead>
                <tr>
                    <th data-field="id" data-key="1-0-0" class=" layui-unselect">
                        <div class="layui-table-cell laytable-cell-1-0-0" ><span>ID</span></div>
                    </th>
                    <th data-field="username" data-key="1-0-1" class="">
                        <div class="layui-table-cell laytable-cell-1-0-1"><span>文件名称</span></div>
                    </th>
                    <th data-field="sex" data-key="1-0-2" class=" layui-unselect">
                        <div class="layui-table-cell laytable-cell-1-0-2"><span>原文件名称</span></div>
                    </th>
                    <th data-field="sign" data-key="1-0-4" class="">
                        <div class="layui-table-cell laytable-cell-1-0-4"><span>类型</span></div>
                    </th>
                    <th data-field="city" data-key="1-0-3" class="">
                        <div class="layui-table-cell laytable-cell-1-0-3"><span>创建时间</span></div>
                    </th>
                    <th data-field="sign" data-key="1-0-5" class="">
                        <div class="layui-table-cell laytable-cell-1-0-5"><span>操作</span></div>
                    </th>
                </tr>
            <tbody>
                <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr data-index="0">
                    <td data-field="id" data-key="1-0-0" class="">
                        <div class="layui-table-cell laytable-cell-1-0-0"><?php echo htmlentities($vo['id']); ?></div>
                    </td>
                    <td data-field="username" data-key="1-0-1" class="">
                        <div class="layui-table-cell laytable-cell-1-0-1"><?php echo htmlentities($vo['excel_name']); ?></div>
                    </td>
                    <td data-field="sex" data-key="1-0-2" class="">
                        <div class="layui-table-cell laytable-cell-1-0-2"><?php echo htmlentities($vo['original_name']); ?></div>
                    </td>
                    <td data-field="sign" data-key="1-0-4" class="">
                        <div class="layui-table-cell laytable-cell-1-0-4"><?php echo $vo['type']==1 ? '工资' : ''; ?></div>
                    </td>
                    <td data-field="city" data-key="1-0-3" class="">
                        <div class="layui-table-cell laytable-cell-1-0-3"><?php echo htmlentities(date("Y-m-d",!is_numeric($vo['createtime'])? strtotime($vo['createtime']) : $vo['createtime'])); ?></div>
                    </td>
                    <td data-field="sign" data-key="1-0-5" class="">
<!--                         <button type="button" class="layui-btn layui-btn-normal details" value="<?php echo htmlentities($vo['id']); ?>">详情</button> -->
                        <button type="button" class="layui-btn layui-btn-danger delete" value="<?php echo htmlentities($vo['id']); ?>">删除</button>

                    </td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            </thead>
        </table>
        <?php if($count == 0): ?>
            <div class="No_info">暂无信息</div>
        <?php endif; ?>



        <div id="layui-table-page5">

            <div class="layui-box layui-laypage layui-laypage-default" id="layui-laypage-3">
            
            <?php echo $page; ?>
<!--             <span class="layui-laypage-skip">到第<input type="text" min="1" value="1" class="layui-input">页
            <button type="button" class="layui-laypage-btn">确定</button></span> -->
            <span class="layui-laypage-count">共 <?php echo htmlentities($count); ?> 条</span>
            </div>
        </div>
        <style>
        .laytable-cell-5-0-0 {
            width: 80px;
        }
        .laytable-cell-5-0-1 {
            width: 80px;
        }
        .laytable-cell-5-0-2 {
            width: 80px;
        }
        .laytable-cell-5-0-3 {
            width: 80px;
        }
        .laytable-cell-5-0-4 {}
        .laytable-cell-5-0-5 {
            width: 80px;
        }
        </style>
    </div>
</div>

<script>
    $('#search').click(function(){
        var keyword = $(" input[ name='keyword' ]").val();
        location.href = "<?php echo url('index'); ?>?keyword="+keyword;
    });

    //弹出一个页面层
    // $('.details').on('click', function(){
    //     var layer,
    //         id = $(this).attr('value');
    //     layui.use('layer',function () {
    //         layer = layui.layer;
    //         layer.open({
    //           type: 2,
    //           title:'详情',
    //           content: 'details?id='+id,
    //           area: ['400px', '650px'],
    //           anim: 1,
    //           resize :false
    //         }); 
    //     })
    // });

    // 删除文件已经文件所有数据
    $('.delete').on('click', function(){
    var layer,
        id = $(this).attr('value');
        layui.use('layer',function () {
            layer = layui.layer;
            layer.confirm('该操作会删除该文件以及该文件所有数据<br>是否确认?', {icon: 3, title:'提示'}, function(index){
                if (index>0) {
                    $.ajax({
                        type: "POST",
                        url: "delete",
                        data: {
                            id:id
                        },
                        beforeSend:function(){
                            layui.use('layer',function () {
                                index = layer.load();
                            })
                        },
                        success: function(msg){
                            if (msg.status==1) {
                                layer.msg(msg.msg,{time:1000});
                                setTimeout(function(){
                                    location.reload();
                                },500);
                            }
                        }
                    });
                }
                layer.close(index);
            });
        })
    })
</script>

        </div>
      </div>
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © 云小薪
  </div>
</div>

<script>
    //JavaScript代码区域
    layui.use('element', function(){
      var element = layui.element;
    });
    function cacheClear() {
        var index =layer.load(1)
        $.post("<?php echo url('admin/system/cacheClear'); ?>",function (res) {
            layer.close(index);
            layer.alert(res.msg);
        })
    }
</script>
</html>