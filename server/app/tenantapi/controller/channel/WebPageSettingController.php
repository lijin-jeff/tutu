<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\channel;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\logic\channel\WebPageSettingLogic;
use app\tenantapi\validate\channel\WebPageSettingValidate;

/**
 * H5设置控制器
 * Class HFiveSettingController
 * @package app\tenantapi\controller\setting\h5
 */
class WebPageSettingController extends BaseAdminController
{

    /**
     * @notes 获取H5设置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:36
     */
    public function getConfig()
    {
        $result = WebPageSettingLogic::getConfig();
        return $this->data($result);
    }


    /**
     * @notes H5设置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:36
     */
    public function setConfig()
    {
        $params = (new WebPageSettingValidate())->post()->goCheck();
        WebPageSettingLogic::setConfig($params);
        return $this->success('操作成功', [], 1, 1);
    }
}