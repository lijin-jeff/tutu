<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\platformapi\controller\tenant;

use app\platformapi\controller\BaseAdminController;
use app\tenantapi\lists\user\UserLists;
use app\tenantapi\logic\user\UserLogic;
use app\tenantapi\validate\user\UserValidate;

/**
 * 租户用户控制器
 * Class TenantUserController
 * @package app\platformapi\controller\user
 */
class TenantUserController extends BaseAdminController
{

    /**
     * @notes 获取租户用户列表
     * @return \think\response\Json
     * @author yfdong
     * @date 2024/09/04 23:36
     */
    public function lists()
    {
        //进行租户信息校验
        (new UserValidate())->goCheck('manager');
        return $this->dataLists(new UserLists());
    }


    /**
     * @notes 获取租户用户详情
     * @return \think\response\Json
     * @author yfdong
     * @date 2024/09/04 23:36
     */
    public function detail()
    {
        $params = (new UserValidate())->goCheck('detail');
        $detail = UserLogic::detail($params['id']);
        return $this->success('获取租户用户详情成功', $detail);
    }
}