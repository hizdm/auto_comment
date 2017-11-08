# 评论灌水机器人v1.0

------

1. 本程序实现了开源博客（typecho）的自动评论，使用php与python共同实现（使用python也可完全实现）。

2. 本程序仅用于学习研究。

3. 使用时请确保 **当前目录具有写权限**。

目标配置：

```php
$url = 'http://youngcn.net/about.html'; // 目标地址（大家测试手下留点情）
$comment_obj = new comment();
$comment_obj->init($url);
$comment_obj->typecho_comment();
```
评论配置：

```php
private function post_data() {
        $author = array(
            '傻白甜的红桃皇后',
            '帮我消消黑眼圈',
            '进击的女帝',
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
```

------