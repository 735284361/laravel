@extends('layouts.app')

@section('script')
    <script>
        var url = '{{ url("testApi/wx_pay") }}';
        var csrf_token = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('js/wxpay.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <p onclick="pay()">支付</p>
    <img src="" id="qrcode" alt="">
</div>
@endsection
