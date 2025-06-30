<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\dept;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\logic\dept\DeptLogic;
use app\tenantapi\validate\dept\DeptValidate;

/**
 * 部门管理控制器
 * Class DeptController
 * @package app\tenantapi\controller\dept
 */
class DeptController extends BaseAdminController
{

    /**
     * @notes 部门列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/25 18:07
     */
    public function lists()
    {
        $params = $this->request->get();
        $result = DeptLogic::lists($params);
        return $this->success('',$result);
    }


    /**
     * @notes 上级部门
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/5/26 18:36
     */
    public function leaderDept()
    {
        $result = DeptLogic::leaderDept();
        return $this->success('',$result);
    }


    /**
     * @notes 添加部门
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/25 18:40
     */
    public function add()
    {
        $params = (new DeptValidate())->post()->goCheck('add');
        DeptLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes 编辑部门
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/25 18:41
     */
    public function edit()
    {
        $params = (new DeptValidate())->post()->goCheck('edit');
        $result = DeptLogic::edit($params);
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(DeptLogic::getError());
    }


    /**
     * @notes 删除部门
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/25 18:41
     */
    public function delete()
    {
        $params = (new DeptValidate())->post()->goCheck('delete');
        DeptLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取部门详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/25 18:41
     */
    public function detail()
    {
        $params = (new DeptValidate())->goCheck('detail');
        $result = DeptLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 获取部门数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 10:28
     */
    public function all()
    {
        $result = DeptLogic::getAllData();
        return $this->data($result);
    }


}