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
            layer.open({
                content: "{{ Session::get('edit_status') }}",
                yes: function(index, layero){
                    parent.$( "#btn-success" ).trigger( "click" );
                    layer.close(index); //如果设定了yes回调，需进行手工关闭
                    parent.$(".layui-layer-shade").remove();
                    parent.$(".layui-layer-iframe").remove();
                }
            });
        });
    </script>
@endif
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" id="btn-success" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <input type="text" name="" id="userinfo_name" value="{{ $users_name }}" placeholder=" 管理员名称" style="width:250px" class="input-text">
        <button name="" id="btn-search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜管理员</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" id="userinfo_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" data-title="添加活动" data-href="/userinfo_add" id="userinfo_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>
        </span>
        <span class="r">共有数据：<strong>{{ $user_count }}</strong>条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="80">用户名</th>
                <th width="80">角色</th>
                <th width="80">邮箱</th>
                <th width="80">加入时间</th>
                <th width="60">是否已启用</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($userinfo as $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{ $val->id }}" class="ckb"></td>
                    <td>{{ $val->id }}</td>
                    <td>{{ $val->name }}</td>
                    <td>{{ $val->r_name }}</td>
                    <td>{{ $val->email }}</td>
                    <td>{{ $val->created_at }}</td>
                    <td>
                        @if($val->status == 0)
                            <span class="label label-success radius">已启用</span>
                        @else
                            <span class="label label-error radius">未启用</span>
                        @endif
                    </td>
                    <td class="f-14 td-manage">
                        @if($val->status == 0)
                            <a style="text-decoration:none" href="javascript:;" class="enable" status="1" data-id="{{ $val->id }}" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
                        @else
                            <a style="text-decoration:none" href="javascript:;" class="enable" status="0" data-id="{{ $val->id }}" title="启用"><i class="Hui-iconfont">&#xe615;</i></a>
                        @endif
                        <a style="text-decoration:none" class="ml-5 userinfo_edit" data-id="{{ $val->id }}" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5 userinfo_del" data-id="{{ $val->id }}" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            @empty
                <tr class="text-c">
                    <td colspan="20">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $userinfo->appends(request()->all())->links() }}
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('/js/boxImg.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.page.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $('#btn-success').click(function(){
            window.location.reload();
        });

        /*管理员-添加*/
        $('#userinfo_add').bind("click",function(){
            var url = '/users_add';
            var title = '添加管理员';
            layer_show(title, url, '800', '400');
        });

        /*活动-多条删除*/
        $('#userinfo_delall').bind("click",function(){
            var ids = '';
            $(".ckb").each(function () {
                if ($(this).is(':checked')) {
                    ids += ',' + $(this).val(); //逐个获取id
                }
            });
            var ids = ids.substring(1);
            var url = '/users_del';
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
                ,btn2: function(index, layero){
                    //return false 开启该代码可禁止点击该按钮关闭
                }
                ,cancel: function(){
                    //return false 开启该代码可禁止点击该按钮关闭
                }
            });
        });

        /*管理员-删除*/
        $(".userinfo_del").bind("click",function(){
            var id = $(this).attr('data-id');
            var url = '/users_del';
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
                ,btn2: function(index, layero){
                    //return false 开启该代码可禁止点击该按钮关闭
                }
                ,cancel: function(){
                    //return false 开启该代码可禁止点击该按钮关闭
                }
            });
        });

        /*管理员-修改*/
        $('.userinfo_edit').bind("click",function(){
            var url = '/users_edit'+'?id='+$(this).attr('data-id');
            var title = '修改管理员信息';
            layer_show(title, url,'800', '400');
        });

        /*管理员-搜索*/
        $('#btn-search').bind("click", function(){
            var name = $('#userinfo_name').val();
            window.location.href = '/users?users_name=' + name;
        });

        /*管理员-启用/停用*/
        $('.enable').bind('click', function(){
           var status = $(this).attr('status');
           var id = $(this).attr('data-id');
           var url = '/users_enable';
           var data = {'id':id,'status':status};
           console.log(data);
           $.post(url, data, function(xhr){
               layer.confirm(xhr.res_desc, {
                   btn: ['好的'] //可以无限个按钮
                   ,yes: function(index, layero){
                       window.location.reload();
                   }
               });
           });
        });
    })
</script>
</body>
</html>