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
 * 登录枚举
 * Class LoginEnum
 * @package app\common\enum
 */
class LoginEnum
{
    /**
     * 支持的登录方式
     * ACCOUNT_PASSWORD 账号/手机号密码登录
     * MOBILE_CAPTCHA 手机验证码登录
     * THIRD_LOGIN 第三方登录
     */
    const ACCOUNT_PASSWORD = 1;
    const MOBILE_CAPTCHA = 2;
    const THIRD_LOGIN = 3;
}