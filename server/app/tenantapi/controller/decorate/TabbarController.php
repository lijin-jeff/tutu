<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\tenantapi\controller\decorate;


use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\logic\decorate\DecorateTabbarLogic;

/**
 * 装修-底部导航
 * Class DecorateTabbarController
 * @package app\tenantapi\controller\decorate
 */
class TabbarController extends BaseAdminController
{

    /**
     * @notes 底部导航详情
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/7 16:39
     */
    public function detail()
    {
        $data = DecorateTabbarLogic::detail();
        return $this->success('', $data);
    }


    /**
     * @notes 底部导航保存
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/6 9:58
     */
    public function save()
    {
        $params = $this->request->post();
        DecorateTabbarLogic::save($params);
        return $this->success('操作成功', [], 1, 1);
    }


}