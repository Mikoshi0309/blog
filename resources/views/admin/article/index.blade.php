@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>快捷操作</h3>
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
                    <a href="{{ url('admin/article/create') }}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="{{ url('admin/article') }}"><i class="fa fa-recycle"></i>文章列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>点击</th>
                        <th>编辑</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{ $v->art_id }}</td>
                        <td>
                            <a href="#">{{ $v->art_title }}</a>
                        </td>
                        <td>{{ $v->art_view }}</td>
                        <td>{{ $v->art_editor }}</td>
                        <td>{{ date('Y-m-d',$v->art_time) }}</td>
                        <td>
                            @can('update',$v)
                            <a href="{{ url('admin/article/'.$v->art_id.'/edit') }}">修改</a>
                            @endcan
                            {{--<a href="{{ url('admin/article/'.$v->art_id.'/edit') }}">修改</a>--}}
                            <a href="javascript:;" onclick="delart({{ $v->art_id }})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>






                <div class="page_list">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
<style>
    .result_content ul li span {
        font-size: 15px;
        padding: 6px 12px;
    }
    </style>


    <script>
        function delart(id){
            layer.confirm('您确定要删除吗？',{
                btn:['确定','取消']
            },function(){
                $.post('{{ url('admin/article') }}/'+id,{'_token': '{{ csrf_token() }}','_method':'delete'},function(data){
                    if(!data.status){
                        layer.msg(data.msg,{icon:6});
                        location.href = location.href;
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                });
                // layer.msg('确定删除',{icon:1});
            },function(){
                return ;
//            layer.msg('',{
//                time:20000,
//                btn:[]
//            });
            });
        }
    </script>
@endsection