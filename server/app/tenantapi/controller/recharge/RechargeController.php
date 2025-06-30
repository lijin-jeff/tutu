<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\recharge;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\recharge\RechargeLists;
use app\tenantapi\logic\recharge\RechargeLogic;
use app\tenantapi\validate\recharge\RechargeRefundValidate;

/**
 * 充值控制器
 * Class RechargeController
 * @package app\tenantapi\controller\recharge
 */
class RechargeController extends BaseAdminController
{

    /**
     * @notes 获取充值设置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/22 16:48
     */
    public function getConfig()
    {
        $result = RechargeLogic::getConfig();
        return $this->data($result);
    }


    /**
     * @notes 充值设置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/22 16:48
     */
    public function setConfig()
    {
        $params = $this->request->post();
        $result = RechargeLogic::setConfig($params);
        if($result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(RechargeLogic::getError());
    }


    /**
     * @notes 充值记录
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/24 16:01
     */
    public function lists()
    {
        return $this->dataLists(new RechargeLists());
    }


    /**
     * @notes 退款
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/28 17:29
     */
    public function refund()
    {
        $params = (new RechargeRefundValidate())->post()->goCheck('refund');
        $result = RechargeLogic::refund($params, $this->adminId);
        list($flag, $msg) = $result;
        if(false === $flag) {
            return $this->fail($msg);
        }
        return $this->success($msg, [], 1, 1);
    }


    /**
     * @notes 重新退款
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/28 19:17
     */
    public function refundAgain()
    {
        $params = (new RechargeRefundValidate())->post()->goCheck('again');
        $result = RechargeLogic::refundAgain($params, $this->adminId);
        list($flag, $msg) = $result;
        if(false === $flag) {
            return $this->fail($msg);
        }
        return $this->success($msg, [], 1, 1);
    }

}