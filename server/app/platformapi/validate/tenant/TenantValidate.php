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


use app\common\model\tenant\Tenant;
use app\common\validate\BaseValidate;

/**
 * 用户验证
 * Class TenantValidate
 * @package app\platformapi\validate\user
 */
class TenantValidate extends BaseValidate
{

    protected $rule = [
        'id'   => 'require|checkUser',
        'name' => 'require',
        'domain_alias' => 'checkDomainAlias'
    ];

    protected $message = [
        'id.require'   => '请选择用户',
        'name.require' => '请输入用户名',
    ];


    /**
     * @notes 详情场景
     * @return TenantValidate
     * @author 兔兔答题
     * @date 2022/9/22 16:35
     */
    public function sceneDetail()
    {
        return $this->only(['id']);
    }


    /**
     * @notes 租户信息校验
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/9/22 17:03
     */
    public function checkUser($value, $rule, $data)
    {
        $userIds = Tenant::findOrEmpty($value);
        if ($userIds->isEmpty()) {
            return '租户不存在';
        }
        return true;
    }

    /**
     * @notes 域名校验
     * @param $value
     * @param $rule
     * @param $data
     * @return string|true
     * @author JXDN
     * @date 2024/09/11 15:30
     */
    public function checkDomainAlias($value, $rule, $data)
    {
        $tenant = Tenant::where(['domain_alias' => $value])->findOrEmpty();
        if (!$tenant->isEmpty()) {
            return '租户别名已存在';
        }
        return true;
    }

    /**
     * @notes 域名校验
     * @param $value
     * @param $rule
     * @param $data
     * @return string|true
     * @author JXDN
     * @date 2024/09/11 15:30
     */
    public function checkDomainAliasEdit($value, $rule, $data)
    {
        $tenant = Tenant::where('domain_alias', $value)
            ->where('id', '<>', $data['id']) // 排除当前租户
            ->findOrEmpty();
        if (!$tenant->isEmpty()) {
            return '租户别名已存在';
        }
        return true;
    }


    /**
     * @notes 添加场景
     * @return TenantValidate
     * @author 兔兔答题
     * @date 2022/5/25 18:16
     */
    public function sceneAdd()
    {
        return $this->remove('id', true);
    }

    /**
     * @notes 编辑场景
     * @return TenantValidate
     * @author JXDN
     * @date 2024/09/11 15:31
     */
    public function sceneEdit()
    {
        return $this->only(['id', 'name'])->append('domain_alias', 'checkDomainAliasEdit');
    }

    /**
     * @notes 删除场景
     * @return TenantValidate
     * @author 兔兔答题
     * @date 2022/5/25 18:16
     */
    public function sceneDelete()
    {
        return $this->only(['id']);
    }
}