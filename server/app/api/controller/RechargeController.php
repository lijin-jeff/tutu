<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\api\controller;

use app\api\lists\recharge\RechargeLists;
use app\api\logic\RechargeLogic;
use app\api\validate\CommonValidate;
use app\api\validate\RechargeValidate;


/**
 * 充值控制器
 * Class RechargeController
 * @package app\shopapi\controller
 */
class RechargeController extends BaseApiController
{

    /**
     * @notes 获取充值列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/23 18:55
     */
    public function lists(): \think\response\Json
    {
        (new CommonValidate())->get()->goCheck('page');
        return $this->dataLists(new RechargeLists());
    }


    /**
     * @notes 充值
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/23 18:56
     */
    public function recharge(): \think\response\Json
    {
        $params = (new RechargeValidate())->post()->goCheck('recharge', [
            'user_id'   => $this->userId,
            'terminal'  => $this->userInfo['terminal'],
            'tenant_id' => $this->userInfo['tenant_id'],
        ]);
        $result = RechargeLogic::recharge($params);
        if (false === $result) {
            return $this->fail(RechargeLogic::getError());
        }
        return $this->data($result);
    }


    /**
     * @notes 充值配置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/24 16:56
     */
    public function config(): \think\response\Json
    {
        return $this->data(RechargeLogic::config($this->userId));
    }


}