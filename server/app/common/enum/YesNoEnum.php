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
 * 通过枚举类，枚举只有两个值的时候使用
 * Class YesNoEnum
 * @package app\common\enum
 */
class YesNoEnum
{
    const YES = 1;
    const NO = 0;

    /**
     * @notes 获取禁用状态
     * @param bool $value
     * @return string|string[]
     * @author 令狐冲
     * @date 2021/7/8 19:02
     */
    public static function getDisableDesc($value = true)
    {
        $data = [
            self::YES => '禁用',
            self::NO => '正常'
        ];
        if ($value === true) {
            return $data;
        }
        return $data[$value];
    }
}