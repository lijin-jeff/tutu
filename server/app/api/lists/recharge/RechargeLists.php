<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\lists\recharge;

use app\api\lists\BaseApiDataLists;
use app\common\enum\OrderEnum;
use app\common\enum\PayEnum;
use app\common\model\recharge\RechargeOrder;


/**
 * 充值记录列表
 * Class RechargeLists
 * @package app\api\lists\recharge
 */
class RechargeLists extends BaseApiDataLists
{

    private function setQueryWhere()
    {
        return function ($query) {
            $params = request()->all();
            $orderStatus = empty($params['order_status']) ? 0 : (int)$params['order_status'];
            if ($orderStatus === 1) {// 待付款
                $query->where('pay_status', '=', 0);
            } else if ($orderStatus === 2) {// 已完成
                $query->where('pay_status', '=', 1);
            } else if ($orderStatus === 3) {// 已退款
                $query->where([
                    ['pay_status', '=', 1],
                    ['refund_status', '=', 1],
                ]);
            } else if ($orderStatus === 4) {
                $query->where([
                    ['evaluate_status', '=', 1]
                ]);
            }
        };
    }

    /**
     * @notes 获取列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/2/23 18:43
     */
    public function lists(): array
    {
        $lists = RechargeOrder::field('order_amount,create_time,order_type,order_count,order_title,pay_status,refund_status,sn,evaluate_status')
            ->where([
                'user_id' => $this->userId,
            ])
            ->where($this->setQueryWhere())
            ->order('id', 'desc')
            ->select()
            ->toArray();

        foreach ($lists as &$item) {
            $item['order_time'] = $item['create_time'];
            $item['order_type_text'] = OrderEnum::getPayDesc((int)$item['order_type']);
            $item['order_status'] = PayEnum::getPayStatusDesc((int)$item['pay_status']);
            $item['order_button_text'] = '再次购买';
            if ($item['pay_status'] == 0) {
                $item['order_button_text'] = '立即支付';
            } elseif ($item['refund_status'] == 1) {
                $item['order_button_text'] = '订单已退款';
            } else if ($item['pay_status'] == 1 && $item['refund_status'] == 0 && $item['evaluate_status'] == 0) {
                $item['order_button_text'] = '订单评价';
            }
            $item['tips'] = '充值' . format_amount($item['order_amount']) . '元';
            unset($item['create_time']);
        }

        return $lists;
    }


    /**
     * @notes  获取数量
     * @return int
     * @author 兔兔答题
     * @date 2023/2/23 18:43
     */
    public function count(): int
    {
        return RechargeOrder::where([
            'user_id' => $this->userId,
        ])->where($this->setQueryWhere())
            ->count();
    }

}