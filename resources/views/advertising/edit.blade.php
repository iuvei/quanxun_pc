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
    <title>新增广告 - 广告管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
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
    <form method="post" action="/advertising_edit" enctype="multipart/form-data" class="form form-horizontal" id="form-advertising-edit">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>广告链接：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $advertising_info->ad_url }}" placeholder="" id="advertising_url" name="advertising_url">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>广告来源：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="advertising_company" class="select">
                    <option value="0">全部公司</option>
                    @foreach($company as $value)
                        <option value="{{ $value->c_id }}" <?php if($advertising_info->ad_company_id == $value->c_id){ echo "selected==selected"; } ?>>{{ $value->c_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否发布：</label>
            <div class="formControls col-xs-8 col-sm-9">
                是 <input type="radio" name="is_release" value="1" <?php if($advertising_info->ad_status == 1){ echo "checked==checked"; } ?>>
                否 <input type="radio" name="is_release" value="0" <?php if($advertising_info->ad_status == 0){ echo "checked==checked"; } ?>>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>广告开始日期：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" value="{{ $advertising_info->ad_starttime }}" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss' })" id="commentdatemin" name="commentdatemin" class="input-text Wdate">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>广告结束日期：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" value="{{ $advertising_info->ad_endtime }}" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'commentdatemin\')}' })" id="commentdatemax" name="commentdatemax" class="input-text Wdate">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>广告图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" name="advertising_file" id="advertising_file"> 当前：<img src="{{ URL::asset( $advertising_info->ad_image479x70 ) }}" modal="zoomImg" width="350px" height="50px" id="img"/>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">权重：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="weigth" id="" class="select">
                    <?php for ($i=1; $i<11; $i++){ ?>
                    <option value="{{ $i }}" <?php if($advertising_info->ad_weight == $i){ echo "selected==selected"; } ?>>{{ $i }}</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <input type="hidden" value="{{ $advertising_info->ad_id }}" name="id">
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

        $('#advertising_file').change(function(){
            var img_id=document.getElementById('advertising_file').value; //根据id得到值
            var index= img_id.indexOf("."); //得到"."在第几位
            img_id=img_id.substring(index); //截断"."之前的，得到后缀
            if(img_id!=".bmp"&&img_id!=".png"&&img_id!=".gif"&&img_id!=".jpg"&&img_id!=".jpeg"){  //根据后缀，判断是否符合图片格式
                layer.confirm("不是指定图片格式,重新选择！", {
                    btn: ['好的'] //可以无限个按钮
                    ,yes: function(index, layero){
                        layer.close(index);
                        document.getElementById('advertising_file').value="";  // 不符合，就清除，重新选择
                    }
                });
            }
        });

        //表单验证
        $("#form-advertising-edit").validate({
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).submit();
                // var url = '/advertising_edit';
                // var data = $("#form-advertising-edit").serialize();
                // $.post(url, data, function(xhr){
                //     console.log(xhr);
                //     return ;
                //     layer.open({
                //         content: xhr.res_desc
                //         ,btn: ['是的', '算了']
                //         ,yes: function(index, layero){
                //             parent.$( "#btn-success" ).trigger( "click" );
                //             layer.close(index); //如果设定了yes回调，需进行手工关闭
                //             parent.$(".layui-layer-shade").remove();
                //             parent.$(".layui-layer-iframe").remove();
                //         }
                //     });
                // });
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>