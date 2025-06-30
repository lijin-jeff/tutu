<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\tenantapi\controller\exam;


use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\exam\TenantExamLibraryLists;
use app\tenantapi\validate\exam\TenantExamLibraryValidate;
use app\tenantapi\logic\exam\TenantExamLibraryLogic;


/**
 * 题库管理控制器
 * Class TenantExamLibraryController
 * @package app\platform\controller\exam
 */
class TenantExamLibraryController extends BaseAdminController
{


    /**
     * @notes 获取题库管理列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public function lists(): \think\response\Json
    {
        return $this->dataLists(new TenantExamLibraryLists($this->tenantId));
    }


    /**
     * @notes 添加题库管理
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public function add(): \think\response\Json
    {
        $params = (new TenantExamLibraryValidate())->post()->goCheck('add');
        $result = TenantExamLibraryLogic::add(array_merge($params, $this->tenantInfo));
        if (true === $result) {
            return $this->success('添加成功', [], 1, 1);
        }
        return $this->fail(TenantExamLibraryLogic::getError());
    }


    /**
     * @notes 编辑题库管理
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public function edit(): \think\response\Json
    {
        $params = (new TenantExamLibraryValidate())->post()->goCheck('edit');
        $result = TenantExamLibraryLogic::edit(array_merge($params, $this->tenantInfo));
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(TenantExamLibraryLogic::getError());
    }


    /**
     * @notes 删除题库管理
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public function delete(): \think\response\Json
    {
        $params = (new TenantExamLibraryValidate())->post()->goCheck('delete');
        TenantExamLibraryLogic::delete(array_merge($params, $this->tenantInfo));
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取题库管理详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public function detail(): \think\response\Json
    {
        $params = (new TenantExamLibraryValidate())->goCheck('detail');
        $result = TenantExamLibraryLogic::detail(array_merge($params, $this->tenantInfo));
        return $this->data($result);
    }


}