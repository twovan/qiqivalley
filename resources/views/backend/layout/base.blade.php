@extends('backend.layout.app')
@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-center p-md">
                <h2>欢迎 <span class="text-navy">{{$user['name']}}</span></h2>
                <p>
                    操作完毕后请及时退出。
                </p>
            </div>
        </div>
    </div>

@endsection