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
    <form method="post" action="/activity_add" enctype="multipart/form-data" class="form form-horizontal" id="form-article-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="articletitle" name="activitytitle">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动类型：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="select-box">
                    <select name="activitytype" class="select">
                        <option value="0">全部类型</option>
                        @foreach($activity_type as $val)
                            <option value="{{ $val->at_id }}">{{ $val->at_type }}</option>
                        @endforeach
                    </select>
				</span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动摘要：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="abstract" cols="" rows="" class="textarea" id="textarea" placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！"></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/60</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动来源：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="activity_company" class="select">
                    <option value="0">全部公司</option>
                    @foreach($activity_company as $value)
                        <option value="{{ $value->c_id }}">{{ $value->c_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>是否发布：</label>
            <div class="formControls col-xs-8 col-sm-9">
                是 <input type="radio" name="is_release" value="1">&nbsp;&nbsp;&nbsp;&nbsp;
                否 <input type="radio" name="is_release" value="0">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动开始日期：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'' })" id="commentdatemin" name="commentdatemin" class="input-text Wdate">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动结束日期：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'commentdatemin\')}' })" id="commentdatemax" name="commentdatemax" class="input-text Wdate">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动图片（240*130）：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" name="activity_file[]" id="activity_file_one">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">活动图片（700*n）：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" name="activity_file[]" id="activity_file_two">
            </div>
        </div>
        <div class="row cl" style="display: none">
            <textarea name="contents" id="contents" cols="30" rows="10"></textarea>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动内容：</label>
            <div class="formControls col-xs-8 col-sm-9"> <script id="editor" type="text/plain" style="width:100%;height:400px;"></script></div>
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

        $('#activity_file_one').change(function(){
            var img_id=document.getElementById('activity_file_one').value; //根据id得到值
            var index= img_id.indexOf("."); //得到"."在第几位
            img_id=img_id.substring(index); //截断"."之前的，得到后缀
            if(img_id!=".bmp"&&img_id!=".png"&&img_id!=".gif"&&img_id!=".jpg"&&img_id!=".jpeg"){  //根据后缀，判断是否符合图片格式
                layer.confirm("不是指定图片格式,重新选择！", {
                    btn: ['好的'] //可以无限个按钮
                    ,yes: function(index, layero){
                        layer.close(index);
                        document.getElementById('activity_file_one').value="";  // 不符合，就清除，重新选择
                    }
                });
            }
        });
        $('#activity_file_two').change(function(){
            var img_id=document.getElementById('activity_file_two').value; //根据id得到值
            var index= img_id.indexOf("."); //得到"."在第几位
            img_id=img_id.substring(index); //截断"."之前的，得到后缀
            if(img_id!=".bmp"&&img_id!=".png"&&img_id!=".gif"&&img_id!=".jpg"&&img_id!=".jpeg"){  //根据后缀，判断是否符合图片格式
                layer.confirm("不是指定图片格式,重新选择！", {
                    btn: ['好的'] //可以无限个按钮
                    ,yes: function(index, layero){
                        layer.close(index);
                        document.getElementById('activity_file_two').value="";  // 不符合，就清除，重新选择
                    }
                });
            }
        });

        //表单验证
        $("#form-article-add").validate({
            rules:{
                activitytitle:{
                    required:true,
                },
                activitytype:{
                    required:true,
                },
                activity_company:{
                    required:true,
                },
                commentdatemin:{
                    required:true,
                },
                commentdatemax:{
                    required:true,
                },
                activity_file_one:{
                    required:true,
                },
                a_type:{
                    required:true,
                },
                abstract:{
                    required:true,
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var content = UE.getEditor('editor').getContent();
                $('#contents').text(content);
                $(form).submit()
            }
        });

        var ue = UE.getEditor('editor');
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>