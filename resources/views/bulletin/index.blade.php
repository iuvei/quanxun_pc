<?php
date_default_timezone_set('PRC');
$time = time()+(8*60*60)-170;
$date = date('Y-m-d H:i:s', $time);
?>
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

    <title>公告管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
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

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 公告管理 <span class="c-gray en">&gt;</span> 公告列表 <a class="btn btn-success radius r" id="btn-success" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">        
        <input type="text" name="" id="bulletin_name" value="{{ $bulletin_name }}" placeholder=" 公告名称" style="width:250px" class="input-text">
        <button name="" id="btn-search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜公告</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" id="bulletin_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" data-title="添加公告" data-href="/bulletin_add" id="bulletin_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加公告</a>
        </span>
        <span class="r">共有数据：<strong>{{ $bulletin_count }}</strong>条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="80">公告标题</th>
                <th width="120">公告内容</th>
                <th width="120">开始时间</th>
                <th width="120">结束时间</th>
                <th width="60">发布状态</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($bulletin_info as $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{ $val->b_id }}" class="ckb"></td>
                    <td>{{ $val->b_id  }}</td>
                    <td>{{ $val->b_title  }}</td>
                    <td>{{ $val->b_content_info  }}</td>
                    <td>{{ $val->b_starttime }}</td>
                    <td>{{ $val->b_endtime }}</td>
                    <td class="td-status">
                        @if($val->b_status == 1)
                            @if($val->b_endtime <= $date)
                                <span class="label label-error radius">已发布-已结束</span>
                            @elseif($val->b_starttime <= $date && $val->b_endtime >= $date)
                                <span class="label label-success radius">已发布-展示中</span>
                            @else
                                <span class="label label-success radius">已发布-未开始</span>
                            @endif
                        @else
                            <span class="label label-error radius">未发布</span>
                        @endif
                    </td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" class="ml-5 bulletin_edit" data-id="{{ $val->b_id }}" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5 bulletin_del" data-id="{{ $val->b_id }}" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            @empty
                <tr class="text-c">
                    <td colspan="20">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $bulletin_info->appends(request()->all())->links() }}
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

        /*公告-添加*/
        $('#bulletin_add').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '添加公告',
                content: '/bulletin_add'
            });
            layer.full(index);
        });

        /*公告-多条删除*/
        $('#bulletin_delall').bind("click",function(){
            var ids = '';
            $(".ckb").each(function () {
                if ($(this).is(':checked')) {
                    ids += ',' + $(this).val(); //逐个获取id
                }
            });
            var ids = ids.substring(1);
            var url = '/bulletin_del';
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

        /*公告-删除*/
        $(".bulletin_del").bind("click",function(){
            var id = $(this).attr('data-id');
            var url = '/bulletin_del';
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

        /*公告-修改*/
        $('.bulletin_edit').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '修改公告',
                content: '/bulletin_edit'+'?id='+$(this).attr('data-id')
            });
            layer.full(index);
        });

        /*公告-查看内容*/
        $('.bulletin_show').bind("click", function(){
            var index = layer.open({
                type: 2,
                title: '公告内容',
                content: '/bulletin_show'+'?id='+$(this).attr('data-id')
            });
            layer.full(index);
        });

        /*公告-搜索*/
        $('#btn-search').bind("click", function(){
            var name = $('#bulletin_name').val();
            window.location.href = '/bulletin?bulletin_name=' + name;           
        });

        // 公告内容显示
        $('#bulletin_show').bind('click', function(){

        });
    })
</script>
</body>
</html>