<?php
class Response
{
    /**
     * ��ʽ����
     */
    const JSON="json";

    /**
     * ���ݲ�ͬ�ĸ�ʽ������ת������Ӧ�ĸ�ʽ���
     * @param $code ״̬��
     * @param $message  ��ʾ��Ϣ
     * @param array $data   ���ص�����
     * @param string $type  �������ݵĸ�ʽ��json.xml,array��
     * @return array|string
     */
    public static function show($code,$message,$data=array(),$type=self::JSON){
        //������ķ����벻������ʱ��return ��
        if(!is_numeric($code)){
            return '';
        }

        //��װһ������
        $result=array(
            'code'=>$code,
            'message'=>$message,
            'data'=>$data,
        );

        //���� $type ���зַ�
        if($type=="json"){
            self::jsonToEncode($code,$message,$data);
        }elseif($type=="xml"){
            self::xmlToEncode($code,$message,$data);
        }else{
            //ֱ�ӷ��������ʽ
            return $result;
        }
    }

    /**
     * ����json��ʽ����
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
     * ����xml��ʽ����
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
     * �Ѵ�����������ݣ���ʽ����xml��ʽ����
     * @param $data
     * @return string
     */
    public static function xmlEncode($data){
        $xml=$attr="";
        foreach($data as $key=>$value){
            //������Ϊ ���������飬�Ͱ��±��Խڵ����Ե���ʽ��װ���� <item id={�±�}>{value}</item>
            if(is_numeric($key)){
                $attr="id='{$key}'";
                $key="item";
            }
            $xml.="<{$key} {$attr}>";
            //�ݹ��������$value������ʱ���ٴε��ñ�����
            $xml.=is_array($value)?self::xmlEncode($value):$value;
            $xml.="</{$key}>";
        }
        return $xml;
    }
}