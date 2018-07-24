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
    <title>修改推荐活动</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>

<article class="page-container">
    <form method="post" action="/recommend_edit" enctype="multipart/form-data" class="form form-horizontal" id="form-add">
        <input type="hidden" name="id" value="{{ $recommend_info->r_id }}">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $recommend_info->r_title }}" placeholder="" id="r_title" name="r_title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动图片（600*360）：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" name="r_img" id="r_img">当前：<img src="{{ URL::asset( $recommend_info->r_img ) }}" modal="zoomImg" width="100px" height="70px" id="img"/>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属公司：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="c_id" id="c_id" class="select">
                    @foreach($company as $val)
                        <option value="{{ $val->c_id }}">{{ $val->c_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动开始时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" value="{{ $recommend_info->r_start_time }}" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'' })" id="commentdatemin" name="commentdatemin" class="input-text Wdate">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动结束时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" value="{{ $recommend_info->r_end_time }}" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'commentdatemin\')}' })" id="commentdatemax" name="commentdatemax" class="input-text Wdate">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否发布：</label>
            <div class="formControls col-xs-8 col-sm-9">
                是：<input type="radio" value="1" name="is_show" class="is_show" <?php if($recommend_info->r_is_show == 1){ echo "checked='checked'"; } ?>>
                否：<input type="radio" value="0" name="is_show" class="is_show" <?php if($recommend_info->r_is_show == 0){ echo "checked='checked'"; } ?>>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动链接/活动内容：</label>
            <div class="formControls col-xs-8 col-sm-9"><span class="isshow_url">添加链接：<input type="checkbox" id="cli_url"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="isshow_content">添加内容：<input type="checkbox" id="cli_content"></span><br><span class="show_url" style="display:none"><input type="text" value="{{ $recommend_info->r_url }}" id="r_url_input" class="input-text" placeholder="" name="r_url"></span><span class="show_content" style="display: none"><script id="editor" type="text/plain" style="width:100%;height:400px;"></script></span><span id="alert_info" style="color:red"></span></div>
        </div>
        <div class="row cl" style="display: none">
            <textarea name="contents" id="contents" cols="30" rows="10"></textarea>
        </div>
        <input type='button' value='编辑' id='setContent' style="display:none">
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
        $('#r_url_input').blur(function(){
            var url = $('#r_url_input').val();
            if(url != '') {
                if ((!url.indexOf("http://") || !url.indexOf("https://"))) {
                    $('#alert_info').text('');
                } else {
                    $('#alert_info').text('域名不合法，必须需要加 http:// 或者 https:// 前缀');
                }
            }
        });

        $('#r_img').change(function(){
            var img_id=document.getElementById('r_img').value; //根据id得到值
            var index= img_id.indexOf("."); //得到"."在第几位
            img_id=img_id.substring(index); //截断"."之前的，得到后缀
            if(img_id!=".bmp"&&img_id!=".png"&&img_id!=".gif"&&img_id!=".jpg"&&img_id!=".jpeg"){  //根据后缀，判断是否符合图片格式
                layer.confirm("不是指定图片格式,重新选择！", {
                    btn: ['好的'] //可以无限个按钮
                    ,yes: function(index, layero){
                        layer.close(index);
                        document.getElementById('r_img').value="";  // 不符合，就清除，重新选择
                    }
                });
            }
        });

        var r_url = $('#r_url_input').val();
        var r_content = "<?php echo $recommend_info->r_content; ?>";
        if(r_url != ''){
            $('.show_url').show();
            $("#cli_url").attr("checked",true);
        }else if(r_content != ''){
            $('.show_content').show();
            $("#cli_content").attr("checked",true);
        }

        $('#cli_url').click(function(){
            if($("#cli_content").is(":checked")){
                layer.alert('链接和内容只可选其一！');
                $("#cli_url").attr("checked",false);
                return ;
            }
            if($("#cli_url").is(":checked")){
                $('#r_url_input').val('');
                $('.show_url').show();
            }else{
                $('.show_url').hide();
                $('#r_url_input').val('');
                $('#alert_info').text('');
            }
        });
        $('#cli_content').click(function(){
            if($("#cli_url").is(":checked")){
                layer.alert('链接和内容只可选其一！');
                $("#cli_content").attr("checked",false);
                return ;
            }
            if($("#cli_content").is(":checked")) {
                $('.show_content').show();
            }else{
                $('.show_content').hide();
                UE.getEditor('editor').setContent('');
            }
        });

        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        setTimeout(function(){
            $( "#setContent" ).trigger( "click" );
        },2000);

        $('#setContent').click(function(){
            UE.getEditor('editor').setContent('<?php echo $recommend_info->r_content;  ?>');
        });

        var ue = UE.getEditor('editor');

        //表单验证
        $("#form-add").validate({
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var url = $('#r_url_input').val();
                if(url != ''){
                    if((!url.indexOf("http://") || !url.indexOf("https://"))){
                        $('#alert_info').text('');
                    }else {
                        $('#alert_info').text('域名不合法，必须需要加 http:// 或者 https:// 前缀');
                        return ;
                    }
                }
                var content = UE.getEditor('editor').getContent();
                $('#contents').text(content);
                $(form).submit();
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>