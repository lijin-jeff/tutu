<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\validate;

use app\common\enum\PayEnum;
use app\common\service\ConfigService;
use app\common\validate\BaseValidate;

/**
 * 用户验证器
 * Class TenantValidate
 * @package app\shopapi\validate
 */
class RechargeValidate extends BaseValidate
{

    protected $rule = [
        'money' => 'require|gt:0|checkMoney',
    ];


    protected $message = [
        'money.require' => '请填写充值金额',
        'money.gt'      => '请填写大于0的充值金额',
    ];


    public function sceneRecharge(): RechargeValidate
    {
        return $this->only(['money']);
    }


    /**
     * @notes 校验金额
     * @param $money
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2023/2/24 10:42
     */
    protected function checkMoney($money, $rule, $data): bool|string
    {
        $status = ConfigService::get('recharge', 'status', 0);
        if (!$status) {
            return '充值功能已关闭';
        }

        $minAmount = ConfigService::get('recharge', 'min_amount', 0);

        if ($money < $minAmount) {
            return '最低充值金额' . $minAmount . "元";
        }

        return true;
    }

}