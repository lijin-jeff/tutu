<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\tenantapi\validate\user;


use app\common\model\user\User;
use app\common\validate\BaseValidate;

/**
 * 用户验证
 * Class TenantValidate
 * @package app\tenantapi\validate\user
 */
class UserValidate extends BaseValidate
{

    protected $rule = [
        'id'    => 'require|checkUser',
        'field' => 'require|checkField',
        'value' => 'require',
        //        'tenant_id' => 'require',
    ];

    protected $message = [
        'id.require'    => '请选择用户',
        'field.require' => '请选择操作',
        'value.require' => '请输入内容',
        //        'tenant_id.require' => '请选择租户标识',
    ];


    /**
     * @notes 详情场景
     * @return UserValidate
     * @author 兔兔答题
     * @date 2022/9/22 16:35
     */
    public function sceneDetail()
    {
        return $this->only(['id']);
    }


    /**
     * @notes 用户信息校验
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/22 17:03
     */
    public function checkUser($value, $rule, $data)
    {
        $userIds = is_array($value) ? $value : [$value];

        foreach ($userIds as $item) {
            if (!User::find($item)) {
                return '用户不存在！';
            }
        }
        return true;
    }

    /**
     * @notes 校验平台端查询用户信息的情况
     * @param $value
     * @param $rule
     * @param $data
     * @return UserValidate
     * @author yfdong
     * @date 2024/09/04 23:46
     */
    public function sceneManager()
    {
        return $this->only(['tenant_id']);
    }


    /**
     * @notes 校验是否可更新信息
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/9/22 16:37
     */
    public function checkField($value, $rule, $data): bool|string
    {
        $allowField = ['account', 'sex', 'mobile', 'real_name'];

        if (!in_array($value, $allowField)) {
            return '用户信息不允许更新';
        }

        switch ($value) {
            case 'account':
                //验证手机号码是否存在
                $account = User::where([
                    ['id', '<>', $data['id']],
                    ['account', '=', $data['value']]
                ])->findOrEmpty();

                if (!$account->isEmpty()) {
                    return '账号已被使用';
                }
                break;

            case 'mobile':
                if (false == $this->validate($data['value'], 'mobile', $data)) {
                    return '手机号码格式错误';
                }

                //验证手机号码是否存在
                $mobile = User::where([
                    ['id', '<>', $data['id']],
                    ['mobile', '=', $data['value']]
                ])->findOrEmpty();

                if (!$mobile->isEmpty()) {
                    return '手机号码已存在';
                }
                break;
        }
        return true;
    }


}