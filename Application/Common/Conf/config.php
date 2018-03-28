<?php

return array(
    //开启调试
    'SHOW_PAGE_TRACE' => false,
    //开启SESSION
    'SESSION_AUTO_START' => true,
    //动态载入函数库
    'LOAD_EXT_FILE' => 'functions,xk',
    //自定义加载命名空间
    'AUTOLOAD_NAMESPACE' => array(
        'Lookey' => COMMON_PATH . 'Lookey',
    ),
    //易联云打印配置
    'YLY' => array(
        'ylyname' => 'sanlink',
        'ylyuserid' => '4472',
        'ylyapikey' => '2ea43a0eb8644e2b4f1e1ee67f945cc80c412fcc',
    ),
    //微信配置
    'WX' => array(
        'APP_ID' => 'wx78635201b88d3791',
        'APP_SECRET' => '5688587c6ac0d3d856ca75a1dcd78934',
        'KEY' => 'strder56sdge', //本地加密
        'LOG_PATH' => realpath(LOG_PATH) . '/WeixinLog/', //微信日志记录地址
        'QRCODE_PATH' => __ROOT__ . '/wximg/qrcode', //二维码地址
        'AVARTAR_PATH' => __ROOT__ . '/wximg/avatar', //用户头像地址
        'WXOA_PATH' => __ROOT__ . '/wximg/wxoa', //公众号头像地址
        'POST_PATH' => __ROOT__ . '/wximg/post', //原始海报地址
        'POSTER_PATH' => __ROOT__ . '/wximg/poster', //海报地址
        'CREDENTIALS_PATH' => __ROOT__ . '/wximg/credentials', //证书地址
    ),
    //项目信息加密盐
    'PROJECT_KEY' => '8789weiuhsf',
    //客户信息加密盐
    'CHOOSE_KEY' => '!638WfghM*L',
    //静态文件配置
    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => __ROOT__ . '/Public',
        '__COMMON__' => __ROOT__ . '/Public/common',
    ),
    //数据库连接
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'beat_xk', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '', // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'xk_', // 数据库表前缀
    'DB_CHARSET' => 'utf8', // 数据库编码默认采用utf8
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'REDIS_HOST' => '127.0.0.1',
    //不区分URL大小写
    'URL_CASE_INSENSITIVE' => true,
    //允许列表
    'MODULE_ALLOW_LIST' => array(
        'Home',
        'Saler',
        'User',
        'Account',
        'Api',
        'Admin',
    ),
    'DEFAULT_MODULE' => 'Home',
    //模块设置
    'DEFAULT_MODULE' => 'Home', // 默认模块
    'DEFAULT_CONTROLLER' => 'Index', // 默认控制器名称
    'DEFAULT_ACTION' => 'index', // 默认操作名称
    //模板配置
    'TMPL_TEMPLATE_SUFFIX' => '.html', // 默认模板文件后缀
    'TMPL_FILE_DEPR' => '/', //模板文件CONTROLLER_NAME与ACTION_NAME之间的分割符
    'TMPL_CACHFILE_SUFFIX' => '.php', // 默认模板缓存后缀
    'TMPL_L_DELIM' => '<{', // 模板引擎普通标签开始标记
    'TMPL_R_DELIM' => '}>', // 模板引擎普通标签结束标记
    'TMPL_CACHE_PREFIX' => '', // 模板缓存前缀标识，可以动态改变
    //路由配置
    'URL_MODEL' => 2, // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'URL_PATHINFO_DEPR' => '/', // PATHINFO模式下，各参数之间的分割符号
    'URL_HTML_SUFFIX' => 'html', // URL伪静态后缀设置
    'URL_DENY_SUFFIX' => 'ico|png|gif|jpg', // URL禁止访问的后缀设置
    'URL_PARAMS_BIND' => true, // URL变量绑定到Action方法参数
    'URL_PARAMS_BIND_TYPE' => 0, // URL变量绑定的类型 0 按变量名绑定 1 按变量顺序绑定
    //session周期
    'SESSION_OPTIONS' => array(
        'name' => 'ACCOUNT_ID', //设置session名
        'expire' => 48 * 3600, //SESSION保存2天
        'use_trans_sid' => 1, //跨页传递
        'use_only_cookies' => 0, //是否只开启基于cookies的session的会话方式
    ),
    'ALI_APPKEY' => 'LTAIm5O6hgHs2Jdh', // ali短信KEY
    'ALI_SECRETKEY' => 'rW0AsJlM8N9E7StxjyZAx4cg9k9piV', // ali短信SECRETKEY
    'ALI_SIGNNAME' => '云销控', // ali短信签名
    'ALI_TPCODE_DL' => 'SMS_115750019', // ali短信模板代码
    'ALI_TPCODE_CG' => 'SMS_102185002', // ali短信模板代码
    'WEIXIN_TITLE'  => '微信开盘数据统计',
    'SIGN_PAGE_NUM' => '10',
    'PANTNER_ID'    => '4472',
    'PANTNER_KEY'    => '2ea43a0eb8644e2b4f1e1ee67f945cc80c412fcc'
);
