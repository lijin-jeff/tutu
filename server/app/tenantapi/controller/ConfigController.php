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

use app\tenantapi\logic\auth\AuthLogic;
use app\tenantapi\logic\ConfigLogic;

/**
 * 配置控制器
 * Class ConfigController
 * @package app\tenantapi\controller
 */
class ConfigController extends BaseAdminController
{
    public array $notNeedLogin = ['getConfig', 'dict'];


    /**
     * @notes 基础配置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/31 11:01
     */
    public function getConfig(): \think\response\Json
    {
        $data = ConfigLogic::getConfig();
        return $this->data($data);
    }


    /**
     * @notes 根据类型获取字典数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/27 19:10
     */
    public function dict(): \think\response\Json
    {
        $type = $this->request->get('type', '');
        $data = ConfigLogic::getDictByType($type);
        return $this->data($data);
    }



}