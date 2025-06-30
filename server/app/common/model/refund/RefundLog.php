<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\model\refund;


use app\common\enum\RefundEnum;
use app\common\model\auth\Admin;
use app\common\model\BaseModel;


/**
 * 退款日志模型
 * Class RefundLog
 * @package app\common\model\refund
 */
class RefundLog extends BaseModel
{

    /**
     * @notes 操作人描述
     * @param $value
     * @param $data
     * @return mixed
     * @author 兔兔答题
     * @date 2022/12/1 10:55
     */
    public function getHandlerAttr($value, $data)
    {
        return Admin::where('id', $data['handle_id'])->value('name');
    }


    /**
     * @notes 退款状态描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 兔兔答题
     * @date 2022/12/1 10:55
     */
    public function getRefundStatusTextAttr($value, $data)
    {
        return RefundEnum::getStatusDesc($data['refund_status']);
    }

}
