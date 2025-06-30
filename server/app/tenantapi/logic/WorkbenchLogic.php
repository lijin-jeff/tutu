<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic;


use app\common\logic\BaseLogic;
use app\common\model\recharge\RechargeOrder;
use app\common\model\user\User;
use app\common\service\ConfigService;
use app\common\service\FileService;
use think\db\exception\DbException;


/**
 * 工作台
 * Class WorkbenchLogic
 * @package app\tenantapi\logic
 */
class WorkbenchLogic extends BaseLogic
{
    /**
     * @notes 工作套
     * @param $adminInfo
     * @return array
     * @author 兔兔答题
     * @date 2021/12/29 15:58
     */
    public static function index()
    {
        return [
            // 版本信息
            'version' => self::versionInfo(),
            // 今日数据
            'today'   => self::today(),
            // 常用功能
            'menu'    => self::menu(),
            // 近15日访客数
            'visitor' => self::visitor(),
            // 服务支持
            'support' => self::support(),
            // 销售数据
            'sale'    => self::sale()
        ];
    }


    /**
     * @notes 常用功能
     * @return array[]
     * @author 兔兔答题
     * @date 2021/12/29 16:40
     */
    public static function menu(): array
    {
        return [
            [
                'name'  => '管理员',
                'image' => FileService::getFileUrl(config('project.default_image.menu_admin')),
                'url'   => '/permission/admin'
            ],
            [
                'name'  => '角色管理',
                'image' => FileService::getFileUrl(config('project.default_image.menu_role')),
                'url'   => '/permission/role'
            ],
            [
                'name'  => '部门管理',
                'image' => FileService::getFileUrl(config('project.default_image.menu_dept')),
                'url'   => '/organization/department'
            ],
            [
                'name'  => '字典管理',
                'image' => FileService::getFileUrl(config('project.default_image.menu_dict')),
                'url'   => '/setting/dev_tools/dict'
            ],
            [
                'name'  => '代码生成器',
                'image' => FileService::getFileUrl(config('project.default_image.menu_generator')),
                'url'   => '/setting/dev_tools/code'
            ],
            [
                'name'  => '素材中心',
                'image' => FileService::getFileUrl(config('project.default_image.menu_file')),
                'url'   => '/app/material/index'
            ],
            [
                'name'  => '菜单权限',
                'image' => FileService::getFileUrl(config('project.default_image.menu_auth')),
                'url'   => '/permission/menu'
            ],
            [
                'name'  => '网站信息',
                'image' => FileService::getFileUrl(config('project.default_image.menu_web')),
                'url'   => '/setting/website/information'
            ],
        ];
    }


    /**
     * @notes 版本信息
     * @return array
     * @author 兔兔答题
     * @date 2021/12/29 16:08
     */
    public static function versionInfo(): array
    {
        return [
            'version' => config('project.version'),
            'website' => config('project.website.url'),
            'name'    => ConfigService::get('tenant', 'name'),
            'based'   => 'vue3.x、ElementUI、MySQL',
            'channel' => [
                'website' => 'https://www.tutudati.com',
                'gitee'   => 'https://gitee.com/bruce_qiq',
                'github'  => 'https://gitee.com/bruce_qiq',
            ]
        ];
    }


    /**
     * @notes 今日数据
     * @return int[]
     * @throws DbException
     * @author 兔兔答题
     * @date 2021/12/29 16:15
     */
    public static function today(): array
    {
        return [
            'time'           => date('Y-m-d H:i:s'),
            // 今日销售额
            'today_sales'    => RechargeOrder::query()->where('create_time', '>=', strtotime('today'))->sum('order_amount'),
            // 总销售额
            'total_sales'    => RechargeOrder::query()->sum('order_amount'),

            // 今日访问量
            'today_visitor'  => 10,
            // 总访问量
            'total_visitor'  => 100,

            // 今日新增用户量
            'today_new_user' => User::where('create_time', '>=', strtotime('today'))->count(),
            // 总用户量
            'total_new_user' => User::count(),

            // 订单量 (笔)
            'order_num'      => RechargeOrder::query()->where('create_time', '>=', strtotime('today'))->count(),
            // 总订单量
            'order_sum'      => RechargeOrder::query()->count(),
        ];
    }


    /**
     * @notes 访问数
     * @return array
     * @author 兔兔答题
     * @date 2021/12/29 16:57
     */
    public static function visitor(): array
    {
        $num  = [];
        $date = [];
        for ($i = 0; $i < 15; $i++) {
            $where_start = strtotime("- " . $i . "day");
            $date[]      = date('m/d', $where_start);
            $num[$i]     = rand(0, 100);
        }

        return [
            'date' => $date,
            'list' => [
                ['name' => '访客数', 'data' => $num]
            ]
        ];
    }

    /**
     * @notes 访问数
     * @return array
     * @author 兔兔答题
     * @date 2021/12/29 16:57
     */
    public static function sale(): array
    {
        $num  = [];
        $date = [];
        for ($i = 0; $i < 7; $i++) {
            $where_start = strtotime("- " . $i . "day");
            $date[]      = date('m/d', $where_start);
            $num[$i]     = rand(30, 200);
        }

        return [
            'date' => $date,
            'list' => [
                ['name' => '销售量', 'data' => $num]
            ]
        ];
    }


    /**
     * @notes 服务支持
     * @return array[]
     * @author 兔兔答题
     * @date 2022/7/18 11:18
     */
    public static function support()
    {
        return [
            [
                'image' => FileService::getFileUrl(config('project.default_image.qq_group')),
                'title' => '官方公众号',
                'desc'  => '关注官方公众号',
            ],
            [
                'image' => FileService::getFileUrl(config('project.default_image.customer_service')),
                'title' => '添加企业客服微信',
                'desc'  => '想了解更多请添加客服',
            ]
        ];
    }

}