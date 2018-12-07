@extends('weChat.layout.app')
@section('title', $title_name)
@section('body')
    <div class="page__bd page__bd_footer">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">
                <h4 class="weui-media-box__title fontc-black">订单评价</h4>
                <p class="weui-media-box__desc">请留下您的宝贵意见!</p>
            </div>
            <div class="weui-panel__bd evaluate-add">
                <form id="form-add_class">
                    <input type="hidden" name="star" value="" id="form-star" required tips="请填写评价">
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    <input type="hidden" name="customer_id" value="{{$order->customer->id}}">
                    <input type="hidden" name="store_id" value="{{$order->store->id}}">
                    <input type="hidden" name="barber_id" value="{{$order->barber->id}}">
                    <div class="weui-media-box ">
                        <h4 class="weui-media-box__title star text-center" id="star">
                            <i data-num="1" class="fa fa-star"></i>
                            <i data-num="2" class="fa fa-star"></i>
                            <i data-num="3" class="fa fa-star"></i>
                            <i data-num="4" class="fa fa-star"></i>
                            <i data-num="5" class="fa fa-star"></i>
                        </h4>
                        <div class="textarea-box">
                            <textarea name="content" class="weui-textarea" placeholder="评论内容不得超过30个字符" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="weui-media-box">
                        <p class="weui-media-box__desc">订单编号：{{$order->order_no}}</p>
                        <p class="weui-media-box__desc">付款时间：{{$order->pay_at}}</p>
                        <p class="weui-media-box__desc">支付方式：{{config('params.pay_type')[$order->pay_type]}}</p>
                    </div>
                </form>
            </div>
            <div class="weui-panel__ft">
                <a id="btn_save" href="javascript:void(0);" class="weui-cell weui-cell_access weui-cell_link weui-form-preview__btn weui-form-preview__btn_primary">
                    <div class="weui-cell__bd">提交评价</div>
                </a>
            </div>
        </div>

        @include('weChat.layout.copyright')
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            var that = $('#star').find('i');
            that.click(function () {
                that.removeClass('checked');
                var thisL = $(this).index();
                for(var i = 0;i <= thisL;i++){
                    that.eq(i).addClass('checked');
                }
                $('#form-star').val(thisL + 1);
                console.log(thisL);
            });

            var pattern = {};
            var btn_save = $('#btn_save');
            btn_save.click(function () {
                weui.form.validate('#form-add_class', function (error) {
                    if (!error) {
                        var form_url = '{{url('wechat/evaluate/add')}}';
                        var jump_url = '{{url('wechat/order')}}';
                        var data = $('#form-add_class').serialize();
                        subActionAjaxForMime(form_url, data, jump_url);
                    }
                }, {
                    regexp: pattern
                });
            });
        })
    </script>
    @endsection