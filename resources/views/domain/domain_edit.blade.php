<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/html5shiv.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/respond.min.js') }}"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui/css/H-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/css/H-ui.admin.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/lib/Hui-iconfont/1.0.8/iconfont.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/skin/default/skin.css') }}" id="skin" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/css/style.css') }}" />
    <!--[if IE 6]>
    <script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/DD_belatedPNG_0.0.8a-min.js') }}" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>新增文章 - 资讯管理 - H-ui.admin v3.1</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>

<article class="page-container">
    <form method="post" action="/domain_edit" enctype="multipart/form-data" class="form form-horizontal" id="form-domain-edit">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>域名链接：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $domain_info->d_url }}" placeholder="" id="domain_url" name="domain_url">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>权重：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="domainsort" class="select">
                    <option value="1" <?php if($domain_info->d_weight == 1){ echo "selected=selected"; } ?>>1</option>
                    <option value="2" <?php if($domain_info->d_weight == 2){ echo "selected=selected"; } ?>>2</option>
                    <option value="3" <?php if($domain_info->d_weight == 3){ echo "selected=selected"; } ?>>3</option>
                    <option value="4" <?php if($domain_info->d_weight == 4){ echo "selected=selected"; } ?>>4</option>
                    <option value="5" <?php if($domain_info->d_weight == 5){ echo "selected=selected"; } ?>>5</option>
                    <option value="6" <?php if($domain_info->d_weight == 6){ echo "selected=selected"; } ?>>6</option>
                    <option value="7" <?php if($domain_info->d_weight == 7){ echo "selected=selected"; } ?>>7</option>
                    <option value="8" <?php if($domain_info->d_weight == 8){ echo "selected=selected"; } ?>>8</option>
                    <option value="9" <?php if($domain_info->d_weight == 9){ echo "selected=selected"; } ?>>9</option>
                    <option value="10" <?php if($domain_info->d_weight == 10){ echo "selected=selected"; } ?>>10</option>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属公司：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="domain_company" class="select">
                    <option value="0">全部公司</option>
                    @foreach($company as $value)
                        <option value="{{ $value->c_id }}" <?php if($domain_info->d_company_id == $value->c_id){ echo "selected=selected"; } ?>>{{ $value->c_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" value="{{ $domain_info->d_id }}" name="id">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否设置为主域名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                是 <input type="radio" name="is_default" value="1" <?php if($domain_info->d_default == 1){ echo "checked=checked"; } ?>>
                否 <input type="radio" name="is_default" value="0" <?php if($domain_info->d_default == 0){ echo "checked=checked"; } ?>>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 修改并提交</button>
                <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</article>

<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/jquery/1.9.1/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.page.js') }}"></script>

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/My97DatePicker/4.8/WdatePicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/webuploader/0.1.5/webuploader.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/ueditor/1.4.3/ueditor.config.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/ueditor/1.4.3/ueditor.all.min.js') }}"> </script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        //表单验证
        $("#form-domain-edit").validate({
            rules:{
                domain_url:{
                    required:true,
                },
                domainsort:{
                    required:true,
                },
                domain_company:{
                    required:true,
                },
                is_default:{
                    required:true,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var url = '/domain_edit';
                var data = $("#form-domain-edit").serialize();
                $.post(url, data, function(xhr){
                    layer.open({
                        content: xhr.res_desc
                        ,btn: ['是的', '算了']
                        ,yes: function(index, layero){
                            parent.$( "#btn-success" ).trigger( "click" );
                            layer.close(index); //如果设定了yes回调，需进行手工关闭
                            parent.$(".layui-layer-shade").remove();
                            parent.$(".layui-layer-iframe").remove();
                        }
                    });
                });
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>