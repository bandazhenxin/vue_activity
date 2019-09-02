<?php
class Response
{
    /**
     * 格式常量
     */
    const JSON="json";

    /**
     * 根据不同的格式把数据转换成响应的格式输出
     * @param $code 状态码
     * @param $message  提示信息
     * @param array $data   返回的数据
     * @param string $type  返回数据的格式（json.xml,array）
     * @return array|string
     */
    public static function show($code,$message,$data=array(),$type=self::JSON){
        //当传入的返回码不是数字时，return 空
        if(!is_numeric($code)){
            return '';
        }

        //组装一下数据
        $result=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data,
        );

        //根据 $type 进行分发
        if($type=="json"){
            self::jsonToEncode($code,$message,$data);
        }elseif($type=="xml"){
            self::xmlToEncode($code,$message,$data);
        }else{
            //直接返回数组格式
            return $result;
        }
    }

    /**
     * 产生json格式数据
     * @param $code
     * @param $message
     * @param array $data
     */
    public static function jsonToEncode($code,$message,$data=array()){
        $data=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        );
        echo json_encode($data);
        exit;
    }

    /***
     * 产生xml格式数据
     * @param $code
     * @param $message
     * @param array $data
     */
    public static function xmlToEncode($code,$message,$data=array()){
        $result = array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        );
        header("Content-Type:text/xml");
        $xml="<?xml version='1.0' encoding='UTF-8' ?>";
        $xml.="<root>";
        $xml.=self::xmlEncode($result);
        $xml.="</root>";
        echo $xml;
    }

    /**
     * 把传入的数组数据，格式化成xml格式数据
     * @param $data
     * @return string
     */
    public static function xmlEncode($data){
        $xml=$attr="";
        foreach($data as $key=>$value){
            //当数据为 索引型数组，就把下标以节点属性的形式组装起来 <item id={下标}>{value}</item>
            if(is_numeric($key)){
                $attr="id='{$key}'";
                $key="item";
            }
            $xml.="<{$key} {$attr}>";
            //递归遍历，当$value是数组时就再次调用本函数
            $xml.=is_array($value)?self::xmlEncode($value):$value;
            $xml.="</{$key}>";
        }
        return $xml;
    }
}