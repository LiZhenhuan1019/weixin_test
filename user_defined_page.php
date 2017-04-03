<html>
<head>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        appId = "wx343420ed7095b24b";
        timestamp = new Date().getTime();
        wx.config({
            debug: false,
            appId: '${appId}',
            timestamp: '${timestamp}',
            nonceStr: '${shakeMap.nonceStr}',
            signature: '${shakeMap.signature}',
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]
        });
        wx.ready(function () {
            var shareData = {
                title: '${title}',
                desc: '${description}',
                link: '${url}',
                imgUrl: '${headImgUrl}',
                success: function (res) {
                    //alert('已分享');
                },
                cancel: function (res) {
                }
            };
            wx.onMenuShareAppMessage({
                title: '${title}',
                desc: '${description}',
                link: '${url}',
                imgUrl: '${headImgUrl}',
                trigger: function (res) {
                    //  alert('用户点击发送给朋友');
                },
                success: function (res) {
                    //alert('已分享');
                },
                cancel: function (res) {
                    //alert('已取消');
                },
                fail: function (res) {
                    alert(JSON.stringify(res));
                }
            });
            wx.onMenuShareTimeline(shareData);
        });
        wx.error(function (res) {
            alert("error: " + res.errMsg);
        });
    </script>
</head>
</html>


<?php
/**
 * Created by PhpStorm.
 * User: lzh
 * Date: 4/3/17
 * Time: 10:57 PM
 */