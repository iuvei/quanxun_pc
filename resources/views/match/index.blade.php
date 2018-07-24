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

    <title>赛事管理</title>
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

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 赛事管理 <span class="c-gray en">&gt;</span> 赛事列表 <a class="btn btn-success radius r" id="btn-success" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <input type="text" name="" id="match_name" value="{{ $match_name }}" placeholder=" 赛事名称" style="width:250px" class="input-text">
        <button name="" id="btn-search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜赛事</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            {{--<a href="javascript:;" id="match_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>--}}
            <a class="btn btn-primary radius" data-title="添加活动" data-href="/activity_add" id="match_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加赛事</a>
        </span>
        <span class="r">共有数据：<strong>{{ $match_info_count }}</strong>条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="20">ID</th>
                <th width="20">置顶</th>
                <th width="80">联赛名称</th>
                <th width="150">开赛时间</th>
                <th width="80">上盘球队</th>
                <th width="80">盘口</th>
                <th width="120">下盘球队</th>
                <th width="120">免费推荐</th>
                <th width="75">比分</th>
                <th width="75">结果</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($match_info as $val)
                <tr class="text-c">
                    <td>{{ $val->m_sort }}</td>
                    <td><input type="checkbox" data-id="{{ $val->m_id }}" data-is-top-id="{{ $val->m_is_top }}" class="ckb" <?php if($val->m_is_top == 1){ echo("checked"); } ?>></td>
                    <td>{{ $val->m_title }}</td>
                    <td>{{ $val->m_status_time }}</td>
                    <td>{{ $val->m_home_team }}</td>
                    <td>{{ $val->m_change }}</td>
                    <td>{{ $val->m_visiting_team }}</td>
                    <td>{{ $val->m_recommend }}</td>
                    <td>{{ $val->m_score }}</td>
                    <td>{{ $val->m_result }}</td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" href="javascript:;"  data-id="{{ $val->m_id }}" data_sort="{{ $val->m_sort }}" is_type="1" title="上移" class="move"><i class="Hui-iconfont">&#xe6dc;</i></a>
                        <a style="text-decoration:none" href="javascript:;"  data-id="{{ $val->m_id }}" data_sort="{{ $val->m_sort }}" is_type="0" title="下移" class="move"><i class="Hui-iconfont">&#xe6de;</i></a>
                        <a style="text-decoration:none" class="ml-5 match_edit" data-id="{{ $val->m_id }}" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5 match_del" data-id="{{ $val->m_id }}" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            @empty
                <tr class="text-c">
                    <td colspan="20">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $match_info->appends(request()->all())->links() }}
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

        // 赛事-添加
        $('#match_add').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '添加赛事',
                content: '/match_add'
            });
            layer.full(index);
        });

        // 赛事-删除
        $(".match_del").bind("click",function(){
            var id = $(this).attr('data-id');
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    var url = '/match_del';
                    var data = {'id':id};
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

        // 赛事-修改
        $('.match_edit').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '修改赛事',
                content: '/match_edit?id='+$(this).attr('data-id')
            });
            layer.full(index);
        });

        // 赛事搜素
        $('#btn-search').click(function(){
            var name = $('#activity_name').val();
            window.location.href = '/activity?activity_name=' + name;
        });

        // 赛事-置顶
        $('.ckb').bind("click", function(){
            var id = $(this).attr('data-id');
            var is_top = $(this).attr('data-is-top-id');
            var url = '/match_is_top';
            if(is_top == 1){
                var type = 0;
                var data = {'id':id, 'type':type};
                layer.open({
                    content: '提醒：您确定要取消此记录置顶吗？'
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
            }else{
                var type = 1;
                var data = {'id':id, 'type':type};
                layer.open({
                    content: '提醒：您确定要设置此记录置顶吗？'
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
            }
        });

        //活动-搜索
        $('#btn-search').bind("click", function(){
            var name = $('#match_name').val();
            window.location.href = '/match?match_name=' + name;
        });

        // 活动-上移-下移
        $('.move').bind('click', function(){
            var id = $(this).attr('data-id');
            var sort = $(this).attr('data_sort');
            var type = $(this).attr('is_type');
            var url = '/match_move';
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
    });
</script>
</body>
</html>