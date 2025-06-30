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
class UserEnum
{

    /**
     * 性别
     * SEX_OTHER = 未知
     * SEX_MEN =  男
     * SEX_WOMAN = 女
     */
    const SEX_OTHER = 0;
    const SEX_MEN = 1;
    const SEX_WOMAN = 2;


    /**
     * @notes 性别描述
     * @param bool $from
     * @return string|string[]
     * @author 兔兔答题
     * @date 2022/9/7 15:05
     */
    public static function getSexDesc($from = true)
    {
        $desc = [
            self::SEX_OTHER => '未知',
            self::SEX_MEN => '男',
            self::SEX_WOMAN => '女',
        ];
        if (true === $from) {
            return $desc;
        }
        return $desc[$from] ?? '';
    }
}