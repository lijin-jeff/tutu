<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\tenantapi\controller\config;


use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\config\TenantBannerLists;
use app\tenantapi\logic\config\TenantBannerLogic;
use app\tenantapi\validate\config\TenantBannerValidate;


/**
 * 轮播图管理控制器
 * Class TenantBannerController
 * @package app\platform\controller\config
 */
class TenantBannerController extends BaseAdminController
{


    /**
     * @notes 获取轮播图管理列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function lists()
    {
        return $this->dataLists(new TenantBannerLists($this->tenantId));
    }


    /**
     * @notes 添加轮播图管理
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function add()
    {
        $params = (new TenantBannerValidate())->post()->goCheck('add');
        $result = TenantBannerLogic::add(array_merge($params, ["tenant_id" => $this->tenantId]));
        if (true === $result) {
            return $this->success('添加成功', [], 1, 1);
        }
        return $this->fail(TenantBannerLogic::getError());
    }


    /**
     * @notes 编辑轮播图管理
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function edit()
    {
        $params = (new TenantBannerValidate())->post()->goCheck('edit');
        $result = TenantBannerLogic::edit(array_merge($params, ["tenant_id" => $this->tenantId]));
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(TenantBannerLogic::getError());
    }


    /**
     * @notes 删除轮播图管理
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function delete()
    {
        $params = (new TenantBannerValidate())->post()->goCheck('delete');
        TenantBannerLogic::delete(array_merge($params, ["tenant_id" => $this->tenantId]));
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取轮播图管理详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function detail()
    {
        $params = (new TenantBannerValidate())->goCheck('detail');
        $result = TenantBannerLogic::detail(array_merge($params, ["tenant_id" => $this->tenantId]));
        return $this->data($result);
    }


}