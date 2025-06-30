<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\enum\user;

/**
 * 管理后台登录终端
 * Class terminalEnum
 * @package app\common\enum
 */
class UserTerminalEnum
{
    //const OTHER = 0; //其他来源
    const WECHAT_MMP = 1; //微信小程序
    const WECHAT_OA  = 2; //微信公众号
    const H5         = 3;//手机H5登录
    const PC         = 4;//电脑PC
    const IOS        = 5;//苹果app
    const ANDROID    = 6;//安卓app


    const ALL_TERMINAL = [
        self::WECHAT_MMP,
        self::WECHAT_OA,
        self::H5,
        self::PC,
        self::IOS,
        self::ANDROID,
    ];

    /**
     * @notes 获取终端
     * @param bool $from
     * @return array|mixed|string
     * @author cjhao
     * @date 2021/7/30 18:09
     */
    public static function getTermInalDesc($from = true)
    {
        $desc = [
            self::WECHAT_MMP    => '微信小程序',
            self::WECHAT_OA     => '微信公众号',
            self::H5            => '手机H5',
            self::PC            => '电脑PC',
            self::IOS           => '苹果APP',
            self::ANDROID       => '安卓APP',
        ];
        if(true === $from){
            return $desc;
        }
        return $desc[$from] ?? '';
    }
}