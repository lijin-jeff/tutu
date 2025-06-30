<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\setting;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\logic\setting\CustomerServiceLogic;

/**
 * 客服设置
 * Class CustomerServiceController
 * @package app\tenantapi\controller\setting
 */
class CustomerServiceController extends BaseAdminController
{
    /**
     * @notes 获取客服设置
     * @return \think\response\Json
     * @author ljj
     * @date 2022/2/15 12:05 下午
     */
    public function getConfig()
    {
        $result = CustomerServiceLogic::getConfig();
        return $this->data($result);
    }

    /**
     * @notes 设置客服设置
     * @return \think\response\Json
     * @author ljj
     * @date 2022/2/15 12:11 下午
     */
    public function setConfig()
    {
        $params = $this->request->post();
        CustomerServiceLogic::setConfig($params);
        return $this->success('设置成功', [], 1, 1);
    }
}