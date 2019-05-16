
var jsApiParameters;

function pay()
{
    $.ajax({
        type:"post",
        url:url,
        data:{
            '_token':csrf_token
        },
        dataType:'json',
        success:function(response){
            jsApiParameters = response;
            callpay();
        },
        error:function(opts, response){
            var result = response;
        }
    })

}

function callpay()
{
    if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        }else if (document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady', jsApiCall);
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
    }else{
        jsApiCall();
    }
}

function jsApiCall()
{
    var timestamp = Date.parse(new Date());
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        jsApiParameters,
        function(res){
            var str = JSON.stringify(jsApiParameters);
            alert(str)
            WeixinJSBridge.log(res.err_msg);
            if(res.err_msg=='get_brand_wcpay_request:ok'){
                alert("支付成功");
                var replace_url = "__APP__/wechat.php?c=Video&a=video&id="+t_id+"&node_id=0";
                location.href = replace_url
            }else if(res.err_msg=='get_brand_wcpay_request:cancel'){
                alert("支付取消");
            }else{
                alert("支付失败");
            }
        }
    );
}