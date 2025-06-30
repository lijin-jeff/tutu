<?php
// +----------------------------------------------------------------------
// | 兔兔答题开发团队介绍
// +----------------------------------------------------------------------
// | 欢迎你使用本套系统，本套系统由兔兔答题开发团队全力开发。
// | 如果本套系统是商业系统，请严格遵守系统使用相关协议，出现违背协议的法律行为，所有违法行为均与兔兔答题无关。
// | 官网地址：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题团队 版权所有 拥有最终解释权
// +----------------------------------------------------------------------
// | 作者: 兔兔答题开发团队
// +----------------------------------------------------------------------
namespace app\common\enum;

class OrderEnum
{
    const ORDER_RECHARGE = 1; //充值订单

    const ORDER_EXAM = 2; // 试题订单

    const ORDER_COURSE = 3; // 课程订单

    const ORDER_SHOP = 4; // 商城订单

    public static function getPayDesc($value = true)
    {
        $data = [
            self::ORDER_RECHARGE => '钱包充值',
            self::ORDER_EXAM     => '题库购买',
            self::ORDER_COURSE   => '课程购买',
            self::ORDER_SHOP     => '商城购买',
        ];
        if ($value === true) {
            return $data;
        }
        return $data[$value] ?? '';
    }
}