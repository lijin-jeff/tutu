<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\tenantapi\validate\channel;

use app\common\validate\BaseValidate;

/**
 * 开放平台验证
 * Class OpenSettingValidate
 * @package app\tenantapi\validate\channel
 */
class OpenSettingValidate extends BaseValidate
{
    protected $rule = [
        'app_id' => 'require',
        'app_secret' => 'require',
    ];

    protected $message = [
        'app_id.require' => '请输入appId',
        'app_secret.require' => '请输入appSecret',
    ];
}