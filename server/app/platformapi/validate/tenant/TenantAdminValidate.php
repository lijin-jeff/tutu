<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\platformapi\validate\tenant;


use app\common\model\auth\TenantAdmin;
use app\common\model\tenant\Tenant;
use app\common\validate\BaseValidate;

/**
 * 用户验证
 * Class TenantValidate
 * @package app\platformapi\validate\user
 */
class TenantAdminValidate extends BaseValidate
{

    protected $rule = [
        'id'               => 'require|checkUser',
        'tenant_id'        => 'require|checkTenant',
        'account'          => 'require|length:1,32|checkAccount',
        'name'             => 'require',
        'password'         => 'require|length:6,32|edit',
        'password_confirm' => 'requireWith:password|confirm',
    ];

    protected $message = [
        'id.require'                   => '请选择用户',
        'name.require'                 => '请输入用户名',
        'account.require'              => '请输入账户',
        'account.checkAccount'         => '账号已存在',
        'account.length'               => '账号长度须在1-32位字符',
        'tenant_id.require'            => '请选择对应的租户',
        'password.require'             => '密码不能为空',
        'password.length'              => '密码长度须在6-32位字符',
        'password_confirm.requireWith' => '确认密码不能为空',
        'password_confirm.confirm'     => '两次输入的密码不一致',
    ];


    /**
     * @notes 详情场景
     * @return TenantAdminValidate
     * @author yfdong
     * @date 2024/09/04 22:58
     */
    public function sceneDetail()
    {
        return $this->only(['id', 'tenant_id']);
    }


    /**
     * @notes 租户信息校验
     * @param $value
     * @param $rule
     * @param $data
     * @return string|true
     * @author yfdong
     * @date 2024/09/04 22:57
     */
    public function checkUser($value, $rule, $data)
    {
        $userIds = TenantAdmin::findOrEmpty($value);
        if ($userIds->isEmpty()) {
            return '租户管理员不存在';
        }
        return true;
    }

    public function checkAccount($value, $rule, $data)
    {
        $adminAccount = TenantAdmin::where(['account' => $value, 'tenant_id' => $data['tenant_id']])->findOrEmpty();
        if (!$adminAccount->isEmpty()) {
            return '账号已存在';
        }
        return true;
    }

    /**
     * @notes 检查对应租户号是否存在
     * @param $value
     * @return string|true
     * @author yfdong
     * @date 2024/09/04 22:16
     */
    public function checkTenant($value)
    {
        $adminTenant = Tenant::where(['id' => $value])->findOrEmpty();
        if ($adminTenant->isEmpty()) {
            return '对应租户账号不存在';
        }
        return true;
    }

    /**
     * @notes 添加场景
     * @return TenantAdminValidate
     * @author yfdong
     * @date 2024/09/04 22:57
     */
    public function sceneAdd()
    {
        return $this->remove('id', true);
    }

    /**
     * @notes 修改场景
     * @return TenantAdminValidate
     * @author yfdong
     * @date 2024/09/04 22:57
     */
    public function sceneEdit()
    {
        return $this->remove('password', true)->remove('account', true);
    }

    /**
     * @notes 删除场景
     * @return TenantAdminValidate
     * @author yfdong
     * @date 2024/09/04 22:57
     */
    public function sceneDelete()
    {
        return $this->only(['id']);
    }


    /**
     * @notes 重置密码情形
     * @return TenantAdminValidate
     * @author yfdong
     * @date 2024/09/04 23:29
     */
    public function sceneResetPassword()
    {
        return $this->only(['id']);
    }

    /**
     * @notes 编辑情况下，检查是否填密码
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2021/12/29 10:19
     */
    public function edit($value, $rule, $data)
    {
        if (empty($data['password']) && empty($data['password_confirm'])) {
            return true;
        }
        $len = strlen($value);
        if ($len < 6 || $len > 32) {
            return '密码长度须在6-32位字符';
        }
        return true;
    }
}