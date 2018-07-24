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
    <div class="text-c">
        <span class="select-box inline">
        <select name="company_info" class="select" id="company_info">
            <option value="">全部公司</option>
            @foreach($company_info as $value)
                <option value="{{ $value->c_id }}" <?php if($company_id == $value->c_id){ echo "selected=selected"; } ?>>{{ $value->c_name }}</option>
            @endforeach
        </select>
		</span>
        <input type="text" name="" id="domain_name" value="{{ $url }}" placeholder="https://" style="width:250px" class="input-text">
        <button name="" id="btn-search" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜域名</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" id="company_delall" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" data-title="添加活动" id="domain_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加域名</a>
            <input type="text" name="" value="" id="old_url" style="width:250px" class="input-text"> 替換為
            <input type="text" name="" value="" id="new_url" style="width:250px" class="input-text">
            <a class="btn btn-primary radius" data-title="添加活动" id="change_url" href="javascript:;">批量替換</a>
        </span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
            <tr class="text-c" role="row">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="20">ID</th>
                <th width="80">公司名称</th>
                <th width="80">公司域名</th>
                <th width="80">是否是主域名</th>
                <th width="120">创建时间</th>
                <th width="80">权重</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($domain_info as $val)
            <tr class="text-c">
                <td><input type="checkbox" value="{{ $val->d_id }}" class="ckb"></td>
                <td>{{ $val->d_id }}</td>
                <td>{{ $val->c_name }}</td>
                <td>{{ $val->d_url }}</td>
                <td>
                    @if($val->d_default == 1)
                        是
                    @else
                        否
                    @endif
                </td>
                <td>{{ $val->d_createtime }}</td>
                <td>{{ $val->d_weight }}</td>
                <td class="f-14 td-manage">
                    <a style="text-decoration:none" class="ml-5 domain_edit" data-id="{{ $val->d_id }}" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
                    <a style="text-decoration:none" class="ml-5 domain_del" data-id="{{ $val->d_id }}" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
                </td>
            </tr>
            @empty
            <tr class="text-c">
                <td colspan="20">No posts found.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
        {{ $domain_info->appends(request()->all())->links() }}
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

        // 批量替換（检查域名操作）
        $('#change_url').bind('click', function(){
            var old_url = $('#old_url').val();
            var new_url = $('#new_url').val();
            var url = '/domain_change';
            var data = {'old_url':old_url, 'active':'search'};
            $.post(url, data, function(xhr){ //检查域名合法性
                if(xhr == 'ok'){
                    layer.open({
                        content: '是否确定替换！'
                        ,btn: ['是的', '算了']
                        ,yes: function(index, layero){
                            domain_chageUrl(old_url, new_url);
                        }
                    });
                }else{
                    layer.open({
                        content: '暂无此域名，请确认需要替换的域名！'
                        ,btn: ['好的']
                        ,yes: function(index, layero){
                            layer.close(index);
                        }
                    });
                }
            });
        });

        // 域名-批量替换
        function domain_chageUrl(old_url, new_url){
            var url = '/domain_change';
            var data = {'old_url':old_url, 'new_url':new_url, 'active':'change'};
            $.post(url, data, function(xhr){
                if(xhr == 'success'){
                    window.location.reload();
                }else{
                    window.location.reload();
                }
            });
        }

        // 域名-添加
        $('#domain_add').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '添加域名',
                skin: 'layui-layer-rim',
                area: ['520px', '320px'],
                content: '/domain_add'
            });
        });

        // 域名-多条删除
        $('#company_delall').bind("click",function(){
            var ids = '';
            $(".ckb").each(function () {
                if ($(this).is(':checked')) {
                    ids += ',' + $(this).val(); //逐个获取id
                }
            });
            var ids = ids.substring(1);
            var url = '/domain_del';
            var data = {'id':ids};
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    $.post(url, data, function(xhr){
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.href='/domain';
                            }
                        });
                    });
                }
            });
        });

        // 域名-删除
        $(".domain_del").bind("click",function(){
            var id = $(this).attr('data-id');
            var url = '/domain_del';
            var data = {'id':id};
            layer.open({
                content: '确认要删除？'
                ,btn: ['是的', '算了']
                ,yes: function(index, layero){
                    $.post(url, data, function(xhr){
                        layer.confirm(xhr.res_desc, {
                            btn: ['好的'] //可以无限个按钮
                            ,yes: function(index, layero){
                                window.location.href='/domain';
                            }
                        });
                    });
                }
            });
        });

        // 域名-修改
        $('.domain_edit').bind("click",function(){
            var index = layer.open({
                type: 2,
                title: '修改域名',
                skin: 'layui-layer-rim',
                area: ['520px', '320px'],
                content: '/domain_edit'+'?id='+$(this).attr('data-id')
            });
        });

        // 域名-搜索
        $('#btn-search').bind("click", function(){
            var type = $('#company_info').val();
            var name = $('#domain_name').val();
            window.location.href = '/domain?company_id=' + type + '&domain_name=' + name + '&active=search';
        });
    })
</script>
</body>
</html>