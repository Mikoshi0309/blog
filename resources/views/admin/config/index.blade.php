@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo; 导航
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
        <div class="result_wrap">
            <div class="result_title">
                <h3>友情链接管理</h3>
                @if(count($errors)>0)
                    <div class="mark">
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        @else
                            <p>{{ $errors }}</p>
                        @endif
                    </div>
                @endif
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/config/create')}}"><i class="fa fa-plus"></i>新增配置</a>
                    <a href="{{ url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{ url('admin/config/changecontent') }}" method="post">
                    {{ csrf_field() }}
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" name=""></th>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="59"></td>
                        <td class="tc">
                            <input type="text" onchange="changeorder(this,'{{ $v->conf_id }}')" value="{{ $v->conf_order }}">
                        </td>
                        <td class="tc">{{ $v->conf_id }}</td>
                        <td>
                            <a href="#">{{ $v->conf_title }}</a>
                        </td>
                        <td>{{ $v->conf_name }}</td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{ $v->conf_id }}">
                            {!! $v->_html !!}
                        </td>
                        <td>
                            <a href="{{ url('admin/config/'.$v->conf_id.'/edit') }}">修改</a>
                            <a href="javascript:;" onclick="delcat({{ $v->conf_id }})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </form>
            </div>
        </div>
    <!--搜索结果页面 列表 结束-->

<script>
//    $(function(){
//
//    });

    function changeorder(obj,nav_id){
        var conf_order = $(obj).val();
        $.post('{{ url('admin/config/changeorder') }}',{'_token':'{{ csrf_token() }}','conf_id':nav_id,'conf_order':conf_order},function(data){
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
            $.post('{{ url('admin/config/') }}/'+id,{'_method':'delete','_token':'{{ csrf_token() }}'},function(data){
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