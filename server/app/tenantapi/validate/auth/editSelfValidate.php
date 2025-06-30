<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\validate\auth;

use app\common\validate\BaseValidate;
use app\common\model\auth\TenantAdmin;
use think\facade\Config;

/**
 * 编辑超级管理员验证
 * Class editSelfValidate
 * @package app\tenantapi\validate\auth
 */
class editSelfValidate extends BaseValidate
{

    protected $rule = [
        'name' => 'require|length:1,16',
        'avatar' => 'require',
        'password' => 'length:6,32|checkPassword',
        'password_confirm' => 'requireWith:password|confirm',
    ];


    protected $message = [
        'name.require' => '请填写名称',
        'name.length' => '名称须在1-16位字符',
        'avatar.require' => '请选择头像',
        'password_now.length' => '密码长度须在6-32位字符',
        'password_confirm.requireWith' => '确认密码不能为空',
        'password_confirm.confirm' => '两次输入的密码不一致',
    ];


    /**
     * @notes 校验密码
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/4/8 17:40
     */
    public function checkPassword($value, $rule, $data)
    {
        if (empty($data['password_old'])) {
            return '请填写当前密码';
        }

        $admin = TenantAdmin::findOrEmpty($data['admin_id']);
        $passwordSalt = Config::get('project.unique_identification');
        $oldPassword = create_password($data['password_old'], $passwordSalt);

        if ($admin['password'] != $oldPassword) {
            return '当前密码错误';
        }

        return true;
    }

}