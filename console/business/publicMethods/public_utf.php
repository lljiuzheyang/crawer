<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2017/8/9
 * Time: 13:26
 */

namespace console\business\publicMethods;


class public_utf
{
    public function convert_encoding_to_utf8($content){
        if(!empty($content) && !mb_check_encoding($content, 'utf-8')) {
            $content = mb_convert_encoding($content,'UTF-8','gbk');
        }
        return $content;
    }

    public function myTrim($str)
    {
        $search = array(" ","　","\n","\r","\t");
        $replace = array("","","","","");
        return trim(str_replace($search, $replace, $str));
    }

    public function xiufuHtml($html){
        $arr1 = ['&#39;','&nbsp;','&trade;','&copy;','&lt;','&gt;','&amp;','&quot;','&reg;','&lt;','&ldquo;','&rdquo;','&lsquo;','&rsquo;','&mdash;','&#160;'];
        $arr2 = ["'",'','™','©','<','>','&','“','®','<','“','”','‘','’','-','?'];
        return str_replace($arr1,$arr2,$html);
    }

    public function getRegtext($text){
        return $this->myTrim($this->xiufuHtml($this->convert_encoding_to_utf8($text)));
    }

    public static function get($url, $str_cookie='', $is_header=0, $is_set_header=0, $gzip=false)
    {
        $curl = curl_init();
        //curl_setopt($curl, CURLOPT_ENCODING, "");
        if($is_header){
            curl_setopt($curl, CURLOPT_HEADER, 1);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Chrome 42.0.2311.135');

        //解决重定向问题
//        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        if($gzip) {
            curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        }
        if(!empty($str_cookie)) {
            curl_setopt($curl, CURLOPT_COOKIE, $str_cookie);
        }

        if($is_set_header){
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Connection: keep-alive',
                'Cache-Control: max-age=0',
                'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Upgrade-Insecure-Requests:1',
                'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36',
                'Accept-Encoding:gzip, deflate, sdch',
                'Accept-Language:zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4',

            ]);
        }

        $res = curl_exec($curl);
        $info = curl_getinfo($curl);

        /*
        print "info";
        print "<br>";
        print_r ($info);
        print "res";
        print "<br>";
        print_r ($res);
        */

        curl_close($curl);


        return $res;
    }

    public static function post($url, $data, $str_cookie='', $header='') {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        /*if ($ca) { 微信红包，证书处理
            curl_setopt($curl, CURLOPT_SSLCERT, '/webser/o2o_ssl/pay_cert/'.$token.'/apiclient_cert.pem');
            curl_setopt($curl, CURLOPT_SSLKEY, '/webser/o2o_ssl/pay_cert/'.$token.'/apiclient_key.pem');
            curl_setopt($curl, CURLOPT_CAINFO, '/webser/o2o_ssl/pay_cert/'.$token.'/rootca.pem');
        }*/

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        if(!empty($str_cookie)) {
            curl_setopt($curl, CURLOPT_COOKIE, $str_cookie);
        }

        if(!empty($header)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        $res = curl_exec($curl);
        curl_close($curl);
        /*
        print "info";
        print "<br>";
        return $res;
        */
    }

}