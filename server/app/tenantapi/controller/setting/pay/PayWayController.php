<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\setting\pay;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\logic\setting\pay\PayWayLogic;


/**
 * 支付方式
 * Class PayWayController
 * @package app\tenantapi\controller\setting\pay
 */
class PayWayController extends BaseAdminController
{

    /**
     * @notes 获取支付方式
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/2/23 16:27
     */
    public function getPayWay()
    {
        $result = PayWayLogic::getPayWay();
        return $this->success('获取成功',$result);
    }


    /**
     * @notes 设置支付方式
     * @return \think\response\Json
     * @throws \Exception
     * @author 兔兔答题
     * @date 2023/2/23 16:27
     */
    public function setPayWay()
    {
        $params = $this->request->post();
        $result = (new PayWayLogic())->setPayWay($params);
        if (true !== $result) {
            return $this->fail($result);
        }
        return $this->success('操作成功',[],1, 1);
    }
}