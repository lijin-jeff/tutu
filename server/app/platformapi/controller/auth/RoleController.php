<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\controller\auth;

use app\platformapi\{
    logic\auth\RoleLogic,
    lists\auth\RoleLists,
    validate\auth\RoleValidate,
    controller\BaseAdminController
};

/**
 * 角色控制器
 * Class RoleController
 * @package app\platformapi\controller\auth
 */
class RoleController extends BaseAdminController
{

    /**
     * @notes 查看角色列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/29 11:49
     */
    public function lists()
    {
        return $this->dataLists(new RoleLists());
    }


    /**
     * @notes 添加权限
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/29 11:49
     */
    public function add()
    {
        $params = (new RoleValidate())->post()->goCheck('add');
        $res = RoleLogic::add($params);
        if (true === $res) {
            return $this->success('添加成功', [], 1, 1);
        }
        return $this->fail(RoleLogic::getError());
    }


    /**
     * @notes 编辑角色
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/29 14:18
     */
    public function edit()
    {
        $params = (new RoleValidate())->post()->goCheck('edit');
        $res = RoleLogic::edit($params);
        if (true === $res) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(RoleLogic::getError());
    }


    /**
     * @notes 删除角色
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2021/12/29 14:18
     */
    public function delete()
    {
        $params = (new RoleValidate())->post()->goCheck('del');
        RoleLogic::delete($params['id']);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 查看角色详情
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2021/12/29 14:18
     */
    public function detail()
    {
        $params = (new RoleValidate())->goCheck('detail');
        $detail = RoleLogic::detail($params['id']);
        return $this->data($detail);
    }


    /**
     * @notes 获取角色数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 10:39
     */
    public function all()
    {
        $result = RoleLogic::getAllData();
        return $this->data($result);
    }
}