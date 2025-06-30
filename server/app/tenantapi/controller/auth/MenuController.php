<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\auth;


use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\auth\MenuLists;
use app\tenantapi\logic\auth\MenuLogic;
use app\tenantapi\validate\auth\MenuValidate;


/**
 * 系统菜单权限
 * Class MenuController
 * @package app\tenantapi\controller\setting\system
 */
class MenuController extends BaseAdminController
{

    /**
     * @notes 获取菜单路由
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/29 17:41
     */
    public function route()
    {
        $result = MenuLogic::getMenuByAdminId($this->adminId);
        return $this->data($result);
    }


    /**
     * @notes 获取菜单列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/29 17:23
     */
    public function lists()
    {
        return $this->dataLists(new MenuLists());
    }


    /**
     * @notes 菜单详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/30 10:07
     */
    public function detail()
    {
        $params = (new MenuValidate())->goCheck('detail');
        return $this->data(MenuLogic::detail($params));
    }


    /**
     * @notes 添加菜单
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/30 10:07
     */
    public function add()
    {
        $params = (new MenuValidate())->post()->goCheck('add');
        MenuLogic::add($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 编辑菜单
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/30 10:07
     */
    public function edit()
    {
        $params = (new MenuValidate())->post()->goCheck('edit');
        MenuLogic::edit($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 删除菜单
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/30 10:07
     */
    public function delete()
    {
        $params = (new MenuValidate())->post()->goCheck('delete');
        MenuLogic::delete($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 更新状态
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/7/6 17:04
     */
    public function updateStatus()
    {
        $params = (new MenuValidate())->post()->goCheck('status');
        MenuLogic::updateStatus($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 获取菜单数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 11:03
     */
    public function all()
    {
        $result = MenuLogic::getAllData();
        return $this->data($result);
    }


}