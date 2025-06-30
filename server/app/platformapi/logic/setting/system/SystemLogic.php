<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\logic\setting\system;


use app\common\logic\BaseLogic;

/**
 * Class SystemLogic
 * @package app\platformapi\logic\setting\system
 */
class SystemLogic extends BaseLogic
{

    /**
     * @notes 系统环境信息
     * @return \array[][]
     * @author 兔兔答题
     * @date 2021/12/28 18:35
     */
    public static function getInfo() : array
    {
        $server = [
            ['param' => '服务器操作系统', 'value' => PHP_OS],
            ['param' => 'web服务器环境', 'value' => $_SERVER['SERVER_SOFTWARE']],
            ['param' => 'PHP版本', 'value' => PHP_VERSION],
        ];

        $env = [
            [   'option' => 'PHP版本',
                'require' => '8.0版本以上',
                'status' => (int)compare_php('8.0.0'),
                'remark' => ''
            ]
        ];

        $auth = [
            [
                'dir' => '/runtime',
                'require' => 'runtime目录可写',
                'status' => (int)check_dir_write('runtime'),
                'remark' => ''
            ],
        ];

        return [
            'server' => $server,
            'env' => $env,
            'auth' => $auth,
        ];
    }

}