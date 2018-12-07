@extends('backend.layout.app')

@section('content')

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">&nbsp;</h1>
        </div>
        <h3>奇奇谷会员管理后台</h3>
        <form class="m-t" method="post" id="form-validate-submit">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="用户名" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码" required>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
        </form>
    </div>
</div>

@endsection

<!--    js    -->
@section('js_code')
<script type="text/javascript">

    $(function () {
        var form_url = '{{route('backend.loginPost')}}';
        var index_url = '{{route('backend.index')}}';
        var rules = [];
        subActionAjaxValidateForMime('#form-validate-submit', rules, form_url, index_url);
    });

</script>
@endsection
