<?php
/**
 * 自定义配置
 */
return [

    /*
    |--------------------------------------------------------------------------
    | 七牛云储存配置
    |--------------------------------------------------------------------------
    |
    | 缓存内容 | 文章 , 评论 , ...
    | accessKey secretKey 用于签名的公钥和私钥
    |
    | any other location as required by the application or its packages.
    */
    'qiniu'=>[
        'accessKey'=>'WdOetH7waXVMHc4__xYRDEEi9fdFKyLS8hn0LX2y',
        'secretKey'=>'8Jts4Wg4YREDRT_BMTVyYVxsdfgzKd0p0MffM7y1',
		'imge_bucket'=>'zhuxu',	//图片储存空间名
		'imge_policy'=>[			//上传策略
			'cover'=>[
				"fsizeLimi" => 8388608,     //8MB
				"mimeLimit" => 'image/*'    //类型
			],

		],
    ],

    /*
    |--------------------------------------------------------------------------
    | 文件储存路径
    |--------------------------------------------------------------------------
    | 管理员头像
    | 七牛云
    | bucket 空间名 blog-admin-imge
    | qianzui 上传后文件前缀 array('名称'=>前缀)
    | policy 上传策略
    */
    'imge_admin'=>'blog-admin-imge',
    'imge_admin_photo'=>[
        'bucket'=>'blog-admin-imge',
        'qianzui'=>[
            'dengbi.100.100'=>'0QsOqjj2Ij6yypHNbFhTkoHfga8=/',
        ],
        'policy'=>[
            "persistentOps" => 'imageMogr2/auto-orient/thumbnail/100x100>/blur/1x0/quality/100|imageslim',
            "fsizeLimi" => 8388608,     //8MB
            "mimeLimit" => 'image/*'    //类型
        ],
    ],
];