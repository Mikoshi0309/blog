@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo; 友情链接
    </div>
    <!--面包屑导航 结束-->

	{{--<!--结果页快捷搜索框 开始-->--}}
	{{--<div class="search_wrap">--}}
        {{--<form action="" method="post">--}}
            {{--<table class="search_tab">--}}
                {{--<tr>--}}
                    {{--<th width="120">选择分类:</th>--}}
                    {{--<td>--}}
                        {{--<select onchange="javascript:location.href=this.value;">--}}
                            {{--<option value="">全部</option>--}}
                            {{--<option value="http://www.baidu.com">百度</option>--}}
                            {{--<option value="http://www.sina.com">新浪</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                    {{--<th width="70">关键字:</th>--}}
                    {{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
                    {{--<td><input type="submit" name="sub" value="查询"></td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</form>--}}
    {{--</div>--}}
    {{--<!--结果页快捷搜索框 结束-->--}}

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>友情链接管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/link/create')}}"><i class="fa fa-plus"></i>新增连接</a>
                    <a href="{{ url('admin/link')}}"><i class="fa fa-recycle"></i>全部连接</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" name=""></th>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>连接名称</th>
                        <th>连接标题</th>
                        <th>链接地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="59"></td>
                        <td class="tc">
                            <input type="text" onchange="changeorder(this,'{{ $v->link_id }}')" value="{{ $v->link_order }}">
                        </td>
                        <td class="tc">{{ $v->link_id }}</td>
                        <td>
                            <a href="#">{{ $v->link_name }}</a>
                        </td>
                        <td>{{ $v->link_title }}</td>
                        <td>{{ $v->link_url }}</td>
                        <td>
                            <a href="{{ url('admin/link/'.$v->link_id.'/edit') }}">修改</a>
                            <a href="javascript:;" onclick="delcat({{ $v->link_id }})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

<script>
//    $(function(){
//
//    });

    function changeorder(obj,link_id){
        var link_order = $(obj).val();
        $.post('{{ url('admin/link/changeorder') }}',{'_token':'{{ csrf_token() }}','link_id':link_id,'link_order':link_order},function(data){
            if(!data.status){
                layer.msg(data.msg,{icon:6});
                location.href = location.href;
            }else{
                layer.msg(data.msg,{icon:5});
            }

        });
    }

    function delcat(id){
        layer.confirm('您确定要删除吗？',{
            btn:['确定','取消']
        },function(){
            $.post('{{ url('admin/link/') }}/'+id,{'_method':'delete','_token':'{{ csrf_token() }}'},function(data){
                if(!data.status){
                    layer.msg(data.msg,{icon:6});
                    location.href = location.href;
                }else{
                    layer.msg(data.msg,{icon:5});
                }
            });
           // layer.msg('确定删除',{icon:1});
        },function(){
//            layer.msg('',{
//                time:20000,
//                btn:[]
//            });
        });
    }
</script>
@endsection