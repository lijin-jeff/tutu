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
use app\common\validate\BaseValidate;

/**
 * 支付验证
 * Class PayValidate
 * @package app\api\validate
 */
class PayValidate extends BaseValidate
{
    protected $rule = [
        'from'     => 'require',
        'pay_way'  => 'require|in:' . PayEnum::BALANCE_PAY . ',' . PayEnum::WECHAT_PAY . ',' . PayEnum::ALI_PAY,
        'order_id' => 'require'
    ];


    protected $message = [
        'from.require'     => '参数缺失',
        'pay_way.require'  => '支付方式参数缺失',
        'pay_way.in'       => '支付方式参数错误',
        'order_id.require' => '订单参数缺失'
    ];


    /**
     * @notes 支付方式场景
     * @return PayValidate
     * @author 兔兔答题
     * @date 2023/2/24 17:43
     */
    public function scenePayway(): PayValidate
    {
        return $this->only(['from', 'order_id']);
    }


    /**
     * @notes 支付状态
     * @return PayValidate
     * @author 兔兔答题
     * @date 2023/3/1 16:17
     */
    public function sceneStatus(): PayValidate
    {
        return $this->only(['from', 'order_id']);
    }


}