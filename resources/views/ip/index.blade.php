<!--_meta 作为公共模版分离出去-->
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
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui/css/H-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/css/H-ui.admin.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/lib/Hui-iconfont/1.0.8/iconfont.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/skin/default/skin.css') }}" id="skin" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/Huiadmin/static/h-ui.admin/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/page.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/boxImg.css') }}">
    <script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/jquery/1.9.1/jquery.min.js') }}"></script>
    <!--[if IE 6]>
    <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <!--/meta 作为公共模版分离出去-->

    <title>新增 - 活动管理 - H-ui.admin v3.1</title>
    <meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>

@if (Session::has('edit_status'))
    <script type="text/javascript">
        $(function(){
            layer.alert("{{ Session::get('edit_status') }}", {icon: 1});
        });
    </script>
@endif

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> ip管理 <span class="c-gray en">&gt;</span> ip列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <input type="text" name="" id="ip_name" value="{{ $ip_name }}" placeholder=" ip" style="width:250px" class="input-text">
        <button name="" id="btn-search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜ip</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" id="ip_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" data-title="添加活动" data-href="/ip_add" id="ip_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加ip</a>
        </span>
        <span class="r">共有数据：<strong>{{ $ip_count }}</strong>条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="80">描述</th>
                <th width="80">ip</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-c" id="add_ip">
                <td><input type="checkbox"></td>
                <td>*</td>
                <td><input type="text" id="i_info"></td>
                <td><input type="text" id="i_ip" maxlength="15"></td>
                <td>
                    <a href="javascript:void(0)" id="add_ip_info">添加ip</a>&nbsp;&nbsp;
                    <a href="javascript:void(0)" id="reset_id">取消</a>
                </td>
            </tr>
            @forelse ($ip_info as $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{ $val->i_id }}" class="ckb"></td>
                    <td>{{ $val->i_id }}</td>
                    <td>{{ $val->i_info }}</td>
                    <td>{{ $val->i_ip }}</td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" class="ml-5 ip_edit" data-id="{{ $val->i_id }}" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5 ip_del" data-id="{{ $val->i_id }}" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            @empty
                <tr class="text-c">
                    <td colspan="20">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $ip_info->appends(request()->all())->links() }}
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('/js/boxImg.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.page.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $('#add_ip').hide();
        /*ip-添加*/
        $('#ip_add').bind("click", function(){
            $('#add_ip').show();
        });
        $('#add_ip_info').bind("click", function(){
            var ip = $('#i_ip').val();
            var info = $('#i_info').val();
            var url = '/ip_add';
            var data = {'i_ip':ip, 'i_info':info};
            $.post(url, data, function(xhr){
                layer.confirm(xhr.res_desc, {
                    btn: ['好的'] //可以无限个按钮
                    ,yes: function(index, layero){
                        window.location.reload();
                    }
                });
            })
        });

        /*ip-取消添加*/
        $('#reset_id').bind("click", function(){
            $('#i_ip').val('');
            $('#add_ip').hide();
        })

        /*ip-多条删除*/
        $('#ip_delall').bind("click",function(){
            var ids = '';
            $(".ckb").each(function () {
                if ($(this).is(':checked')) {
                    ids += ',' + $(this).val(); //逐个获取id
                }
            });
            var ids = ids.substring(1);
            var url = '/ip_del';
            var data = {'id':ids};
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    $.post(url, data, function(xhr){
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.reload();
                            }
                        });
                    });
                }
            });
        });

        /*ip-删除*/
        $(document).on('click', '.ip_del', function(){
            var id = $(this).attr('data-id');
            var url = '/ip_del';
            var data = {'id':id};
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    $.post(url, data, function(xhr){
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.reload();
                            }
                        });
                    });
                }
            });
        });

        /*ip-修改*/
        $(document).on('click', '.ip_edit', function(){
            var id = $(this).attr('data-id');
            var ip = $(this).parent().prev().text();
            var input_info = "<input type='text' name='ipt_info' class='edit_info' value='"+ ip + "'>";
            var button_info = $("<a href='javascript:void(0)' class='sure_add'  data-id='" + id + "'>确认修改</a>  <a href='javascript:void(0)' class='not_sure_add' data-id='" + id + "'>取消</a>");
            $(this).parent().prev().html(input_info);
            $(this).parent().html(button_info);
        });

        $(document).on('click', '.sure_add', function(){
            var val = $('.edit_info').val();
            var id = $('.sure_add').attr('data-id');
            var url = '/ip_edit';
            var data = {'id':id,'val':val};
            $.post(url, data, function(xhr){
                layer.confirm(xhr.res_desc, {
                    btn: ['好的'] //可以无限个按钮
                    ,yes: function(index, layero){
                        window.location.reload();
                    }
                });
            });
        });

        $(document).on('click', '.not_sure_add', function(){
            var id = $(this).attr('data-id');
            var ip = $(this).parent().prev().find('input').val();
            var edit_botton = '<a style="text-decoration:none" class="ml-5 ip_edit" data-id="' + id + '" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>';
            var del_botton = '<a style="text-decoration:none" class="ml-5 ip_del" data-id="' + id + '" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>';
            $(this).parent().prev().html(ip);
            $(this).parent().html(edit_botton + '  ' + del_botton);
        });

        /*ip-搜索*/
        $('#btn-search').bind("click", function(){
            var name = $('#ip_name').val();
            window.location.href = '/ip_info?ip_name=' + name;
        });
    })
</script>
</body>
</html>