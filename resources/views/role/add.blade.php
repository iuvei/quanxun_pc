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
    <title>修改权限 - 角色管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>

<style>
    .select_radio {
        margin: 20px auto;
    }
    .c_info {
        margin-left: 50px;
    }
    .z_info {
        margin-left: 100px;
    }
    .zz_info {
        margin-left: 20px;
    }
</style>

<article class="page-container">
    <form method="post" action="/role_add" enctype="multipart/form-data" class="form form-horizontal" id="form-domain-add">
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                角色名: <input type="text" name="" id="r_name" value="" style="width:200px" class="input-text">
                <div class="select_radio">
                    @foreach($power_info as $value)
                        <div class="list_one">
                            <div class="top"><input type="checkbox" name="p_id" class="top_checkbox" value="{{ $value['p_id'] }}">{{ $value['p_name'] }}----------</div>
                            @foreach($value['c_info'] as $val)
                                <div class="c_info"><input type="checkbox" name="p_id" class="c_info_checkbox" value="{{ $val['p_id'] }}">{{ $val['p_name'] }}----------</div>
                                <div class="z_info">
                                    @foreach($val['z_info'] as $z_val)
                                        <input class="zz_info" name="p_id" type="checkbox" value="{{ $z_val['p_id'] }}">{{ $z_val['p_name'] }}
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button class="btn btn-primary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
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
        // 点击第一级  选中第一级下面的第二级和第三级
        $('.top_checkbox').click(function(){
            var index = $(this).index('.top_checkbox');
            if($('.top_checkbox').eq(index).is(':checked')){
                $('.list_one').eq(index).find('input').prop("checked", "checked");
            }else{
                $('.list_one').eq(index).find('input').removeAttr("checked");
            }
        });

        // 点击第二级  选中第二级下面的第三级
        $('.c_info_checkbox').click(function(){
            if($(this).is(":checked")){
                $(this).parent().next().find('input').prop("checked", "checked");
            }else{
                $(this).parent().next().find('input').removeAttr("checked");
            }
            $(this).parent().parent().find('.top_checkbox').prop("checked", "checked");
        });

        // 选中所有第三级 选中第三级所对应的第二级
        $('.zz_info').click(function(){
            $(this).parent().prev().find('input').prop("checked", "checked");
        });

        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $('.btn-primary').click(function(){
            var ids = '';
            $("input[name='p_id']:checkbox").each(function(){
                if (true == $(this).prop("checked")) {
                    ids += $(this).prop('value')+',';
                }
            });
            ids = ids.substr(0,ids.length-1);
            var r_name = $('#r_name').val();
            var url = '/role_add';
            var data = {'r_name':r_name, 'p_id':ids};
            $.post(url, data, function(xhr){
                layer.open({
                    content: xhr.msg_info
                    ,btn: ['好的']
                    ,yes: function(index, layero){
                        layer.close(index);
                    }
                });
            });
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>