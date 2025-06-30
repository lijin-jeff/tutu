<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\common\enum;

class ScoreEnum
{
    const User_REGISTER = 1;


    /**
     * 获取积分名称
     * @param int $scoreType
     * @return string
     */
    public static function ScoreTitle(int $scoreType): string
    {
        switch ($scoreType) {
            case self::User_REGISTER:
                return '注册奖励';
            default:
                return '未知积分';
        }
    }
}