<?php /*a:2:{s:65:"E:\xampp\htdocs\rhaphp\themes/pc/extension/gongzicha\preview.html";i:1587522449;s:68:"E:\xampp\htdocs\rhaphp\themes/pc/extension/..\admin\common\base.html";i:1587441020;}*/ ?>
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
            <dd class="<?php if($c['shows'] == '1'): ?>layui-this<?php endif; ?>"><a href="<?php echo url($c['url']); ?>"><?php echo htmlentities($c['name']); ?></a></dd>
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
        <div class="layui-inline">工资单名称：</div>
        <div class="layui-inline">
            <input class="layui-input" name="excel_name" value="" placeholder="例如:圣源复1月工资">
        </div>

    </div>
    <div class="layui-form layui-border-box"  style="width:100%;  overflow:scroll;">
        <table cellspacing="0" cellpadding="0" border="0" class="layui-table">
            <thead>
                <tr>
                    <?php if(is_array($content) || $content instanceof \think\Collection || $content instanceof \think\Paginator): if( count($content)==0 ) : echo "" ;else: foreach($content as $title=>$t): ?>
                        <th>
                            <div class="" ><span><?php echo htmlentities($title); ?></span></div>
                        </th>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </tr>
            <tbody>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr data-index="0">
                        <?php if(is_array($vo) || $vo instanceof \think\Collection || $vo instanceof \think\Paginator): if( count($vo)==0 ) : echo "" ;else: foreach($vo as $key=>$volist): ?>
                            <td data-field="id" data-key="1-0-0" class="">
                                <div class="layui-table-cell laytable-cell-1-0-0"><?php echo htmlentities($volist); ?></div>
                            </td>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            </thead>
        </table>
    </div>
    <div class="note">备注：为防止误操作，实例将展示上传工资表格的前10行数据</div>
    <div class="preview_button">
        <button type="button" class="layui-btn layui-btn-danger" id="cancel" >取消</button>
        <button type="button" class="layui-btn layui-btn-normal" id="generate">生成工资单</button>
    </div>
</div>
<script>    
    // 取消
    $('#cancel').click(function(){
        $.get("<?php echo url('cancel'); ?>?excel_id="+<?php echo htmlentities($excel_id); ?>, function(msg){
            if (msg.status == '1') {
                location.href = "<?php echo url('index'); ?>";
            }
        });
    })


    $('#generate').click(function(){
        var excel_name = $("input[name='excel_name' ] ").val();
        if (!excel_name) {
            layui.use('layer',function () {
                layer = layui.layer;
                layer.msg('请输入工资单名称！', {time: 1500}); 
            })
            return;
        }
        var index;
        $.ajax({
            type: "GET",
            url: "<?php echo url('generate'); ?>",
            data: {
                excel_id:<?php echo htmlentities($excel_id); ?>,
                excel_name:excel_name
            },
            beforeSend:function(){
                layui.use('layer',function () {
                    index = layer.load();
                })
            },
            success: function(msg){
                if (msg.status == 0) {
                    layer.msg(msg.msg,{time:1000});
                    layer.close(index);
                }else{
                    layer.msg(msg.msg,{time:800});
                    location.href = "<?php echo url('index'); ?>";
                    layer.close(index);
                }
            }
        });

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