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
 * H5设置验证器
 * Class HFiveSettingValidate
 * @package app\tenantapi\validate\setting\h5
 */
class WebPageSettingValidate extends BaseValidate
{
    protected $rule = [
        'status' => 'require|in:0,1'
    ];

    protected $message = [
        'status.require' => '请选择启用状态',
        'status.in' => '启用状态值有误',
    ];
}