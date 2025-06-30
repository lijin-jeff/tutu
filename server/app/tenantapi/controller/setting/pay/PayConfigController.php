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
use app\tenantapi\lists\setting\pay\PayConfigLists;
use app\tenantapi\logic\setting\pay\PayConfigLogic;
use app\tenantapi\validate\setting\PayConfigValidate;
use think\response\Json;

/**
 * 支付配置
 * Class PayConfigController
 * @package app\tenantapi\controller\setting\pay
 */
class PayConfigController extends BaseAdminController
{


    /**
     * @notes 设置支付配置
     * @return Json
     * @author 兔兔答题
     * @date 2023/2/23 16:14
     */
    public function setConfig(): Json
    {
        $params = (new PayConfigValidate())->post()->goCheck();
        PayConfigLogic::setConfig($params);
        return $this->success('设置成功', [], 1, 1);
    }


    /**
     * @notes 获取支付配置
     * @return Json
     * @author 兔兔答题
     * @date 2023/2/23 16:14
     */
    public function getConfig(): Json
    {
        $id = (new PayConfigValidate())->goCheck('get');
        $result = PayConfigLogic::getConfig($id);
        return $this->success('获取成功', $result);
    }


    /**
     * @notes
     * @return Json
     * @author 兔兔答题
     * @date 2023/2/23 16:15
     */
    public function lists(): Json
    {
        return $this->dataLists(new PayConfigLists());
    }
}