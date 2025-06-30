<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\notice;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\logic\notice\SmsConfigLogic;
use app\tenantapi\validate\notice\SmsConfigValidate;

/**
 * 短信配置控制器
 * Class SmsConfigController
 * @package app\tenantapi\controller\notice
 */
class SmsConfigController extends BaseAdminController
{

    /**
     * @notes 获取短信配置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 11:36
     */
    public function getConfig()
    {
        $result = SmsConfigLogic::getConfig();
        return $this->data($result);
    }


    /**
     * @notes 短信配置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 11:36
     */
    public function setConfig()
    {
        $params = (new SmsConfigValidate())->post()->goCheck('setConfig');
        SmsConfigLogic::setConfig($params);
        return $this->success('操作成功',[],1,1);
    }


    /**
     * @notes 查看短信配置详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 11:36
     */
    public function detail()
    {
        $params = (new SmsConfigValidate())->goCheck('detail');
        $result = SmsConfigLogic::detail($params);
        return $this->data($result);
    }

}