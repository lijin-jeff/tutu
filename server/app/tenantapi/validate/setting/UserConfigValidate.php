<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\tenantapi\validate\setting;

use app\common\validate\BaseValidate;

/**
 * 用户设置验证
 * Class UserConfigValidate
 * @package app\tenantapi\validate\setting
 */
class UserConfigValidate extends BaseValidate
{

    protected $rule = [
        'login_way'        => 'requireIf:scene,register|array',
        'coerce_mobile'    => 'requireIf:scene,register|in:0,1',
        'login_agreement'  => 'in:0,1',
        'third_auth'       => 'in:0,1',
        'wechat_auth'      => 'in:0,1',
        'default_avatar'   => 'require',
        'default_nickname' => 'require',
    ];


    protected $message = [
        'default_avatar.require'   => '请上传用户默认头像',
        'default_nickname.require' => '请设置用户默认昵称',
        'login_way.requireIf'      => '请选择登录方式',
        'login_way.array'          => '登录方式值错误',
        'coerce_mobile.requireIf'  => '请选择注册强制绑定手机',
        'coerce_mobile.in'         => '注册强制绑定手机值错误',
        'wechat_auth.in'           => '公众号微信授权登录值错误',
        'third_auth.in'            => '第三方登录值错误',
        'login_agreement.in'       => '政策协议值错误',
    ];

    //用户设置验证
    public function sceneUser(): UserConfigValidate
    {
        return $this->only(['default_avatar', 'default_nickname']);
    }

    //注册验证
    public function sceneRegister(): UserConfigValidate
    {
        return $this->only(['login_way', 'coerce_mobile', 'login_agreement', 'third_auth', 'wechat_auth']);
    }
}