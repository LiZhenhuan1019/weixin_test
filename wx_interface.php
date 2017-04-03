<?php
/**
 * wechat php test
 */

require_once 'get_user_information.php';
//define your token
define("TOKEN", "lzhioadjflskahjlkjczicpozwefrsdf");
$wechatObj = new wechatCallbackapiTest();
try {
    if (key_exists('echostr', $_GET))
        $wechatObj->valid();
    else
        $wechatObj->response_msg();
} catch (Exception $e) {
    echo 'Caught Exception:', $e->getMessage(), "\n";
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    public function response_msg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msg_type = $postObj->MsgType;
            call_user_func(array($this, $msg_type . '_message'), $postObj);

//            $fromUsername = $postObj->FromUserName;
//            $toUsername = $postObj->ToUserName;
//            $keyword = trim($postObj->Content);
//            $time = time();
//            $textTpl = "<xml>
//							<ToUserName><![CDATA[%s]]></ToUserName>
//							<FromUserName><![CDATA[%s]]></FromUserName>
//							<CreateTime>%s</CreateTime>
//							<MsgType><![CDATA[%s]]></MsgType>
//							<Content><![CDATA[%s]]></Content>
//							<FuncFlag>0</FuncFlag>
//							</xml>";
//            if (!empty($keyword)) {
//                $msgType = "text";
//                $contentStr = "Welcome to wechat world!";
//                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//                echo $resultStr;
//            } else {
//                echo "Input something...";
//            }


        } else {
            echo "";
            exit;
        }
    }

    private function text_message($xml_element)
    {
        $text = $xml_element->Content;
		if($text == 'hello' || $text == "Hello" ||
		   $text == '你好')
        {
            $openid = $xml_element->FromUserName;
            $user_info = get_user_informantion($openid);
            if($user_info['subscribe'] == 1)
            {
                $user_name = $user_info['nickname'];
                echo $this->return_text_message($xml_element,"你好, $user_name!");
            }
        }
    }
    private function voice_message($xml_element)
    {
        $recognition = $xml_element->Recognition;
        echo $this->return_text_message($xml_element,$recognition);
    }

    private function event_message($xml_element)
    {
        call_user_func(array($this, $xml_element->Event . '_event'), $xml_element);
    }

    private function subscribe_event($xml_element)
    {
        echo $this->return_text_message($xml_element,"Welcome to follow this Official Account!");
    }

    private function return_text_message($xml_element,$text)
    {
        $fromUsername = $xml_element->FromUserName;
        $toUsername = $xml_element->ToUserName;
        $time = time();
        $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
        $msgType = "text";
        return $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $text);

    }

    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}

?>
