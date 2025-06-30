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
use app\tenantapi\logic\channel\OpenSettingLogic;
use app\tenantapi\validate\channel\OpenSettingValidate;

/**
 * 微信开放平台
 * Class AppSettingController
 * @package app\tenantapi\controller\setting\app
 */
class OpenSettingController extends BaseAdminController
{

    /**
     * @notes 获取微信开放平台设置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 11:03
     */
    public function getConfig()
    {
        $result = OpenSettingLogic::getConfig();
        return $this->data($result);
    }


    /**
     * @notes 微信开放平台设置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 11:03
     */
    public function setConfig()
    {
        $params = (new OpenSettingValidate())->post()->goCheck();
        OpenSettingLogic::setConfig($params);
        return $this->success('操作成功', [], 1, 1);
    }
}