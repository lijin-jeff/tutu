<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\logic;

use app\common\enum\PayEnum;
use app\common\logic\BaseLogic;
use app\common\model\recharge\RechargeOrder;
use app\common\model\user\User;
use app\common\service\ConfigService;


/**
 * 充值逻辑层
 * Class RechargeLogic
 * @package app\shopapi\logic
 */
class RechargeLogic extends BaseLogic
{

    /**
     * @notes 充值
     * @param array $params
     * @return array|false
     * @author 兔兔答题
     * @date 2023/2/24 10:43
     */
    public static function recharge(array $params): bool|array
    {
        try {
            $data = [
                'sn'             => generate_sn(RechargeOrder::class, 'sn'),
                'order_terminal' => $params['terminal'],
                'user_id'        => $params['user_id'],
                'tenant_id'      => $params['tenant_id'],
                'pay_status'     => PayEnum::UNPAID,
                'order_amount'   => $params['money'],
                'order_title'    => '订单充值'
            ];
            $order = RechargeOrder::create($data);
            return [
                'order_id' => (int)$order['id'],
                'from'     => 'recharge'
            ];
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 充值配置
     * @param $userId
     * @return array
     * @author 兔兔答题
     * @date 2023/2/24 16:56
     */
    public static function config($userId)
    {
        $userMoney = User::where(['id' => $userId])->value('user_money');
        $minAmount = ConfigService::get('recharge', 'min_amount', 0);
        $status = ConfigService::get('recharge', 'status', 0);

        return [
            'status'     => $status,
            'min_amount' => $minAmount,
            'user_money' => $userMoney,
        ];
    }


}