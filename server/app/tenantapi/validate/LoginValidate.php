<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\tenantapi\validate;


use app\common\enum\AdminTerminalEnum;
use app\common\model\auth\TenantAdmin;
use app\common\cache\AdminAccountSafeCache;
use app\common\service\ConfigService;
use app\common\validate\BaseValidate;
use think\facade\Config;

/**
 * 登录验证
 * Class LoginValidate
 * @package app\tenantapi\validate
 */
class LoginValidate extends BaseValidate
{
    protected $rule = [
        'terminal' => 'require|in:' . AdminTerminalEnum::PC . ',' . AdminTerminalEnum::MOBILE,
        'account'  => 'require',
        'password' => 'require|password',
    ];

    protected $message = [
        'account.require'  => '请输入账号',
        'password.require' => '请输入密码'
    ];

    /**
     * @notes @notes 密码验证
     * @param $password
     * @param $other
     * @param $data
     * @return bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 令狐冲
     * @date 2021/7/2 14:00
     */
    public function password($password, $other, $data)
    {
        // 登录限制
        $config = [
            'login_restrictions'   => ConfigService::get('admin_login', 'login_restrictions'),
            'password_error_times' => ConfigService::get('admin_login', 'password_error_times'),
            'limit_login_time'     => ConfigService::get('admin_login', 'limit_login_time'),
        ];

        $adminAccountSafeCache = new AdminAccountSafeCache();
        if ($config['login_restrictions'] == 1) {
            $adminAccountSafeCache->count = $config['password_error_times'];
            $adminAccountSafeCache->minute = $config['limit_login_time'];
        }

        //后台账号安全机制，连续输错后锁定，防止账号密码暴力破解
        if ($config['login_restrictions'] == 1 && !$adminAccountSafeCache->isSafe()) {
            return '密码连续' . $adminAccountSafeCache->count . '次输入错误，请' . $adminAccountSafeCache->minute . '分钟后重试';
        }

        $adminInfo = TenantAdmin::where(['account' => $data['account'], 'tenant_id' => $this->request->tenantId])
            ->field(['password,disable'])
            ->findOrEmpty();

        if ($adminInfo->isEmpty()) {
            return '账号不存在';
        }

        if ($adminInfo['disable'] === 1) {
            return '账号已禁用';
        }

        if (empty($adminInfo['password'])) {
            $adminAccountSafeCache->record();
            return '账号不存在';
        }

        $passwordSalt = Config::get('project.unique_identification');
        if ($adminInfo['password'] !== create_password($password, $passwordSalt)) {
            $adminAccountSafeCache->record();
            return '密码错误';
        }

        $adminAccountSafeCache->relieve();
        return true;
    }

}