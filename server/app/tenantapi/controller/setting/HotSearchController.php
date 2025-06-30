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
use app\tenantapi\logic\setting\HotSearchLogic;

/**
 * 热门搜索设置
 * Class HotSearchController
 * @package app\tenantapi\controller\setting
 */
class HotSearchController extends BaseAdminController
{

    /**
     * @notes 获取热门搜索
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/5 19:00
     */
    public function getConfig()
    {
        $result = HotSearchLogic::getConfig();
        return $this->data($result);
    }


    /**
     * @notes 设置热门搜索
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/5 19:00
     */
    public function setConfig()
    {
        $params = $this->request->post();
        $result = HotSearchLogic::setConfig($params);
        if (false === $result) {
            return $this->fail(HotSearchLogic::getError() ?: '系统错误');
        }
        return $this->success('设置成功', [], 1, 1);
    }
}