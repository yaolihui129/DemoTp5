<?php

use think\facade\Cache;
use think\facade\Cookie;
use think\facade\Session;

// 应用公共文件
    /**
     * 数据库操作
     * @param $table
     * @param $where
     * @param string $field
     * @return float|string $res
     */
    function countId($table,$where,$field = 'id'){
        $where['deleted'] = '0';
        $where['removed'] = '0';
        $count=db($table,[],false)->where($where)->count($field);
        return $count;
    }
    function countWithParent($table,$field,$parentId){
        $where=array($field=>$parentId);
        $count=countId($table,$where);
        return $count;
    }
    function getName($table,$id,$field = 'name'){
        $res = db($table,[],false)->where('id',$id)->value($field);
        return $res;
    }
    function sum($table,$field,$where){
        $res=db($table,[],false)->where($where)->sum($field,false);
        return $res;
    }
    function avg($table,$field,$where){
        $res=db($table,[],false)->where($where)->avg($field,false);
        return $res;
    }
    function filterID($table,$where,$field='id'){
        $res = db($table,[],false)->where($where)->column($field);
        return $res;
    }
    function getID($table,$where,$field='id'){
        $res = db($table,[],false)->where($where)->value($field);
        return $res;
    }

    /**
     * 格式化输出
     * @param $data
     * @param $code
     * @param $message
     * @return $res
     */
    function resFormat($data,$code='0',$message='ok'){
        if($data){
            $res=array(
                'errorCode'=>$code,
                'message'=>$message,
                'result'=>$data
            );
        }else{
            $res=array(
                'errorCode'=>$code,
                'message'=>$message
            );
        }
        return $res;
    }

    /**
     ** 加解密操作
     * @param $txt
     * @param string $key
     * @return string
     */
    function passport_encrypt($txt, $key = 'xiuliguanggao.com')
    {
        srand((double)microtime() * 1000000);
        $encrypt_key = md5(rand(0, 32000));
        $ctr = 0;
        $tmp = '';
        for($i = 0;$i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
        }
        return urlencode(base64_encode(passport_key($tmp, $key)));
    }
    function passport_decrypt($txt, $key = 'xiuliguanggao.com')
    {
        $txt = passport_key(base64_decode(urldecode($txt)), $key);
        $tmp = '';
        for($i = 0;$i < strlen($txt); $i++) {
            $md5 = $txt[$i];
            $tmp .= $txt[++$i] ^ $md5;
        }
        return $tmp;
    }
    function passport_key($txt, $encrypt_key)
    {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = '';
        for($i = 0; $i < strlen($txt); $i++) {
            $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
            $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
        }
        return $tmp;
    }

    function jiaMi($data,$key='',$type='1'){
        if(!$key){
            $key=config('app_name');
        }
        $data=lock_url($data,$key,$type);
        return $data;
    }
    function jieMi($data,$key=''){
        if(!$key){
            $key=config('app_name');
        }
        $data=unlock_url($data,$key);
        return $data;
    }
    //加密函数，$type='1',可变密文；$type='0',不变密文
    function lock_url($txt,$key,$type='0')
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
        if($type){
            $nh = rand(0,64);
        }else{
            $nh = 5;
        }
        $ch = $chars[$nh];
        $mdKey = md5($key.$ch);
        $mdKey = substr($mdKey,$nh%8, $nh%8+7);
        $txt = base64_encode($txt);
        $tmp = '';
        $k = 0;
        for ($i=0; $i<strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = ($nh+strpos($chars,$txt[$i])+ord($mdKey[$k++]))%64;
            $tmp .= $chars[$j];
        }
        return urlencode($ch.$tmp);
    }
    //解密函数
    function unlock_url($txt,$key)
    {
        $txt = urldecode($txt);
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
        $ch = $txt[0];
        $nh = strpos($chars,$ch);
        $mdKey = md5($key.$ch);
        $mdKey = substr($mdKey,$nh%8, $nh%8+7);
        $txt = substr($txt,1);
        $tmp = '';
        $k = 0;
        for ($i=0; $i<strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = strpos($chars,$txt[$i])-$nh - ord($mdKey[$k++]);
            while ($j<0) $j+=64;
            $tmp .= $chars[$j];
        }
        return base64_decode($tmp);
    }

    //获得访客浏览器类型
    function GetBrowser(){
        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $br = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/MSIE/i',$br)) {
                $br = 'MSIE';
            }elseif (preg_match('/Firefox/i',$br)) {
                $br = 'Firefox';
            }elseif (preg_match('/Chrome/i',$br)) {
                $br = 'Chrome';
            }elseif (preg_match('/Safari/i',$br)) {
                $br = 'Safari';
            }elseif (preg_match('/Opera/i',$br)) {
                $br = 'Opera';
            }else {
                $br = 'Other';
            }
            return $br;
        }else{
            return "获取浏览器信息失败！";
        }
    }
    //是否为微信
    function isWeiXin() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } return false;
    }
    //是否为QQ
    function isQQ() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'QQ') !== false) {
            return true;
        } return false;
    }
    //是否为支付宝
    function isAliPay() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
            return true;
        } return false;
    }
    //获取访客操作系统
    function GetOs(){
        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $OS = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/win/i',$OS)) {
                $OS = 'Windows';
            }elseif (preg_match('/mac/i',$OS)) {
                $OS = 'MAC';
            }elseif (preg_match('/linux/i',$OS)) {
                $OS = 'Linux';
            }elseif (preg_match('/unix/i',$OS)) {
                $OS = 'Unix';
            }elseif (preg_match('/bsd/i',$OS)) {
                $OS = 'BSD';
            }else {
                $OS = 'Other';
            }
            return $OS;
        }else{
            return "获取访客操作系统信息失败！";
        }
    }
    //获取访客IP地址
    function GetIP(){
        //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }else{
            $ip = '';
        }
        $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
        return $res;
    }
    // 服务器端IP
    function serverIP(){
        return gethostbyname($_SERVER["SERVER_NAME"]);
    }
    /**
     * 当前请求是否是https
     **/
    function isHttps()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off';
    }
    /**
     *数组相关操作
    /**
     * 二维数组排序
     * @param $arr
     * @param $keys
     * @param string $type
     * @return array
     */
    function arraySort($arr, $keys, $type = 'desc')
    {
        $key_value = $new_array = array();
        foreach ($arr as $k => $v) {
            $key_value[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($key_value);
        } else {
            arsort($key_value);
        }
        reset($key_value);
        foreach ($key_value as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
    /**
     * 过滤数组元素前后空格 (支持多维数组)
     */
    function trimArrayElement($arr){
        if(!is_array($arr))
            return trim($arr);
        return array_map('trim_array_element',$arr);
    }
    /**
     * 将二维数组以元素的某个值作为键 并归类数组
     * array( array('name'=>'aa','type'=>'pay'), array('name'=>'cc','type'=>'pay') )
     * array('pay'=>array( array('name'=>'aa','type'=>'pay') , array('name'=>'cc','type'=>'pay') ))
     */
    function groupSameKey($arr,$key){
        $new_arr = array();
        foreach($arr as $k=>$v ){
            $new_arr[$v[$key]][] = $v;
        }
        return $new_arr;
    }

    /**
     * 计算多个集合的笛卡尔积
     */
    function CartesianProduct($sets){
        $result = array();
        // 循环遍历集合数据
        for($i=0,$count=count($sets); $i<$count-1; $i++){
            // 初始化
            if($i==0){
                $result = $sets[$i];
            }
            $tmp = array();
            // 结果与下一个集合计算笛卡尔积
            foreach($result as $res){
                foreach($sets[$i+1] as $set){
                    $tmp[] = $res.$set;
                }
            }
            // 将笛卡尔积写入结果
            $result = $tmp;
        }
        return $result;
    }

    /**
     ** 字符串操作
     */
    /**
     * 获取随机码
     * @param $length
     * @return string
     */
    function getRandCode($length){
        $array = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
            '0','1','2','3','4','5','6','8','9','_'
        );
        $tmpstr ='';
        $max =count($array);
        for($i=1;$i<=$length;$i++){
            $key =rand(0,$max-1);
            $tmpstr.=$array[$key];
        }
        return $tmpstr;
    }

    /**
     *检查手机号码格式
     * @param $mobile
     * @return bool
     */
    function checkMobile($mobile){
        if(preg_match('/1[34578]\d{9}$/',$mobile))
            return true;
        return false;
    }

    /**
     *检查固定电话
     * @param $mobile
     * @return bool
     */
    function checkTelephone($mobile){
        if(preg_match('/^([0-9]{3,4}-)?[0-9]{7,8}$/',$mobile))
            return true;
        return false;
    }

    /**
     * 检查邮箱地址格式
     * @param $email
     * @return bool
     */
    function checkEmail($email){
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
            return true;
        return false;
    }
    //截取字符串最后的“。”
    function wxRtrim($arr,$a='。'){
        $arr=rtrim($arr, $a);
        return $arr;
    }

    /**
     *   实现中文字串截取无乱码的方法
     * @param $string
     * @param $start
     * @param $length
     * @return string
     */
    function getSubStr($string, $start, $length) {
        if(mb_strlen($string,'utf-8')>$length){
            $str = mb_substr($string, $start, $length,'utf-8');
            return $str.'...';
        }else{
            return $string;
        }
    }

    /**
     * 替换特殊字符
     * @param $orignalStr
     * @param string $replace
     * @return null|string|string[]
     */
    function replaceSpecialStr($orignalStr , $replace=''){
        return preg_replace("/[^\x{4e00}-\x{9fa5}]/iu", $replace ,$orignalStr);
    }

    /**
     **手机号码脱敏
     * @param $mobile
     * @return mixed
     */
    function mobileHide($mobile){
        return substr_replace($mobile,'****',3,4);
    }

    /**
     *URL安全转化
     * @param $uri
     * @return mixed|string
     */
    function urlSafeB4encode($uri)
    {
        $data = base64_encode($uri);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    /**
     * 获取整条字符串汉字拼音首字母
     * @param $zh
     * @return string
     */
    function pinYinLong($zh){
        $ret = "";
        $s1 = iconv("UTF-8","gb2312", $zh);
        $s2 = iconv("gb2312","UTF-8", $s1);
        if($s2 == $zh){$zh = $s1;}
        for($i = 0; $i < strlen($zh); $i++){
            $s1 = substr($zh,$i,1);
            $p = ord($s1);
            if($p > 160){
                $s2 = substr($zh,$i++,2);
                $ret .= getFirstCharter($s2);
            }else{
                $ret .= $s1;
            }
        }
        return $ret;
    }
    //php获取中文字符拼音首字母
    function getFirstCharter($str){
        if(empty($str))
        {
            return '';
        }
        $fchar=ord($str{0});
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
        $s1=iconv('UTF-8','gb2312//TRANSLIT//IGNORE',$str);
        $s2=iconv('gb2312','UTF-8//TRANSLIT//IGNORE',$s1);
        $s=$s2==$str?$s1:$str;
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319&&$asc<=-20284) return 'A';
        if($asc>=-20283&&$asc<=-19776) return 'B';
        if($asc>=-19775&&$asc<=-19219) return 'C';
        if($asc>=-19218&&$asc<=-18711) return 'D';
        if($asc>=-18710&&$asc<=-18527) return 'E';
        if($asc>=-18526&&$asc<=-18240) return 'F';
        if($asc>=-18239&&$asc<=-17923) return 'G';
        if($asc>=-17922&&$asc<=-17418) return 'H';
        if($asc>=-17417&&$asc<=-16475) return 'J';
        if($asc>=-16474&&$asc<=-16213) return 'K';
        if($asc>=-16212&&$asc<=-15641) return 'L';
        if($asc>=-15640&&$asc<=-15166) return 'M';
        if($asc>=-15165&&$asc<=-14923) return 'N';
        if($asc>=-14922&&$asc<=-14915) return 'O';
        if($asc>=-14914&&$asc<=-14631) return 'P';
        if($asc>=-14630&&$asc<=-14150) return 'Q';
        if($asc>=-14149&&$asc<=-14091) return 'R';
        if($asc>=-14090&&$asc<=-13319) return 'S';
        if($asc>=-13318&&$asc<=-12839) return 'T';
        if($asc>=-12838&&$asc<=-12557) return 'W';
        if($asc>=-12556&&$asc<=-11848) return 'X';
        if($asc>=-11847&&$asc<=-11056) return 'Y';
        if($asc>=-11055&&$asc<=-10247) return 'Z';
        return null;
    }

    // CURL_GET操作
    function httpGet($url){
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        curl_close($ch);
        if(curl_errno($ch)){
            $res=curl_errno($ch);
        }
        return $res;
    }
    function httpAuthGet($url, $user, $password)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$user:$password");
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        curl_close($ch);
        if (curl_errno($ch)) {
            $res = curl_errno($ch);
        }
        return $res;
    }
    function httpPost($url,$postJson){
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postJson);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        if(curl_errno($ch)){
            $res=curl_errno($ch);
        }
        return $res;
    }
    function httpJsonPost($url, $postJson)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        if (curl_errno($ch)) {
            $res = curl_errno($ch);
        }
        return $res;
    }
    function httpPut($url, $putJson)
    {
        $ch = curl_init();
        $header[] = "Content-type:image/jpeg";//定义header，可以加多个
        curl_setopt($ch, CURLOPT_URL, $url); //定义请求地址
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "put"); //定义请求类型，当然那个提交类型那一句就不需要了
        curl_setopt($ch, CURLOPT_HEADER, 0); //定义是否显示状态头 1：显示 ； 0：不显示
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//定义header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//定义是否直接输出返回流
        curl_setopt($ch, CURLOPT_POSTFIELDS, $putJson); //定义提交的数据
        $res = curl_exec($ch);
        curl_close($ch);//关闭
        if (curl_errno($ch)) {
            $res = curl_errno($ch);
        }
        return $res;
    }
    function httpAuthPost($url, $postJson,$user,$password)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 500);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$user:$password");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookiefile");
        curl_setopt($ch, CURLOPT_COOKIEJAR, "cookiefile");
        curl_setopt($ch, CURLOPT_COOKIE, session_name() . '=' . session_id());
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        if (curl_errno($ch)) {
            $res = curl_errno($ch);
        }
        return $res;
    }
    //封装请求API
    function requestApi($url,$method='GET',$data='',$type='array'){
        if($method=='GET'){
            $data = httpGet($url);
        }elseif ($method=='POST'){
            $data = httpJsonPost($url, json_encode($data));
        }elseif ($method=='PUT'){
            $data = httpPut($url, json_encode($data));
        }else{
            return false;
        }
        if($type=='array'){
            $data = json_decode(trim($data, "\xEF\xBB\xBF"), true);
        }
        return $data;
    }


    //根据日期获取星期
    function getWeek($date) {
        $dateArr = explode("-",$date);     //将传来的时间使用“-”分割成数组
        $year = $dateArr[0];       //获取年份
        $month = sprintf('%02d',$dateArr[1]);  //获取月份
        $day = sprintf('%02d',$dateArr[2]);      //获取日期
        $hour = $minute = $second = 0;   //默认时分秒均为0
        $dayOfWeek = mktime($hour,$minute,$second,$month,$day,$year);    //将时间转换成时间戳
        $shuChu = date("w",$dayOfWeek);      //获取星期值
        $weekArray=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
        return  $weekArray[$shuChu];
    }
    /**
     * 友好时间显示
     * @param $time
     * @return bool|false|string
     */
    function friendDate($time)
    {
        if (!$time)
            return false;
        $d = time() - intval($time);
        $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //得出年
        $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //得出月
        $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
        $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
        $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
        $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
        $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
        if ($d == 0) {
            $fdate = '刚刚';
        } else {
            switch ($d) {
                case $d < $atd:
                    $fdate = date('Y年m月d日', $time);
                    break;
                case $d < $td:
                    $fdate = '后天' . date('H:i', $time);
                    break;
                case $d < 0:
                    $fdate = '明天' . date('H:i', $time);
                    break;
                case $d < 60:
                    $fdate = $d . '秒前';
                    break;
                case $d < 3600:
                    $fdate = floor($d / 60) . '分钟前';
                    break;
                case $d < $dd:
                    $fdate = floor($d / 3600) . '小时前';
                    break;
                case $d < $yd:
                    $fdate = '昨天' . date('H:i', $time);
                    break;
                case $d < $byd:
                    $fdate = '前天' . date('H:i', $time);
                    break;
                case $d < $md:
                    $fdate = date('m月d日 H:i', $time);
                    break;
                case $d < $ld:
                    $fdate = date('m月d日', $time);
                    break;
                default:
                    $fdate = date('Y年m月d日', $time);
                    break;
            }
        }
        return $fdate;
    }

    function getCacheKey($key){
        $res=Cache::get($key);
        return $res;
    }
    function delCacheKey($key){
        $res = Cache::rm($key);
        return $res;
    }
    function clearCacheKey(){
        $res = Cache::clear();
        return $res;
    }
    function setCacheKey($key,$value,$expire=3600){
        $res = Cache::set($key,$value,$expire);
        return $res;
    }
    function incCacheValue($key,$step=1){
        $res =  Cache::inc($key,$step);
        return $res;
    }
    function decCacheValue($key,$step=1){
        $res = Cache::dec($key,$step);
        return $res;
    }

    /**
     * Cookie相关的操作
     * @param $key
     * @param $prefix
     * @return $res
     */
    function getCookieKey($key,$prefix=''){
        if($prefix){
            $res= Cookie::get($key,$prefix);
        }else{
            $res= Cookie::get($key,config('app_name').'_');
        }
        return $res;
    }
    function setCookieKey($key,$value,$expire=3600){
        if($expire){
            $res = Cookie::set($key,$value,['prefix'=>config('app_name').'_','expire'=>$expire]);
        }else{
            $res = Cookie::forever($key,$value,['prefix'=>config('app_name').'_']);
        }
        return $res;
    }
    function delCookieKey($key,$prefix=''){
        if($prefix){
            $res = Cookie::delete($key,$prefix);
        }else{
            $res = Cookie::delete($key,config('app_name').'_');
        }
        return $res;
    }
    function clearCookie($prefix=''){
        //  清空指定前缀的所有cookie值
        if($prefix){
            $res= Cookie::clear($prefix);
        }else{
            $res= Cookie::clear(config('app_name'));
        }
        return $res;
    }
    /**
     * Session相关的操作
     * @param $key
     * @param $prefix
     * @return $res
     */
    function getSession($key,$prefix=''){
        if($prefix){
            $res = Session::get($key,$prefix);
        }else{
            $res = Session::get($key,config('app_name'));
        }
        return $res;
    }
    /**
     * @param $key
     * @param $value
     * @param string $prefix
     */
    function setSession($key, $value, $prefix='')
    {
        if($prefix){
            Session::set($key,$value,$prefix);
        }else{
            Session::set($key,$value,config('app_name'));
        }
    }
    function clearSession($prefix=''){
        if($prefix){
            $res = Session::clear($prefix);
        }else{
            $res = Session::clear(config('app_name'));
        }
        return $res;
    }
    function getCache($key){
        $value=getSession($key);
        if(!$value){
            $value=getCookieKey($key);
            if($value){
                setSession($key,$value);
            }
        }
        return $value;
    }
    function setCache($key,$value,$expire=7*24*3600){
        setSession($key,$value);
        setCookieKey($key,$value,$expire);
        setCacheKey(getLoginUser().$key,$value,$expire);
        return true;
    }

    //获取登录用户
    function getLoginUser(){
        $user = getCache('user');
        $user = jieMi($user);
        return $user;
    }
    function getLoginUserID(){
        $userID = getCache('user_id');
        $userID =jieMi($userID);
        return $userID;
    }


    //获取某一字典值
    function getDictValue($type,$key,$value='value',$table='tp_dict'){
        $where=array('type'=>$type,'key'=>$key);
        $data = findOne($table,$where);
        if($data[$value]){
            return $data[$value];
        }else{
            return $key;
        }
    }
    //获取列表
    function getKVList($table,$where,$name='name',$order='id'){
        $data = getList($table,$where,$order);
        $list=array();
        foreach ($data as $k=>$da){
            $list[$k]['key']=$da['id'];
            $list[$k]['value']=$da[$name];
        }
        return $list;
    }
    //获取字典列表
    function getDictList($type,$table='tp_dict',$lim=''){
        $where=array('type'=>$type);
        if($lim){
            $where['key']=array('in',$lim);
        }
        return getList($table,$where,'sn');
    }
    //获取字典信息
    function getDictInfo($type,$key,$table='tp_dict',$what='value'){
        $where=array('type'=>$type,'key'=>$key);
        $data = findOne($table,$where);
        return $data[$what];
    }
    //封装字典为下拉菜单
    function dictList($type,$field,$table='tp_dict',$default='0',$lim=''){
        $data=getDictList($type,$table,$lim);
        $var=select($data,$field,$default);
        return $var;
    }
    //基础下拉菜单
    function select($data, $name, $value)
    {
        $html = '<select name="' . $name . '" class="form-control">';
        foreach ($data as $v) {
            $selected = ($v['key'] == $value) ? "selected" : "";
            $html .= '<option ' . $selected . ' value="' . $v['key'] . '">' . $v['value'] . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    //Excel相关的函数
    /**
     *根据下标获得单元格所在列位置
     * @param $index
     * @return mixed
     */
    function getCells($index){
        $arr=array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M',
            'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM',
            'AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
        );
        return $arr[$index];
    }
    /**
     **获取边框样式代码
     * @param $color
     * @return array
     */
    function getBorderStyle($color){
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('rgb' => $color),
                ),
            ),
        );
        return $styleArray;
    }
    /**
     **导出Excel到浏览器
     *  $type
     * $filename
     * $objPHPExcel
     * @param $type
     * @param $filename
     * @param $objPHPExcel
     * @throws PHPExcel_Reader_Exception
     * @throws PHPExcel_Writer_Exception
     */
    function browser_export($type,$filename,$objPHPExcel){
        //清除缓冲区,避免乱码
        ob_end_clean();
        if($type=='PDF'){
            header('Content-Type: application/pdf');
        }elseif ($type=='Excel5'){
            header('Content-Type: application/vnd.ms-excel');
        }elseif ($type=='OpenDocument'){
            header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
        }else{
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,$type);
        $objWriter->save('php://output');
    }
    /**
     * 比较两个版本大小, $v1>v2:1 ; $v1=v2:0 ;$v1<v2:0
     * @param $v1
     * @param $v2
     * @return int
     */
    function compareVersion($v1, $v2) {
        $v1 = explode(".",$v1);
        $v2 =  explode(".",$v2);
        $len = max(count($v1), count($v2));

        while(count($v1) < $len) {
            array_push($v1, 0);
        }

        while(count($v2) < $len) {
            array_push($v2, 0);
        }
        for($i = 0; $i < $len;$i++) {
            $num1 = intval($v1[$i]);
            $num2 = intval($v2[$i]);
            if ($num1 > $num2) {
                return 1;
            } else if ($num1 < $num2) {
                return -1;
            }
        }
        return 0;
    }

