<?php
/**
 * Auto Comment
 *
 * @author http://w3schools.wang [598515020@qq.com]
 * @version v1.0
 */
class comment {
    public $url;
    public $type;
    public $param = array();
    public $post_data = array();

    public function __construct() {
        echo "Start Working ......\n";
    }

    /**
     * 参数初始化
     * @param  [type] $url   [description]
     * @param  array  $param [description]
     * @param  string $type  [description]
     * @return [type]        [description]
     */
    public function init($url, $param = array(), $type = 'typecho') {
        $this->url   = $url;
        $this->type  = $type;
        $this->param = $param;
        $this->post_data = $this->post_data();
    }

    public function typecho_comment() {
        $content = file_get_contents($this->url);

        // 未开启安全验证
        preg_match_all('/action=\"(.*\?\_=[0-9a-zA-Z]{32})/', $content, $unsafe);
        if (!empty($unsafe['1']['0'])) {
            echo "Unsafe! \n";
            $this->param['comment_url'] = trim($unsafe['1']['0']);
        } else {
            echo "Safe! \n";
            // 开启安全验证
            preg_match_all('/input\.value = \(function \(\) \{.*return \_[a-zA-Z0-9]*\;/s', $content, $safe);

            if (!empty($safe['0']['0'])) {
                $pure = array();

                $file = 'seo_tmp_1.txt';
                $handle = fopen($file, 'w');
                fwrite($handle, $safe['0']['0']);
                fclose($handle);

                $handle = fopen($file, 'r');
                if ($handle) {
                    while ( ! feof($handle)) {
                        $pure[] = fgets($handle);
                    }
                }
                fclose($handle);

                $pure_number = count($pure);
                $final = array();
                $tag = '';
                foreach ($pure as $key => $value) {
                    if (($key > 0) && ($key < ($pure_number - 2))) {
                        $final[] = $value;
                    }

                    if ($key == ($pure_number - 1)) {
                        $tag = trim(str_replace(array('return ', ';'), array('', ''), trim($value)));
                    }
                }
                $final[] = $tag;

                $file2 = 'seo_tmp_2.html';
                $handle = fopen($file2, 'a');
                fwrite($handle, '<h1 id="_"></h1><script src="http://www.vfocus.cn/usr/themes/DNSHH-master/js/jquery.js"></script>' . "\n" . '<script type="text/javascript">
            function get(){');
                foreach ($final as $key => $value) {
                    fwrite($handle, $value . "\n");
                }
                fwrite($handle, '$("#_").text(' . $tag . ');}$(document).ready(function(){
                    get();})</script>');
                fclose($handle);


                $_ = shell_exec('python get_.py');
                unlink($file2);
                echo '$_ => ' . $_ . "\n";

                $this->post_data['_'] = trim($_);
                $this->param['comment_url'] = $this->url . '/comment';
            } else {
                echo '~o~';
            }
        }

        $result = $this->curl_url($this->param['comment_url'], $this->post_data);
        var_dump($result);
    }

    /**
     * Post
     */
    public function curl_url($url, $post) {
        print_r($post);
        $options = array (
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => array(
             'Accept: ext/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
             'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36',
             'Connection: Keep-Alive'),
            CURLOPT_REFERER        => $this->url,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $post,
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     *提交内容
     */
    private function post_data() {
        $author = array(
            '傻白甜的红桃皇后',
            '帮我消消黑眼圈',
            '进击的女帝',
            '圣诞老人不在家的驯鹿',
            '尖耳朵的阿凡达妹妹',
            '不和陌生人说话的狐狸爸爸',
            '爱嗑瓜子的猫',
            '我的蜜瓜分你一半',
            '童话里不是骗人的',
            '一闪一闪亮晶晶的钻石女士',
            '不给糖就捣乱的暴走萝莉',
            '吃瓜群众代表',
            '降龙十八掌',
            '暴脾气的小明',
            '大王叫我来巡山',
            '我可不是什么幺蛾子',
            '最后一只恐龙',
            '白天不懂爷的黑',
            '蒙面西楚霸王',
            '快要崩溃的一哥',
            '花粉过敏的花房姑娘',
            '从酋长到球长',
            '不会弹吉他的吉他侠',
            '爱搭积木的粉刷匠',
            '御前侍卫三把刀',
            '闲不住的铁娘子',
            '八块腹肌带你飞',
            '我是赞助商派来的',
            '俺们屯里的音乐大将',
            '爱发呆的红骑士',
            '哎呀我打翻了调色板',
            '冷场王驾到',
            '何必在乎我是谁',
            '人间精品小魔头',
            '火猩哥美猴王',
            '复仇的裁缝',
            '淘气的粉红女王',
            '卡带发型有点乱',
            '水汪汪的大眼睛',
        );
        $text = array(
            '前来拜访，～～～～飘过～～～～～飘过～～～！',
            '持续关注～～～～～～～！',
            '已阅～～～～～～～^_^！',
        );
        $data['author'] = $author[rand(0, count($author) - 1)];
        $data['mail']   = rand(100000000, 999999999) . '@qq.com';
        $data['url']    = 'http://w3schools.wang';
        $data['text']   = $text[rand(0, count($text) - 1)];

        return $data;
    }
}

$url = 'http://youngcn.net/about.html'; // 目标地址（大家测试手下留点情）
$comment_obj = new comment();
$comment_obj->init($url);
$comment_obj->typecho_comment();