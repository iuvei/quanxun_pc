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
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/tab.css') }}">
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
    <div class="text-c">
        <span class="select-box inline">
        <select name="activity_type" class="select" id="activity_type">
            <option value="">全部类型</option>
            @foreach($activity_type as $val)
                <option value="{{ $val->at_id }}" <?php if($type == $val->at_id){ echo "selected=selected"; } ?>>{{ $val->at_type }}</option>
            @endforeach
        </select>
        <select name="activity_company" class="select" id="activity_company">
            <option value="">全部公司</option>
            @foreach($activity_company as $value)
                <option value="{{ $value->c_id }}" <?php if($company == $value->c_id){ echo "selected=selected"; } ?>>{{ $value->c_name }}</option>
            @endforeach
        </select>
        <select name="a_type_info" class="select" id="a_type_info">
            <option value="">发布状态</option>
            <option value="1" <?php if($a_type_info==1){ echo "selected=selected"; } ?>>已发布-未开始</option>
            <option value="2" <?php if($a_type_info==2){ echo "selected=selected"; } ?>>已发布-活动中</option>
            <option value="3" <?php if($a_type_info==3){ echo "selected=selected"; } ?>>已发布-已结束</option>
            <option value="4" <?php if($a_type_info==4){ echo "selected=selected"; } ?>>未发布</option>
        </select>
		</span>
        <input type="text" name="" id="activity_name" value="{{ $activity_name }}" placeholder=" 活动名称" style="width:250px" class="input-text">
        <button name="" id="btn-search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜活动</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" id="activity_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" data-title="添加活动" data-href="/activity_add" id="activity_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加活动</a>
        </span>
        <span class="r">本页共有数据：<strong>{{ $activity_count }}</strong>条</span>
    </div>
    <div class="mt-20">
        <ul class="menu">
            <li data_type="1">HG6686活动</li>
            <li data_type="2">优惠活动</li>
        </ul>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr class="text-c" role="row">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="80">标题</th>
                <th width="80">分类</th>
                <th width="80">所属公司</th>
                <th width="80">活动图片</th>
                <th width="120">开始时间</th>
                <th width="120">结束时间</th>
                <th width="75">浏览次数</th>
                <th width="60">发布状态</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($activity as $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{ $val->a_id }}" class="ckb"></td>
                    <td>{{ $val->a_id }}</td>
                    <td class="text-l"><u style="cursor:pointer" class="text-primary" id="activity_show" data-id="{{ $val->a_id }}" title="查看内容">{{ $val->a_title }}</u></td>
                    <td>{{ $val->at_type }}</td>
                    <td>{{ $val->c_name }}</td>
                    <td><img src="{{ URL::asset( $val->a_image240x130 ) }}" modal="zoomImg" width="100px" height="70px" id="img"/></td>
                    <td>{{ $val->a_starttime }}</td>
                    <td>{{ $val->a_endtime }}</td>
                    <td>{{ $val->a_page_views }}</td>
                    <td class="td-status">
                        @if($val->a_status == 1)
                            @if($val->a_endtime <= $date)
                                <span class="label label-error radius">已发布-已结束</span>
                            @elseif($val->a_starttime <= $date && $val->a_endtime >= $date)
                                <span class="label label-success radius">已发布-活动中</span>
                            @else
                                <span class="label label-success radius">已发布-未开始</span>
                            @endif
                        @else
                            <span class="label label-error radius">未发布</span>
                        @endif
                    </td>
                    <td class="f-14 td-manage">
                        <a style="text-decoration:none" href="javascript:;"  data-id="{{ $val->a_id }}" data_sort="{{ $val->a_weights }}" is_type="1" title="上移" class="move"><i class="Hui-iconfont">&#xe6dc;</i></a>&nbsp;&nbsp;
                        <a style="text-decoration:none" href="javascript:;"  data-id="{{ $val->a_id }}" data_sort="{{ $val->a_weights }}" is_type="0" title="下移" class="move"><i class="Hui-iconfont">&#xe6de;</i></a>
                        <a style="text-decoration:none" class="ml-5 activity_edit" data-id="{{ $val->a_id }}" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a style="text-decoration:none" class="ml-5 activity_del" data-id="{{ $val->a_id }}" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                </tr>
            @empty
                <tr class="text-c">
                    <td colspan="20">No posts found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $activity->appends(request()->all())->links() }}
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('/js/boxImg.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/Huiadmin/static/h-ui.admin/js/H-ui.admin.page.js') }}"></script>
<script type="text/javascript">
    $(function(){
        var type = "<?php echo $a_type ?>";
        if(type == 1){
            $('.menu li:nth-child(1)').addClass('addClass')
        }else{
            $('.menu li:nth-child(2)').addClass('addClass')
        }
        $('.menu li').click(function (){
            var val = $(this).attr('data_type');
            window.location.href = '/activity?type=' + val;
        });

        $('#btn-success').click(function(){
            window.location.reload();
        });

        // 排序  上移-下移
        $('.move').bind('click', function(){
            var id = $(this).attr('data-id');
            var sort = $(this).attr('data_sort');
            var type = $(this).attr('is_type');
            var com_id = "<?php echo $a_type ?>";
            var url = '/activity_move';
            var data = {'id':id,'sort':sort,'type':type,'com_id':com_id};
            $.post(url, data, function(xhr){
                layer.confirm(xhr.res_desc, {
                    btn: ['好的'] //可以无限个按钮
                    ,yes: function(index, layero){
                        window.location.reload();
                    }
                });
            });
        });

        /*活动-添加*/
        $('#activity_add').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '添加活动',
                content: '/activity_add?type=' + "<?php echo $a_type ?>"
            });
            layer.full(index);
        });

        /*活动-多条删除*/
        $('#activity_delall').bind("click",function(){
            var ids = '';
            $(".ckb").each(function () {
                if ($(this).is(':checked')) {
                    ids += ',' + $(this).val(); //逐个获取id
                }
            }); 
            var ids = ids.substring(1);
            var url = '/activity_del';
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

        /*活动-删除*/
        $(".activity_del").bind("click",function(){
            var id = $(this).attr('data-id');
            var url = '/activity_del';
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

        /*活动-修改*/
        $('.activity_edit').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '修改活动',
                content: '/activity_edit'+'?id='+$(this).attr('data-id') + '&type=' + "<?php echo $a_type ?>"
            });
            layer.full(index);
        });

        /*活动-查看内容*/
        $('.text-primary').bind("click", function(){
            var index = layer.open({
                type: 2,
                title: '活动内容',
                content: '/activity_show'+'?id='+$(this).attr('data-id')
            });
            layer.full(index);
        });

        /*活动-搜索*/
        $('#btn-search').bind("click", function(){
            var name = $('#activity_name').val();
            var type = $('#activity_type').val();
            var a_type = "<?php echo $a_type ?>";
            var activity_company = $('#activity_company').val();
            var a_type_info = $('#a_type_info').val();
            window.location.href = '/activity?activity_name=' + name + '&activity_type=' + type + '&activity_company=' + activity_company + '&a_type_info=' + a_type_info + '&active=search' + '&type=' + a_type;
        });
    })
</script>
</body>
</html>