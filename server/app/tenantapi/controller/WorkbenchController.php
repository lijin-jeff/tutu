<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller;

use app\tenantapi\logic\WorkbenchLogic;

/**
 * 工作台
 * Class WorkbenchCotroller
 * @package app\tenantapi\controller
 */
class WorkbenchController extends BaseAdminController
{

    /**
     * @notes 工作台
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/29 17:01
     */
    public function index(): \think\response\Json
    {
        $result = WorkbenchLogic::index();
        return $this->data($result);
    }
}