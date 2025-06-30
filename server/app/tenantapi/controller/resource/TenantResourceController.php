<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
declare (strict_types=1);

namespace app\tenantapi\controller\resource;


use app\common\controller\BaseLikeAdminController;
use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\resource\TenantResourceLists;
use app\tenantapi\logic\resource\TenantResourceLogic;
use app\tenantapi\validate\resource\TenantResourceValidate;


/**
 * 资源管理控制器
 * Class TenantResourceController
 * @package app\platform\controller\resource
 */
class TenantResourceController extends BaseAdminController
{


    /**
     * @notes 获取资源管理列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function lists(): \think\response\Json
    {
        return $this->dataLists(new TenantResourceLists($this->tenantId));
    }


    /**
     * @notes 添加资源管理
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function add(): \think\response\Json
    {
        $params = (new TenantResourceValidate())->post()->goCheck('add');
        $result = TenantResourceLogic::add(array_merge($params, ['tenant_id' => $this->tenantId]));
        if (true === $result) {
            return $this->success('添加成功', [], 1, 1);
        }
        return $this->fail(TenantResourceLogic::getError());
    }


    /**
     * @notes 编辑资源管理
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function edit(): \think\response\Json
    {
        $params = (new TenantResourceValidate())->post()->goCheck('edit');
        $result = TenantResourceLogic::edit(array_merge($params, ['tenant_id' => $this->tenantId]));
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(TenantResourceLogic::getError());
    }


    /**
     * @notes 删除资源管理
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function delete(): \think\response\Json
    {
        $params = (new TenantResourceValidate())->post()->goCheck('delete');
        TenantResourceLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取资源管理详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function detail(): \think\response\Json
    {
        $params = (new TenantResourceValidate())->goCheck('detail');
        $result = TenantResourceLogic::detail(array_merge($params, ['tenant_id' => $this->tenantId]));
        return $this->data($result);
    }


}