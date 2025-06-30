<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\setting\web;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\logic\setting\web\WebSettingLogic;
use app\tenantapi\validate\setting\WebSettingValidate;

/**
 * 网站设置
 * Class WebSettingController
 * @package app\tenantapi\controller\setting
 */
class WebSettingController extends BaseAdminController
{

    /**
     * @notes 获取网站信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/28 15:44
     */
    public function getWebsite(): \think\response\Json
    {
        $result = WebSettingLogic::getWebsiteInfo();
        return $this->data($result);
    }


    /**
     * @notes 设置网站信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/28 15:45
     */
    public function setWebsite(): \think\response\Json
    {
        $params = (new WebSettingValidate())->post()->goCheck('website');
        WebSettingLogic::setWebsiteInfo($params);
        return $this->success('设置成功', [], 1, 1);
    }



    /**
     * @notes 获取备案信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/28 16:10
     */
    public function getCopyright(): \think\response\Json
    {
        $result = WebSettingLogic::getCopyright();
        return $this->data($result);
    }


    /**
     * @notes 设置备案信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/28 16:10
     */
    public function setCopyright(): \think\response\Json
    {
        $params = $this->request->post();
        $result = WebSettingLogic::setCopyright($params);
        if (false === $result) {
            return $this->fail(WebSettingLogic::getError() ?: '操作失败');
        }
        return $this->success('设置成功', [], 1, 1);
    }


    /**
     * @notes 设置政策协议
     * @return \think\response\Json
     * @author ljj
     * @date 2022/2/15 11:00 上午
     */
    public function setAgreement(): \think\response\Json
    {
        $params = $this->request->post();
        WebSettingLogic::setAgreement($params);
        return $this->success('设置成功', [], 1, 1);
    }


    /**
     * @notes 获取政策协议
     * @return \think\response\Json
     * @author ljj
     * @date 2022/2/15 11:16 上午
     */
    public function getAgreement(): \think\response\Json
    {
        $result = WebSettingLogic::getAgreement();
        return $this->data($result);
    }

    /**
     * @notes 获取站点统计配置
     * @return \think\response\Json
     * @author yfdong
     * @date 2024/09/20 22:24
     */
    public function getSiteStatistics()
    {
        $result = WebSettingLogic::getSiteStatistics();
        return $this->data($result);
    }

    /**
     * @notes 获取站点统计配置
     * @return \think\response\Json
     * @author yfdong
     * @date 2024/09/20 22:51
     */
    public function setSiteStatistics()
    {
        $params = (new WebSettingValidate())->post()->goCheck('siteStatistics');
        WebSettingLogic::setSiteStatistics($params);
        return $this->success('设置成功', [], 1, 1);
    }
}