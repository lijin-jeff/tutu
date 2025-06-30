<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\common\enum;


/**
 * 支付
 * Class PayrEnum
 * @package app\common\enum
 */
class PayEnum
{

    //支付类型
    const BALANCE_PAY = 1; //余额支付
    const WECHAT_PAY = 2; //微信支付
    const ALI_PAY = 3; //支付宝支付


    //支付状态
    const UNPAID = 0; //未支付
    const ISPAID = 1; //已支付


    //支付场景
    const SCENE_H5 = 1;//H5
    const SCENE_OA = 2;//微信公众号
    const SCENE_MNP = 3;//微信小程序
    const SCENE_APP = 4;//APP
    const SCENE_PC = 5;//PC商城


    /**
     * @notes 获取支付类型
     * @param bool $value
     * @return string|string[]
     * @author 兔兔答题
     * @date 2023/2/23 15:36
     */
    public static function getPayDesc($value = true)
    {
        $data = [
            self::BALANCE_PAY => '余额支付',
            self::WECHAT_PAY  => '微信支付',
            self::ALI_PAY     => '支付宝支付',
        ];
        if ($value === true) {
            return $data;
        }
        return $data[$value] ?? '';
    }


    /**
     * @notes 支付状态
     * @param bool $value
     * @return string|string[]
     * @author 兔兔答题
     * @date 2023/2/23 15:36
     */
    public static function getPayStatusDesc($value = true)
    {
        $data = [
            self::UNPAID => '未支付',
            self::ISPAID => '已支付',
        ];
        if ($value === true) {
            return $data;
        }
        return $data[$value] ?? '';
    }


    /**
     * @notes 支付场景
     * @param bool $value
     * @return string|string[]
     * @author 兔兔答题
     * @date 2023/2/23 15:36
     */
    public static function getPaySceneDesc($value = true)
    {
        $data = [
            self::SCENE_H5  => 'H5',
            self::SCENE_OA  => '微信公众号',
            self::SCENE_MNP => '微信小程序',
            self::SCENE_APP => 'APP',
            self::SCENE_PC  => 'PC',
        ];
        if ($value === true) {
            return $data;
        }
        return $data[$value] ?? '';
    }


}