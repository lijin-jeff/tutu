<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\finance;


use app\common\enum\RefundEnum;
use app\common\logic\BaseLogic;
use app\common\model\refund\RefundLog;
use app\common\model\refund\RefundRecord;


/**
 * 退款
 * Class RefundLogic
 * @package app\tenantapi\logic\finance
 */
class RefundLogic extends BaseLogic
{

    /**
     * @notes 退款统计
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/3/3 12:09
     */
    public static function stat()
    {
        $records = RefundRecord::select()->toArray();

        $total = 0;
        $ing = 0;
        $success = 0;
        $error = 0;

        foreach ($records as $record) {
            $total += $record['order_amount'];
            switch ($record['refund_status']) {
                case RefundEnum::REFUND_ING:
                    $ing += $record['order_amount'];
                    break;
                case RefundEnum::REFUND_SUCCESS:
                    $success += $record['order_amount'];
                    break;
                case RefundEnum::REFUND_ERROR:
                    $error += $record['order_amount'];
                    break;
            }
        }

        return [
            'total' => round($total, 2),
            'ing' => round($ing, 2),
            'success' => round($success, 2),
            'error' => round($error, 2),
        ];
    }


    /**
     * @notes 退款日志
     * @param $recordId
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/3/3 14:25
     */
    public static function refundLog($recordId)
    {
        return (new RefundLog())
            ->order(['id' => 'desc'])
            ->where('record_id', $recordId)
            ->hidden(['refund_msg'])
            ->append(['handler', 'refund_status_text'])
            ->select()
            ->toArray();
    }

}