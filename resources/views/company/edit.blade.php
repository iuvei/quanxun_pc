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
    <form method="post" action="/company_edit" enctype="multipart/form-data" class="form form-horizontal" id="form-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>公司名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $company_info->c_name }}" placeholder="" name="c_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>公司类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                @foreach($company_type as $val)
                    @if(strstr((string)$company_info->c_type_id, (string)$val->ct_id))
                        <input type="checkbox" value="{{ $val->ct_id }}" name="c_type_id[]" <?php echo "checked=checked" ?>> {{ $val->ct_type }}&nbsp;&nbsp;&nbsp;&nbsp;
                    @else
                        <input type="checkbox" value="{{ $val->ct_id }}" name="c_type_id[]"> {{ $val->ct_type }}&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                @endforeach
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>公司简介：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="c_introduction" cols="" rows="" class="textarea valid" id="textarea" placeholder="说点什么..." datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！">{{ $company_info->c_introduction }}</textarea>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>运营模式：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $company_info->c_business_type }}" placeholder="" id="domain_url" name="c_business_type">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>运营人数：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $company_info->c_operatings }}" placeholder="" id="domain_url" name="c_operatings">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>牌照类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $company_info->c_license_type }}" placeholder="" id="domain_url" name="c_license_type">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>成立时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" value="{{ $company_info->c_foundationtime }}" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd',maxDate:'' })" id="commentdatemin" name="c_foundationtime" class="input-text Wdate">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>评分：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" value="{{ $company_info->c_scores }}" class="input-text" value="" placeholder="" id="domain_url" name="c_scores">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>公司Logo(163x92)：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" name="c_image163x92"> 当前：<img src="{{ URL::asset( $company_info->c_image163x92 ) }}" modal="zoomImg" width="100px" height="70px" id="img"/>
            </div>
        </div>
        <input type="hidden" value="{{ $company_info->c_id }}" name="id">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>反水：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $company_info->c_returns }}" placeholder="" id="domain_url" name="c_returns">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否认证：</label>
            <div class="formControls col-xs-8 col-sm-9">
                是 <input type="radio" name="c_certified" value="1" <?php if($company_info->c_certified == 1){ echo "checked=checked"; } ?>>
                否 <input type="radio" name="c_certified" value="0" <?php if($company_info->c_certified == 0){ echo "checked=checked"; } ?>>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
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

        $('#c_image163x92').change(function(){
            var img_id=document.getElementById('c_image163x92').value; //根据id得到值
            var index= img_id.indexOf("."); //得到"."在第几位
            img_id=img_id.substring(index); //截断"."之前的，得到后缀
            if(img_id!=".bmp"&&img_id!=".png"&&img_id!=".gif"&&img_id!=".jpg"&&img_id!=".jpeg"){  //根据后缀，判断是否符合图片格式
                layer.confirm("不是指定图片格式,重新选择！", {
                    btn: ['好的'] //可以无限个按钮
                    ,yes: function(index, layero){
                        layer.close(index);
                        document.getElementById('c_image163x92').value="";  // 不符合，就清除，重新选择
                    }
                });
            }
        });

        //表单验证
        $("#form-add").validate({
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
                $(form).submit();
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>