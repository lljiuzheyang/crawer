<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2018/10/9
 * Time: 上午10:49
 */

namespace console\business\crawler;

use console\business\publicMethods\public_utf;
use console\business\publicMethods\simple_html_dom;
use console\service\crawler\TeacherEmailService;

class TeacherEmailBusiness
{
    private $_teacherEmailService;

    #region 获取所有url
    //天津工业大学纺织学院链接
    private $TjpuUrl = 'http://fz.tjpu.edu.cn/msjs/list.htm';

    //全国导师系统
    private $Daoshieol = 'https://daoshi.eol.cn';

    //扬州大学建筑科学与工程学院
    private $Jgxyyzu = 'http://jgxy.yzu.edu.cn/col/col7675/index.html';

    //华南理工大学
    private $Yanzhaoscut = 'https://yanzhao.scut.edu.cn/open/TutorList.aspx';

    //扬州大学化学化工学院
    private $Hxhgyzu = 'http://hxhg.yzu.edu.cn/module/web/jpage/dataproxy.jsp?startrecord=1&endrecord=89&perpage=40';

    //南京理工大学研究生院
    //机械工程学院:yxsh=101等具体看http://gs.njust.edu.cn/dsjs/list.htm
    private $NanjingTechnology = 'http://202.119.85.163/open/DsDir_View.aspx?yxsh=125';

    //中国科学院沈阳自动化研究院
    private $Sia = 'http://www.sia.cn/yjsjy/dsjj/bsds/jxzzjqzdh/';

    //南方科技大学
    private $Sustc = 'http://www.sustc.edu.cn/campus_shuli_2';

    #endregion

    #region 正则邮箱校验规则
    private $PREG = "/([a-z0-9\-_\.]+@[a-z0-9]+\.[a-z0-9\-_\.]+)+/i";

    #endregion

    public function __construct(TeacherEmailService $teacherEmailService)
    {
        $this->_teacherEmailService = $teacherEmailService;
    }

    /**
     * 获取天津工业大学纺织学院教师邮箱
     *
     * @author      刘富胜 2018-10-09
     * @return int 返回类型
     */
    public function getTeacherMail_tjpu()
    {
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');

        #region 获取天津工业大学纺织学院的网页信息
        $html = new simple_html_dom();
        $html->load_file($this->TjpuUrl);
        $pub = new public_utf();
        #endregion

        $teacher_name = [];//教师名称
        $source = [];
        $json = [];
        #region 遍历所有教师及其所有教师对应的相应的详情界面链接
        $count = 0;
        $content_table = $html->find("#wp_content_w6_0 table td a");
        foreach ($content_table as $v) {

            $name = $pub->myTrim($v->plaintext);
            if (!empty($name)) {
                $href = $v->href;
                if (!empty($href)) {
                    $teacher_name[] = $name;
                    $source[] = $href;
                }
            }

            $count++;
        }
        #endregion

        #region 获取邮箱地址
        for ($i = 0; $i < count($source); $i++) {
            $email = [];
            $html->clear();
            $html->load_file($source[$i]);

            foreach ($html->find(".wp_articlecontent") as $e) {
                $str = $e->plaintext;
                if (preg_match($this->PREG, $str, $matches)) {
                    $email[] = $matches[0];
                }
            }

            if (!empty($email) && count($email) > 0) {
                foreach ($email as $em) {
                    $json[] = [
                        'teacher_name' => $teacher_name[$i],
                        'source' => $source[$i],
                        'email' => $em,
                        'create_time' => date('Y-m-d h:i:s', time()),
                        'create_by' => 'ALpython',
                        'type' => '教授',
                        'school_name' => '天津工业大学纺织学院',
                    ];
                }
            }

        }
        #endregion

        return $this->_teacherEmailService->batchSave($json);
    }

    /**
     * 获取研究生导师查询系统
     *
     * @author      刘富胜 2018-10-09
     * @return int 返回类型
     */
    public function getTeacherMail_daoshieol()
    {
        $pack = '/home/getTutor';
        $special_id = 0;
        $recommend = 1;
        $json = [];
        // 1-31  40
        // 31-61 2
        // 61-91 1
        // 91-121 2
        // 121-151 48
        // 151-181 0
        // 181-211 1
        // 211-311 187
        // 511-711 53
        // 711-911 29
        // 911-1111 5
        // 1111-1311 14
        // 1311-1511 1
        // 1511-1711 24
        // 1711-1911 947
        // 1911-2111 1118
        // 2111-2311 1114
        // 2311-2511 969
        // 2511-2711 949
        // 2711-2911 1026
        // 2911-3111 1195
        // 3111-3311 1278
        // 3311-3511 1346
        // 3511-3711 1158
        // 3711-3911 1260
        // 3911-4111 1230
        // 4111-4290 1112
        for ($page = 4111; $page < 4290; $page++) {
            $url = $this->Daoshieol . $pack . '?special_id=' . $special_id . '&page=' . $page . '&recommend='
                . $recommend;
            $content = public_utf::get($url);
            $arr = json_decode($content);
            foreach ($arr->data as $data) {
                $json[] = [
                    'teacher_name' => $data->name,
                    'source' => $url,
                    'email' => $data->email,
                    'create_time' => date('Y-m-d h:i:s', time()),
                    'create_by' => 'ALpython',
                    'type' => $data->title,
                    'school_name' => $data->school,
                ];
            }
        }
        $count = $this->_teacherEmailService->batchSave($json);
        return $count;

    }

    /**
     * 扬州大学建筑科学与工程学院
     *
     * @author      刘富胜 2018-10-09
     * @return int 返回类型
     */
    public function getTeacherMail_jgxyyzu()
    {
        // 保存了31
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');

        $root_url = 'http://jgxy.yzu.edu.cn';
        #region 获取天津工业大学纺织学院的网页信息
        $html = new simple_html_dom();
        $html->load_file($this->Jgxyyzu);
        $pub = new public_utf();
        #endregion

        $school_name = '扬州大学建筑科学与工程学院';
        $teacher_name = [];//教师名称
        $source = [];
        $json = [];
        #region 遍历所有教师及其所有教师对应的相应的详情界面链接
        foreach ($html->find('#zoom td a') as $v) {
            $teacher_name[] = $pub->getRegtext($v->plaintext);
            $source[] = $root_url . $v->href;
        }
        #endregion

        #region 通过链接获取教师的邮箱
        for ($i = 0; $i < count($source); $i++) {
            $content = [];
            $html->clear();

            $html->load_file($source[$i]);
            $td_html = $html->find('#zoom td');
            if (!empty($td_html)) {
                foreach ($td_html as $td) {
                    $content[] = $pub->getRegtext($td->plaintext);
                }
                $type = $content[3];
                $email = '';
                if (preg_match($this->PREG, $content[10], $matches)) {
                    $email = $matches[0];
                }
                if (!empty($email)) {
                    $json[] = [
                        'teacher_name' => $teacher_name[$i],
                        'source' => $source[$i],
                        'email' => $email,
                        'create_time' => date('Y-m-d h:i:s', time()),
                        'create_by' => 'ALpython',
                        'type' => $type,
                        'school_name' => $school_name,
                    ];
                }
            }
            unset($content);
        }
        #endregion
        return $this->_teacherEmailService->batchSave($json);

    }

    /**
     * 获取华南理工大学教师邮箱
     *
     * @author      刘富胜 2018-10-10
     * @return int 返回类型
     */
    public function getTeacherMail_yanzhaoscut()
    {
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
        $content = public_utf::get($this->Yanzhaoscut);
        $html = new simple_html_dom();
        $html->load($content);

        $source = [];
        foreach ($html->find('#dgData a[target=_blank]') as $v) {
            $source[] = $v->href;
        }
        $page1_save = $this->saveAllYanzhaoscut($source);
        $EVENTVALIDATION = $html->find('#__EVENTVALIDATION')[0]->value;
        $VIEWSTATE = $html->find('#__VIEWSTATE')[0]->value;
        $VIEWSTATEGENERATOR = $html->find('#__VIEWSTATEGENERATOR')[0]->value;
        $VIEWSTATEENCRYPTED = $html->find('#__VIEWSTATEENCRYPTED')[0]->value;
        $save_count = $this->recursionYanzhaoscut($EVENTVALIDATION, $VIEWSTATE, $VIEWSTATEENCRYPTED, $VIEWSTATEGENERATOR);
        return $page1_save + $save_count;
    }

    /**
     * 扬州大学建筑化学化工学院
     *
     * @author      刘富胜 2018-10-15
     * @return int 返回类型
     */
    public function getTeacherMail_hxhgyzu()
    {
        // 72条数据
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
        $data = [
            'col' => 1,
            'appid' => 1,
            'webid' => 58,
            'path' => '/',
            'columnid' => 2510,
            'sourceContentType' => 1,
            'unitid' => 63169,
            'webname' => '化学化工学院',
            'permissiontype' => 0
        ];
        $origin = 'http://hxhg.yzu.edu.cn';
        $referer = 'http://hxhg.yzu.edu.cn/col/col2510/index.html?uid=63169&pageNum=5';
        $cookie = public_utf::get_cookie($this->Hxhgyzu, $data, $referer);
        $header = [
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
            'origin:' . $origin,
            'referer:' . $referer
        ];
        $content = public_utf::post($this->Hxhgyzu, http_build_query($data), $cookie, $header);
        $pub = new public_utf();
        $html = new simple_html_dom();
        $html->load(str_replace(['<![CDATA[', ']'], '', $content));
        $href = [];
        $teacher_name = [];
        $type = [];
        $json = [];
        foreach ($html->find('a') as $v) {
            $href[] = $origin . $v->href;
            $teacher_name[] = $pub->getRegtext(str_replace(['简介', '教授', '副', '讲师', '博士', '校聘', '校特聘'], '', $v->title));
            if (strpos($v->title, '教授')) {
                $type[] = '教授';
            } else {
                $type[] = '教师';
            }
        }

        for ($i = 0; $i < count($href); $i++) {
            $html->clear();
            $html->load_file($href[$i]);
            #region 获取邮箱
            $email = [];
            foreach ($html->find('.article') as $item) {
                $str = $pub->getRegtext($item->plaintext);
                if (preg_match($this->PREG, $str, $matches)) {
                    $email[] = $matches[0];
                }
            }
            #endregion

            if (!empty($email) && count($email) > 0) {
                foreach ($email as $em) {
                    $json[] = [
                        'teacher_name' => $teacher_name[$i],
                        'source' => $href[$i],
                        'email' => $em,
                        'create_time' => date('Y-m-d h:i:s', time()),
                        'create_by' => 'ALpython',
                        'type' => $type[$i],
                        'school_name' => '扬州大学建筑化学化工学院',
                    ];
                }
            }
        }

        return $this->_teacherEmailService->batchSave($json);

    }

    /**
     * 南京理工大学研究生院
     *
     * @author      刘富胜 2018-10-15
     * @return int 返回类型
     */
    public function getTeacherMail_nanjing_technology()
    {
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');

        #region 获取南京理工大学研究生院
        $html = new simple_html_dom();
        $host = 'http://202.119.85.163/open/';
        $html->load_file($this->NanjingTechnology);
        $pub = new public_utf();
        #endregion
        $school_name = '南京理工大学研究生院';
        $json = [];
        $source = [];
        foreach ($html->find('.Grid_Line a') as $v) {
            if (strpos($v->href, 'www') === false && strpos($v->href, 'http') === false) {
                $source[] = $host . $pub->myTrim($v->href);
            }
        }

        for ($i = 0; $i < count($source); $i++) {
            try {
                \Yii::info($i, 'test');
                $html->clear();
                $html->load_file($source[$i]);
                $tds = [];
                $tbLine = $html->find('.tb_line');
                if (!empty($tbLine)) {
                    foreach ($tbLine as $td) {
                        $tds[] = $pub->getRegtext($td->plaintext);
                    }
                    $teacher_name = $tds[1];
                    $type = $tds[17];
                    $email = $tds[27];
                    if (!empty($email)) {
                        $json[] = [
                            'teacher_name' => $teacher_name,
                            'source' => $source[$i],
                            'email' => $email,
                            'create_time' => date('Y-m-d h:i:s', time()),
                            'create_by' => 'ALpython',
                            'type' => $type,
                            'school_name' => $school_name,
                        ];
                    }
                }
            } catch (\Exception $e) {
                $json[] = [
                    'teacher_name' => '',
                    'source' => '',
                    'email' => '',
                    'create_time' => date('Y-m-d h:i:s', time()),
                    'create_by' => 'ALpython',
                    'type' => '',
                    'school_name' => $school_name,
                ];
                continue;
            }

        }

//        return $source;
        return $this->_teacherEmailService->batchSave($json);

    }

    /**
     * 中国科学院沈阳自动化研究院
     *
     * @author      刘富胜 2018-10-15
     * @return int 返回类型
     */
    public function getTeacherMail_sia()
    {
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');

        #region 获取南京理工大学研究生院
        $html = new simple_html_dom();
        $html->load_file($this->Sia);
        $pub = new public_utf();
        #endregion

        $school_name = '中国科学院沈阳自动化研究院';
        $json = [];
        $source = [];
        $teacher_name = [];
        foreach ($html->find('.nrhei a') as $v) {
            $source[] = $v->href;
            $teacher_name[] = $pub->getRegtext($v->plaintext);
        }

        for ($i = 0; $i < count($source); $i++) {
            $html->clear();
            $html->load_file($source[$i]);
            $td = [];
            foreach ($html->find('#zoom table td[width=450]') as $e) {
                $td[] = $pub->getRegtext($e->plaintext);
            }
            if (!empty($td)) {
                $email = $td[7];
                if (!empty($email)) {
                    $json[] = [
                        'teacher_name' => $teacher_name[$i],
                        'source' => $source[$i],
                        'email' => $email,
                        'create_time' => date('Y-m-d h:i:s', time()),
                        'create_by' => 'ALpython',
                        'type' => '教授',
                        'school_name' => $school_name,
                    ];
                }
            }

        }
//        return $json;
        return $this->_teacherEmailService->batchSave($json);

    }

    /**
     * 南方科技大学
     *
     * @author      刘富胜 2018-10-15
     * @return int 返回类型
     */
    public function getTeacherMail_sustc()
    {
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');

        #region 获取南京理工大学研究生院
        $html = new simple_html_dom();
        $html->load_file($this->Sustc);
        $pub = new public_utf();
        #endregion

        $school_name = '南方科技大学';
        $json = [];
        $email = [];
        $teacher_name = [];
        $type = [];
        foreach ($html->find('.block15 .name') as $v) {
            $teacher_name[] = $pub->getRegtext($v->plaintext);
        }

        foreach ($html->find('.block15 .oth') as $e) {
            if (preg_match($this->PREG, $e->plaintext, $matches)) {
                $email[] = $matches[0];
            }else{
                $email[] = '';
            }
        }

        foreach ($html->find('.block15 .typ') as $t){
            if (strpos($pub->getRegtext($t->plaintext), '教授')) {
                $type[] = '教授';
            } else {
                $type[] = '教师';
            }
        }

        for ($i = 0; $i < count($teacher_name); $i++) {
            if (!empty($email[$i])) {
                $json[] = [
                    'teacher_name' => $teacher_name[$i],
                    'source' => $this->Sustc,
                    'email' => $email[$i],
                    'create_time' => date('Y-m-d h:i:s', time()),
                    'create_by' => 'ALpython',
                    'type' => $type[$i],
                    'school_name' => $school_name,
                ];
            }
        }
        return $this->_teacherEmailService->batchSave($json);
//        return $json;
    }

    /**
     * 递归所有aspx的数据
     *
     * @author      刘富胜 2018-10-10
     * @param string $EVENTVALIDATION
     * @param string $VIEWSTATE
     * @param string $VIEWSTATEENCRYPTED
     * @param string $VIEWSTATEGENERATOR
     * @param int $n
     * @param int $save_count
     * @return int 返回类型
     */
    private function recursionYanzhaoscut($EVENTVALIDATION, $VIEWSTATE, $VIEWSTATEENCRYPTED, $VIEWSTATEGENERATOR, $n = 2, $save_count = 0, $page_count = 1)
    {
        if ($page_count < 21) {
            if ($n < 12) {
                $page = 'lnkPage' . $n;
                if ($n == 11) {
                    $n = 1;
                    $page = 'lnkNextPages';
                    $page_count++;
                }
                $data = [
                    '__EVENTVALIDATION' => $EVENTVALIDATION,
                    '__VIEWSTATE' => $VIEWSTATE,
                    'drpXslb' => 0,
                    'drpNd$drpNd' => 2019,
                    'ScriptManager1' => 'UpdatePanel2|dgData$ctl23$Pager1$' . $page,
                    '__LASTFOCUS' => '',
                    '__EVENTARGUMENT' => '',
                    '__VIEWSTATEENCRYPTED' => $VIEWSTATEENCRYPTED,
                    '__VIEWSTATEGENERATOR' => $VIEWSTATEGENERATOR,
                    '__EVENTTARGET' => 'dgData$ctl23$Pager1$' . $page,
                    '__ASYNCPOST' => true
                ];
                $cookie = public_utf::get_cookie($this->Yanzhaoscut, $data, $this->Yanzhaoscut);
                $header = [
                    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
                    'cookie: ASP.NET_SessionId=qbfuq2pmezhz02cgt3lhheb0; ZS_ZY=ZS_ZY=; DropDownListNd=DropDownListNd=2019; ZS_ND=ZS_ND=2019; ZS_XSLB=ZS_XSLB=0; ZS_XSBH=ZS_XSBH=',
                    'origin: https://yanzhao.scut.edu.cn',
                    'referer: https://yanzhao.scut.edu.cn/open/TutorList.aspx'
                ];
                $content = public_utf::post($this->Yanzhaoscut, http_build_query($data), $cookie, $header);

                $html = new simple_html_dom();
                $html->clear();
                $html->load($content);
                $EVENTVALIDATION = $html->find('#__EVENTVALIDATION')[0]->value;
                $VIEWSTATE = $html->find('#__VIEWSTATE')[0]->value;
                $VIEWSTATEGENERATOR = $html->find('#__VIEWSTATEGENERATOR')[0]->value;
                $VIEWSTATEENCRYPTED = $html->find('#__VIEWSTATEENCRYPTED')[0]->value;
                \Yii::info($content, 'test');
                $source = [];
                foreach ($html->find('#dgData a[target=_blank]') as $v) {
                    $source[] = $v->href;
                }
                $save_count = $save_count + $this->saveAllYanzhaoscut($source);

                $this->recursionYanzhaoscut($EVENTVALIDATION, $VIEWSTATE, $VIEWSTATEENCRYPTED, $VIEWSTATEGENERATOR, $n + 1, $save_count, $page_count);
            }
        }

        return $save_count;
    }

    /**
     * 存取一页的aspx的数据
     *
     * @author      刘富胜 2018-10-10
     * @param array $source
     * @return int 返回类型
     */
    public function saveAllYanzhaoscut($source)
    {
        $html = new simple_html_dom();
        $pub = new public_utf();
        $json = [];
        $root_url = 'https://yanzhao.scut.edu.cn/open/';
        for ($i = 0; $i < count($source); $i++) {
            $html->clear();
            $arr = [];
            try {
                $html->load_file($root_url . $source[$i]);
                foreach ($html->find('.tb_line') as $td) {
                    $arr[] = $pub->getRegtext($td->plaintext);
                }
                $teacher_name = $arr[1];
                $type = $arr[17];
                $email = $arr[23];
                if (!empty($email)) {
                    $json[] = [
                        'teacher_name' => $teacher_name,
                        'source' => $root_url . $source[$i],
                        'email' => $email,
                        'create_time' => date('Y-m-d h:i:s', time()),
                        'create_by' => 'ALpython',
                        'type' => $type,
                        'school_name' => '华南理工大学',
                    ];
                }
            } catch (\Exception $e) {
                continue;
            }

        }
        $count = $this->_teacherEmailService->batchSave($json);
        return $count;
    }

}