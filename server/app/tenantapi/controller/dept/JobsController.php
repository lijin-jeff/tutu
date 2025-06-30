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
use app\tenantapi\lists\dept\JobsLists;
use app\tenantapi\logic\dept\JobsLogic;
use app\tenantapi\validate\dept\JobsValidate;


/**
 * 岗位管理控制器
 * Class JobsController
 * @package app\tenantapi\controller\dept
 */
class JobsController extends BaseAdminController
{

    /**
     * @notes 岗位列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/26 10:00
     */
    public function lists()
    {
        return $this->dataLists(new JobsLists());
    }


    /**
     * @notes 添加岗位
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/25 18:40
     */
    public function add()
    {
        $params = (new JobsValidate())->post()->goCheck('add');
        JobsLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes 编辑岗位
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/25 18:41
     */
    public function edit()
    {
        $params = (new JobsValidate())->post()->goCheck('edit');
        $result = JobsLogic::edit($params);
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(JobsLogic::getError());
    }


    /**
     * @notes 删除岗位
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/25 18:41
     */
    public function delete()
    {
        $params = (new JobsValidate())->post()->goCheck('delete');
        JobsLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取岗位详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/5/25 18:41
     */
    public function detail()
    {
        $params = (new JobsValidate())->goCheck('detail');
        $result = JobsLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 获取岗位数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 10:31
     */
    public function all()
    {
        $result = JobsLogic::getAllData();
        return $this->data($result);
    }


}