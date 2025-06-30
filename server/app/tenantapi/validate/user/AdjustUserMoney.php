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

use app\common\enum\user\AccountLogEnum;
use app\common\model\user\User;
use app\common\validate\BaseValidate;

/**
 * 调整用户钱包验证器
 * Class AdjustUserMoney
 * @package app\tenantapi\validate\user
 */
class AdjustUserMoney extends BaseValidate
{

    protected $rule = [
        'user_id' => 'require',
        'action' => 'require|in:' . AccountLogEnum::INC . ',' .AccountLogEnum::DEC,
        'num' => 'require|gt:0|checkMoney',
        'remark' => 'max:128',
    ];

    protected $message = [
        'id.require' => '请选择用户',
        'action.require' => '请选择调整类型',
        'action.in' => '调整类型错误',
        'num.require' => '请输入调整数量',
        'num.gt' => '调整余额必须大于零',
        'remark' => '备注不可超过128个符号',
    ];


    protected function checkMoney($vaule, $rule, $data)
    {
        $user = User::find($data['user_id']);
        if (empty($user)) {
            return '用户不存在';
        }

        if (1 == $data['action']) {
            return true;
        }

        $surplusMoeny = $user->user_money - $vaule;
        if ($surplusMoeny < 0) {
            return '用户可用余额仅剩' . $user->user_money;
        }

        return true;
    }


}