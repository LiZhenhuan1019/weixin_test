<html>
<head>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <?php
    require_once 'get_jsapi_ticket.php';
    $array = get_config_info();
    echo '<script>timestamp = "' . $array[0] . '";noncestr = "' . $array[1] . '";signature = "' . $array[2] . '";url = "' . $array[3] . '";</script>';

    ?>
    <script>
        appId = "wx343420ed7095b24b";
        wx.config({
            debug: false,
            appId: appId,
            timestamp: timestamp,
            nonceStr: noncestr,
            signature: signature,
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]
        });
        title = 'user-defined title';
        description = 'user-defined descrition';
            wx.ready(function () {
                var shareData = {
                    title: title,
                    desc: description,
                    link: url,
                    imgUrl: 'https://learnopengl.com/img/textures/container.jpg',
                    success: function () {
                        alert('已分享');
                    },
                    cancel: function () {
                        alert('已取消');
                    }
                };
                wx.onMenuShareAppMessage({
                    title: title,
                    desc: description,
                    link: url,
                    imgUrl: 'https://learnopengl.com/img/textures/container.jpg',
                    trigger: function (res) {
                        alert('用户点击发送给朋友');
                    },
                    success: function (res) {
                        alert('已分享');
                    },
                    cancel: function (res) {
                        alert('已取消');
                    },
                    fail: function (res) {
                        alert(JSON.stringify(res));
                    }
                });
                wx.onMenuShareTimeline(shareData);
                wx.onMenuShareQQ(shareData);
                wx.onMenuShareQZone(shareData);
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