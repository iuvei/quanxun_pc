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

    <title>活动管理</title>
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

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 活动管理 <span class="c-gray en">&gt;</span> 活动列表 <a class="btn btn-success radius r" id="btn-success" style="line-height:1.6em;margin-top:3px" href="javascript:void(0)" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    {{--<div class="text-c">--}}
        {{--<input type="text" name="" id="domain_name" value="" placeholder="推荐活动名称" style="width:250px" class="input-text">--}}
        {{--<button name="" id="btn-search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜活动</button>--}}
    {{--</div>--}}
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" id="recommend_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" data-title="添加活动" data-href="/recommend_add" id="recommend_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加活动</a>
        </span>
        <span class="r"></span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr class="text-c" role="row">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="80">活动标题</th>
                <th width="80">活动链接</th>
                <th width="80">活动图片</th>
                <th width="80">所属公司</th>
                <th width="80">是否发布</th>
                <th width="80">开始时间</th>
                <th width="80">结束时间</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($recommend as $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{ $val->r_id }}" class="ckb"></td>
                    <td>{{ $val->r_id }}</td>
                    <td>{{ $val->r_title }}</td>
                    <td>
                        @if($val->r_url == '')
                            无
                        @else
                            {{ $val->r_url }}
                        @endif
                    </td>
                    <td><img src="{{ URL::asset( $val->r_img ) }}" modal="zoomImg" width="100px" height="70px" id="img"/></td>
                    <td>{{ $val->c_name }}</td>
                    <td>
                        @if($val->r_is_show == 1)
                            @if($val->r_end_time <= $date)
                                <span class="label label-error radius">已发布-已结束</span>
                            @elseif($val->r_start_time <= $date && $val->r_end_time >= $date)
                                <span class="label label-success radius">已发布-活动中</span>
                            @else
                                <span class="label label-success radius">已发布-未开始</span>
                            @endif
                        @else
                            <span class="label label-error radius">未发布</span>
                        @endif
                    </td>
                    <td>{{ $val->r_start_time }}</td>
                    <td>{{ $val->r_end_time }}</td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" href="javascript:;"  data-id="{{ $val->r_id }}" data_sort="{{ $val->r_weights }}" is_type="1" title="上移" class="move"><i class="Hui-iconfont">&#xe6dc;</i></a>&nbsp;&nbsp;
                        <a style="text-decoration:none" href="javascript:;"  data-id="{{ $val->r_id }}" data_sort="{{ $val->r_weights }}" is_type="0" title="下移" class="move"><i class="Hui-iconfont">&#xe6de;</i></a>
                        <a style="text-decoration:none" class="ml-5 recommend_edit" data-id="{{ $val->r_id }}" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5 recommend_del" data-id="{{ $val->r_id }}" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            @empty
                <tr class="text-c">
                    <td colspan="20">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $recommend->appends(request()->all())->links() }}
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

        // 添加
        $('#recommend_add').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '添加弹窗活动',
                skin: 'layui-layer-rim',
                area: ['1300px', '820px'],
                content: '/recommend_add'
            });
        });

        // 多条删除
        $('#recommend_delall').bind("click",function(){
            var ids = '';
            $(".ckb").each(function () {
                if ($(this).is(':checked')) {
                    ids += ',' + $(this).val(); //逐个获取id
                }
            });
            var ids = ids.substring(1);
            var url = '/recommend_del';
            var data = {'id':ids};
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    $.post(url, data, function(xhr){
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.href='/recommend';
                            }
                        });
                    });
                }
            });
        });

        // 单条删除
        $(".recommend_del").bind("click",function(){
            var id = $(this).attr('data-id');
            var url = '/recommend_del';
            var data = {'id':id};
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    $.post(url, data, function(xhr){
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.href='/recommend';
                            }
                        });
                    });
                }
            });
        });

        // 修改
        $('.recommend_edit').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '修改弹窗活动',
                skin: 'layui-layer-rim',
                area: ['1300px', '820px'],
                content: '/recommend_edit'+'?id='+$(this).attr('data-id')
            });
        });

        // 排序  上移-下移
        $('.move').bind('click', function(){
            var id = $(this).attr('data-id');
            var sort = $(this).attr('data_sort');
            var type = $(this).attr('is_type');
            var url = '/recommend_move';
            var data = {'id':id,'sort':sort,'type':type};
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