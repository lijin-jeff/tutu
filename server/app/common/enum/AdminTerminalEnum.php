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
 * 管理后台登录终端
 * Class terminalEnum
 * @package app\common\enum
 */
class AdminTerminalEnum
{
    const PC = 1;
    const MOBILE = 2;

    const PLATFORM = '__saas__platform__';
    const TENANT = '__saas__tenant__';
    const USER = '__saas__user__';

    /**
     * @notes 是否为租户端
     * @return bool
     * @author JXDN
     * @date 2024/09/04 16:44
     */
    public static function isTenant(): bool
    {
        return request()->source === self::TENANT;
    }

    /**
     * @notes 是否为平台端
     * @return bool
     * @author JXDN
     * @date 2024/09/04 16:44
     */
    public static function isPlatform()
    {
        return request()->source === self::PLATFORM;
    }

    /**
     * @notes 是否为用户端
     * @return bool
     * @author JXDN
     * @date 2024/09/04 16:44
     */
    public static function isUser(): bool
    {
        return request()->source === self::USER;
    }
}