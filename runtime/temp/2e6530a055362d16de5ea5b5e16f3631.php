<?php /*a:2:{s:57:"E:\xampp\htdocs\rhaphp\themes/pc/mp/gongzicha\import.html";i:1587375576;s:61:"E:\xampp\htdocs\rhaphp\themes/pc/mp/..\admin\common\base.html";i:1587429650;}*/ ?>
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
            
<style>
  .margin{
    margin: 30px 0;
  }
  .file_input{

  }
  .file {
      display: none;
  }

  .margin_left{
    margin-left: 30px;
  }
</style>
<body>
  <form id="uploadForm" enctype="multipart/form-data">
      <div class="margin_left">
        <input type="text" name="file_name"  placeholder="请输入标题" autocomplete="off" class="layui-input" style="width: 300px">
        <button type="button" class="layui-btn margin" id="test1">
          <i class="layui-icon">&#xe67c;</i>上传文件
        </button>
      </div>
  </form>
  <div class="margin_left">
    <button class="layui-btn" id="upload">立即提交</button>
  </div>

</body>
</html>
<script>  
  layui.use('upload', function(){
    var upload = layui.upload;
    //执行实例
    var uploadInst = upload.render({
      elem: '#test1' //绑定元素
      ,auto: false //是否自动上传
      ,accept:'file'
    });
  });

  $(function () {
      $("#upload").click(function () {
          var formData = new FormData($('#uploadForm')[0]);
          var index;
          $.ajax({
              type: 'POST',
              url: "<?php echo url('addExcel'); ?>",
              data: formData,
              cache: false,
              processData: false,
              contentType: false,
                beforeSend:function(XMLHttpRequest){
                  index = layer.load();
                }, 

          }).success(function (data) {
            
            layer.alert(data,{
              area: ['400px', '300px'],
              cancel: function(index, layero){ 
                location.reload();
              }
            },function(index){
              location.reload();
              layer.close(index);
            });
          }).error(function () {  
              alert("上传失败");
              layer.close(index);
          });

      });
  });

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