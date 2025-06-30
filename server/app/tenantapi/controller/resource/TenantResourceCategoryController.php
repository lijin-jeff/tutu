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


use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\resource\TenantResourceCategoryLists;
use app\tenantapi\logic\resource\TenantResourceCategoryLogic;
use app\tenantapi\validate\resource\TenantResourceCategoryValidate;


/**
 * 资源分类控制器
 * Class TenantResourceCategoryController
 * @package app\platform\controller\resource
 */
class TenantResourceCategoryController extends BaseAdminController
{
    /**
     * 获取一级分类
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/4/1 03:00
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function parentList(): \think\response\Json
    {
        return $this->success('查询成功', TenantResourceCategoryLogic::parentList(['tenant_id' => $this->tenantId]));
    }

    /**
     * @notes 获取资源分类列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/16 23:36
     */
    public function lists(): \think\response\Json
    {
        return $this->dataLists(new TenantResourceCategoryLists($this->tenantId));
    }


    /**
     * @notes 添加资源分类
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/16 23:36
     */
    public function add(): \think\response\Json
    {
        $params = (new TenantResourceCategoryValidate())->post()->goCheck('add');
        $result = TenantResourceCategoryLogic::add(array_merge($params, ['tenant_id' => $this->tenantId]));
        if (true === $result) {
            return $this->success('添加成功', [], 1, 1);
        }
        return $this->fail(TenantResourceCategoryLogic::getError());
    }


    /**
     * @notes 编辑资源分类
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/16 23:36
     */
    public function edit(): \think\response\Json
    {
        $params = (new TenantResourceCategoryValidate())->post()->goCheck('edit');
        $result = TenantResourceCategoryLogic::edit(array_merge($params, ['tenant_id' => $this->tenantId]));
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(TenantResourceCategoryLogic::getError());
    }


    /**
     * @notes 删除资源分类
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/16 23:36
     */
    public function delete(): \think\response\Json
    {
        $params = (new TenantResourceCategoryValidate())->post()->goCheck('delete');
        TenantResourceCategoryLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取资源分类详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/06/16 23:36
     */
    public function detail(): \think\response\Json
    {
        $params = (new TenantResourceCategoryValidate())->goCheck('detail');
        $result = TenantResourceCategoryLogic::detail(array_merge($params, ['tenant_id' => $this->tenantId]));
        return $this->data($result);
    }

    /**
     * 资源分类树
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/4/1 03:42
     * @author 兔兔答题 <tutudati@outlook.com>
     */

    public function categoryTree(): \think\response\Json
    {
        return $this->success('题库分类获取成功', TenantResourceCategoryLogic::categoryTree(['tenant_id' => $this->tenantId]));
    }
}