<?php
return array(
    'site_home' => '首页',
    'nav_topic' => '主题',
    'nav_contribute' => '投稿',
    'guest_name' => '匿名人士',
    'post_is_not_found' => '此文章不存在',
    'topic_is_not_found' => '主题不存在',
    'category_is_not_found' => '分类不存在',
    'cateogry_has_posts' => '该分类下有文章存在，不能直接删除',
    'topic_has_posts' => '该主题下有文章存在，不能直接删除',
        
    /*
     * model User attributeLabels
     */
    'user_email' => '邮箱',
    'user_name' => '名字',
    'password' => '密码',
    'user_state' => '状态',
    'user_token' => '标识',
    'user_disabled' => '禁用',
    'user_enabled' => '启用',
    'user_not_allow_delete' => '不允许删除',
        
    /*
     * model FilterKeyword
     */
    'filter_keyword' => '敏感词',
    'filter_replace' => '替换词',
        
    /*
     * Model Config attributeLabels
     */
    'config_category' => '参数分类',
    'config_nickname' => '参数名称',
    'config_var_name' => '参数变量名',
    'config_value' => '参数值',
    'config_description' => '参数说明',
    'config_name_pattern' => '变量名只能使用字母数字下划线组成，且只能用字母开头，不区分大小写，长度5-100字符',
        
    /*
     * model Post attributeLabels
     */
    'post_type' => '类型',
    'category' => '分类',
    'topic' => '主题',
    'title' => '标题',
    'create_time' => '添加时间',
    'create_ip' => 'IP地址',
    'score' => '评分',
    'score_nums' => '评分次数',
    'comment_nums' => '评论数',
    'digg_nums' => '支持数',
    'visit_nums' => '浏览数',
    'user_id' => '用户ID',
    'source' => '来源',
    'tags' => '标签',
    'state' => '状态',
    'istop' => '置顶',
    'disable_comment' => '禁止评论',
    'recommend' => '推荐',
    'hottest' => '热门',
    'homeshow' => '首页',
    'thumbnail' => '缩略图',
    'summary' => '摘要',
    'content' => '内容',
    'contributor_id' => '投稿者ID',
    'contributor' => '投稿者',
    'contributor_site' => '投稿者网站',
    'contributor_email' => '投稿者邮箱',

    /* Upload model */
    'file_type' => '类型',
    'file_description' => '文件描述',

    /* Topic model */
    'topic_name' => '主题名',
    'post_nums' => '文章数',
    'icon' => '图标',
    'orderid' => '排序ID',
        
    /* Upload model */
    'file_type_picture' => '图片',
    'file_type_file' => '文件',
    'file_type_audio' => '音频',
    'file_type_video' => '视频',
    'file_type_unknown' => '未知',

    /* Category model */
    'category_name' => '分类名',

    /* form model LoginForm */
    'email' => '邮箱',
    'username' => '大名',
    'password' => '密码',
    'remember_me' => '下次自动登录',
    'agreement' => '我已经认真阅读并同意《<a href="{policyurl}" target="_blank">使用协议</a>》。',
    'welcome_signup' => '欢迎加入' . app()->name,
    'autologin' => '下次自动登录&nbsp;|&nbsp;' . l('忘记密码了', url('site/resetpwd')),
    'user_login' => '登录',
    'user_signup' => '注册',
    'username_tip' => '第一印象很重要，起个响亮的名号吧',
    'quick_login_link' => '&gt;&nbsp;已经拥有{sitename}帐号?&nbsp;<a href="{loginurl}">直接登录</a>',
    'quick_signup_link' => '&gt;&nbsp;还没有{sitename}帐号?&nbsp;<a href="{signupurl}">立即注册</a>',
    'user_logout' => '退出',
    'management' => '管理',

    /* Specail model */
    'special_token' => '标识',
    'special_name' => '名称',
    'special_desc' => '描述',

    /* Tag model */
    'tag_name' => '标签名称',
    'tag_posts' => '标签：{name}',
    'tag_posts_page_description' => '与{name}标签相关的文章',

    /*
     * model Comment attributeLabels
     */
    'post_id' => '文章ID',
    'up_nums' => '支持数',
    'down_nums' => '反对数',
    'report_nums' => '举报数',
    'recommend' => '推荐',
    'captcha' => '验证码',
    'refresh_captcha' => '换一张',

    'post_comment' => '发表评论',
    'view_detail' => '查看详情',
    'post_toolbar_text' => '已有{comment_nums}个评论&nbsp;&nbsp;|&nbsp;&nbsp;{score_nums}次评分&nbsp;&nbsp;|&nbsp;&nbsp;{visit}次阅读&nbsp;&nbsp;|&nbsp;&nbsp;{digg}次推荐',
    'post_author_time' => '{author}&nbsp;发表于&nbsp;{time}',
    'post_show_extra' => '{author}&nbsp;发表于&nbsp;{time}&nbsp;|&nbsp;{visit}次阅读&nbsp;{digg}次推荐',
    'comment_list' => '评论列表',
    'hot_comment_list' => '热门评论',
    'have_no_comments' => '当前暂无评论',
    'comment_extra' => '第&nbsp;<b>{floor}</b>&nbsp;楼&nbsp;{author}&nbsp;发表于&nbsp;{time}',
    'reply_comment' => '回复',
    'support_comment' => '支持(<span class="beta-comment-join-nums">{n}</span>)',
    'against_comment' => '反对(<span class="beta-comment-join-nums">{n}</span>)',
    'report_comment' => '举报',
    'comment_quote_title' => '引用%s的评论:',
        
    'comment_top_posts' => '最具争议排行',
    'visit_top_posts' => '最具人气排行',
    'hottest_posts' => '热门排行',
    'latest_posts' => '最新发布',
    'relate_posts' => '相关文章',
    'no_posts' => '暂无文章',
    'recommend_posts' => '编辑推荐',
    'recommend_comments' => '网友精彩点评',
        
    'source_label' => '来源:',
    'tag_label' => '标签:',
    'prev_page_label' => '上一页',
    'next_page_label' => '下一页',
    'this_post_is_disable_comment' => '当前文章已经关闭评论',

    /*
     * layout
     */
    'return_top' => '返回顶部 ^',
    'return_site_home' => '返回网站首页',

    /*
     * post show
     */
    'thanks_contribute' => '感谢{contributor}的投递',

    /*
     * comment create form
     */
    'your_name' => '大名',
    'your_site' => '网站',
    'your_email' => '邮箱',
    'comment_content' => '内容',
    'submit' => '递交',
    'reset' => '重填',
    'close' => '关闭',

    'ajax_send' => '发送数据中...',
    'ajax_fail' => '请求错误.',

    'comment_content_min_length' => '评论内容不能少于{minlength}个字哦～～～',
    'ajax_comment_rules_invalid' => '请输入评论内容和验证码后再发布',
    'ajax_comment_done' => '评论成功.',
    'ajax_comment_error' => '评论失败, %s不正确',

    'thank_your_join' => '感谢您的参与',
    'you_have_joined' => '您已经参与过了，谢谢',
    'operation_error' => '发生系统错误',

    /*
     * post create
     */
    'contribute_post' => '投递文章',
    'contribute_post_success' => '感谢您的投递！',
    'post_title' => '文章标题',
    'post_source' => '文章来源',
    'post_contributor' => '您的大名',
    'post_contributor_site' => '您的网站',
    'post_contributor_email' => '您的邮箱',
    'you_do_not_have_enough_permissions' => '您没有上传文件的权限',
    'post_upload_temp_pictures' => '刚刚上传的图片',
    'continue_contribute' => '再投递一篇',
    'view_contribute_post' => '查看刚才投递的文章',

    /* topic */
    'all_topic_list' => '所有主题列表',
    'topic_posts' => '专题：{name}',
    'topic_posts_page_description' => '与{name}专题相关的文章',

    /* category */
    'category_posts' => '分类：{name}',
    'category_posts_page_description' => '与{name}分类相关的文章',

    /* BetaHottestPosts */
    'special_token_is_null' => 'token不能为空',

    /* site/login */
    'site_login' => '用户登录',
    'site_signup' => '用户注册',
    'please_input_your_email' => '请输入您的email',
    'email_is_exist' => '该email已经被已经',
    'nickname_is_exist'=> '该名字已被人抢了，请换一个吧',
    'please_input_your_password' => '请输入您的密码',
    'please_agree_policy' => '请同意服务条款和协议',
    'please_input_your_nickname' => '请输入您的大名',
    'email_or_password_error' => '邮箱或密码错误',
        
    /* feed */
    'category_feed' => ' 分类目录Feed',
    'topic_feed' => ' 主题目录Feed',

    /* topic/list */
    'all_topics_description' => '所有主题列表',
        
    /* site */
    'site_announce' => '除非特别注明，本站所有文章均不代表本站观点。报道中出现的商标属于其合法持有人。交流时请遵守理性，宽容，换位思考的原则。',
    'site_content_share_announce' => '除非特别声明，本站所有内容遵守<a href="http://creativecommons.org/licenses/by-nc-sa/2.5/" target="_blank">CC Creative Commons License.</a>',
        
    /* error page */
    'site_page_error_tip' => '<h2>该页无法显示</h2><p>出现这个问题，也许是因为您访问了不正确的链接地址，但更可能是由于我们对程序做出了更新，没有即时通知您所造成的。</p>',
);



