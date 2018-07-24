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
    <script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/jquery/1.9.1/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/laydate/laydate.js') }}" ></script>
    <!--[if IE 6]>
    <script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/DD_belatedPNG_0.0.8a-min.js') }}" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>新增文章 - 资讯管理 - H-ui.admin v3.1</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>

@if (Session::has('status'))
    <script type="text/javascript">
        $(function(){
            layer.alert("{{ Session::get('status') }}", {icon: 1});
        });
    </script>
@endif

<article class="page-container">
    <form method="post" action="/match_add" enctype="multipart/form-data" class="form form-horizontal" id="form-match-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">联赛名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="articletitle" name="m_title">
                </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">开盘时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="m_status_time" name="m_status_time">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">上盘球队：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="articletitle" name="m_home_team">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">盘口：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="articletitle" name="m_change">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">下盘球队：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="articletitle" name="m_visiting_team">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">免费推荐：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="articletitle" name="m_recommend">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">比分：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="articletitle" name="m_score">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">结果：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="articletitle" name="m_result">
            </div>
        </div>
        <input type="hidden" name="m_sort" value="{{ $match_info_count + 1 }}">
        <div class="row cl">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
            <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
            <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
        </div>
        </div>
    </form>
</article>

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
    laydate.render({
        elem: '#m_status_time',
        type: 'datetime'
    });
    //表单验证
    $("#form-match-add").validate({
        rules:{
            m_title:{
                required:true,
            },
            m_status_time:{
                required:true,
            },
            m_home_team:{
                required:true,
            },
            m_change:{
                required:true,
            },
            m_visiting_team:{
                required:true,
            },
            m_recommend:{
                required:true,
            },
            m_score:{
                required:true,
            },
            m_result:{
                required:true,
            }
        },
        onkeyup:false,
        focusCleanup:true,
        success:"valid",
        submitHandler:function(form){
            $(form).submit();
        }
    });
</script>
</body>
</html>