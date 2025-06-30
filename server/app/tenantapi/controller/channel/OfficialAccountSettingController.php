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
use app\tenantapi\logic\channel\OfficialAccountSettingLogic;
use app\tenantapi\validate\channel\OfficialAccountSettingValidate;

/**
 * 公众号设置
 * Class OfficialAccountSettingController
 * @package app\tenantapi\controller\channel
 */
class OfficialAccountSettingController extends BaseAdminController
{
    /**
     * @notes 获取公众号配置
     * @return \think\response\Json
     * @author ljj
     * @date 2022/2/16 10:09 上午
     */
    public function getConfig()
    {
        $result = (new OfficialAccountSettingLogic())->getConfig();
        return $this->data($result);
    }

    /**
     * @notes 设置公众号配置
     * @return \think\response\Json
     * @author ljj
     * @date 2022/2/16 10:09 上午
     */
    public function setConfig()
    {
        $params = (new OfficialAccountSettingValidate())->post()->goCheck();
        (new OfficialAccountSettingLogic())->setConfig($params);
        return $this->success('操作成功',[],1,1);
    }
}