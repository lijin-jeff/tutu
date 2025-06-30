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
use app\common\model\BaseModel;


/**
 * 退款记录模型
 * Class RefundRecord
 * @package app\common\model\refund
 */
class RefundRecord extends BaseModel
{

    /**
     * @notes 退款类型描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 兔兔答题
     * @date 2022/12/1 10:41
     */
    public function getRefundTypeTextAttr($value, $data)
    {
        return RefundEnum::getTypeDesc($data['refund_type']);
    }


    /**
     * @notes 退款状态描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 兔兔答题
     * @date 2022/12/1 10:44
     */
    public function getRefundStatusTextAttr($value, $data)
    {
        return RefundEnum::getStatusDesc($data['refund_status']);
    }


    /**
     * @notes 退款方式描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 兔兔答题
     * @date 2022/12/6 11:08
     */
    public function getRefundWayTextAttr($value, $data)
    {
        return RefundEnum::getWayDesc($data['refund_way']);
    }

}
