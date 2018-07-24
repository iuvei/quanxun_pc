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
    <form method="post" action="/newsinformation_edit" enctype="multipart/form-data" class="form form-horizontal" id="form-article-edit">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>资讯标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{ $newsinformation_info->n_title }}" placeholder="" id="articletitle" name="newstitle">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>资讯类型：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
                <select name="newstype" id="newstype" class="select">
                    @foreach($newsinformation_type as $val)
                        <option value="{{ $val->nt_type }}" <?php if($val->nt_type == $newsinformation_info->nt_type){ echo "selected=selected"; } ?>>{{ $val->nt_type }}</option>
                    @endforeach
                </select>
                </span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>资讯项目：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="newspattern" id="newspattern" class="select">   
                    @foreach($newsinformation_pattern as $val)
                        <option value="{{ $val->nt_pattern }}" <?php if($val->nt_pattern == $newsinformation_info->nt_pattern){ echo "selected=selected"; } ?>>{{ $val->nt_pattern }}</option>
                    @endforeach
                </select>
				</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">资讯摘要：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="abstract" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="$.Huitextarealength(this,200)">{{ $newsinformation_info->n_introduction }}</textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">资讯来源：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="news_company" class="select">
                    <option value="0">全部公司</option>
                    @foreach($company_type as $value)
                        <option value="{{ $value->c_id }}" <?php if($value->c_id == $newsinformation_info->n_company_id){ echo "selected=selected"; } ?>>{{ $value->c_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">是否发布：</label>
            <div class="formControls col-xs-8 col-sm-9">
                是 <input type="radio" name="is_release" value="1" <?php if($newsinformation_info->n_status == 1){ echo 'checked="checked"'; } ?>>
                否 <input type="radio" name="is_release" value="0" <?php if($newsinformation_info->n_status == 0){ echo 'checked="checked"'; } ?>>
            </div>
        </div>
        {{--<div class="row cl">--}}
            {{--<label class="form-label col-xs-4 col-sm-2">资讯开始日期：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
                {{--<input type="text" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'commentdatemax\')||\'%y-%M-%d\'}' })" value="{{ $newsinformation_info->n_starttime }}" id="commentdatemin" name="commentdatemin" class="input-text Wdate">--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row cl">--}}
            {{--<label class="form-label col-xs-4 col-sm-2">资讯结束日期：</label>--}}
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
                {{--<input type="text" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'commentdatemin\')}' })" value="{{ $newsinformation_info->n_endtime }}" id="commentdatemax" name="commentdatemax" class="input-text Wdate">--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">资讯图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" name="news_file" id="news_file">
            </div>
        </div>
        <div class="row cl" style="display: none">
            <textarea name="contents" id="contents" cols="30" rows="10"></textarea>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">资讯内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <script id="editor" type="text/plain" style="width:100%;height:400px;"></script>
            </div>
        </div>
        <input type='button' value='编辑' id='setContent' style="display:none">
        <input type='hidden' name='id' value='{{ $newsinformation_info->n_id }}'>
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

        setTimeout(function(){
            $( "#setContent" ).trigger( "click" );
        },1000)

        $('#setContent').click(function(){
            UE.getEditor('editor').setContent('<?php echo $newsinformation_info->n_content_info;  ?>');
        });

        $('#news_file').change(function(){
            var img_id=document.getElementById('news_file').value; //根据id得到值
            var index= img_id.indexOf("."); //得到"."在第几位
            img_id=img_id.substring(index); //截断"."之前的，得到后缀
            if(img_id!=".bmp"&&img_id!=".png"&&img_id!=".gif"&&img_id!=".jpg"&&img_id!=".jpeg"){  //根据后缀，判断是否符合图片格式
                layer.confirm("不是指定图片格式,重新选择！", {
                    btn: ['好的'] //可以无限个按钮
                    ,yes: function(index, layero){
                        layer.close(index);
                        document.getElementById('news_file').value="";  // 不符合，就清除，重新选择
                    }
                });
            }
        });

        //表单验证
        $("#form-article-edit").validate({
            rules:{},
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                content = UE.getEditor('editor').getContent();
                $('#contents').text(content);
                $(form).submit();                
            }
        });

        $list = $("#fileList"),
            $btn = $("#btn-star"),
            state = "pending",
            uploader;

        var uploader = WebUploader.create({
            auto: true,
            swf: 'lib/webuploader/0.1.5/Uploader.swf',

            // 文件接收服务端。
            server: 'fileupload.php',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        uploader.on( 'fileQueued', function( file ) {
            var $li = $(
                '<div id="' + file.id + '" class="item">' +
                '<div class="pic-box"><img></div>'+
                '<div class="info">' + file.name + '</div>' +
                '<p class="state">等待上传...</p>'+
                '</div>'
                ),
                $img = $li.find('img');
            $list.append( $li );

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                $percent = $li.find('.progress-box .sr-only');

            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo( $li ).find('.sr-only');
            }
            $li.find(".state").text("上传中");
            $percent.css( 'width', percentage * 100 + '%' );
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file ) {
            $( '#'+file.id ).addClass('upload-state-success').find(".state").text("已上传");
        });

        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            $( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress-box').fadeOut();
        });
        uploader.on('all', function (type) {
            if (type === 'startUpload') {
                state = 'uploading';
            } else if (type === 'stopUpload') {
                state = 'paused';
            } else if (type === 'uploadFinished') {
                state = 'done';
            }

            if (state === 'uploading') {
                $btn.text('暂停上传');
            } else {
                $btn.text('开始上传');
            }
        });

        $btn.on('click', function () {
            if (state === 'uploading') {
                uploader.stop();
            } else {
                uploader.upload();
            }
        });

        var ue = UE.getEditor('editor');

    });
    /*二级下拉菜单*/
    $('#newstype').change(function() {  
        var newstype = $('#newstype').val();
        var url = '/newsinformation_add';
        var data = {'newstype':newstype};
        $.get(url, data, function(xhr){
            var obj = eval(xhr);
            if(obj.value == 0) {
                return false;  
            }  
            newspattern = $("#newspattern");
            $("option",newspattern).remove();
            $.each(obj, function(i, pattern) {  
                $("#newspattern").append("<option value='" + pattern.nt_pattern + "'>" + pattern.nt_pattern + "</option>");  
            });  
            // $("#newspattern").append("<option id='auto_time'>自定义</option>");  
        });        
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>