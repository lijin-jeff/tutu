<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\tenantapi\controller\user;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\user\UserLists;
use app\tenantapi\logic\user\UserLogic;
use app\tenantapi\validate\user\AdjustUserMoney;
use app\tenantapi\validate\user\UserValidate;

/**
 * 用户控制器
 * Class TenantController
 * @package app\tenantapi\controller\user
 */
class UserController extends BaseAdminController
{

    /**
     * @notes 用户列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/22 16:16
     */
    public function lists()
    {
        return $this->dataLists(new UserLists());
    }


    /**
     * @notes 获取用户详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/22 16:34
     */
    public function detail()
    {
        $params = (new UserValidate())->goCheck('detail');
        $detail = UserLogic::detail($params['id']);
        return $this->success('', $detail);
    }


    /**
     * @notes 编辑用户信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/22 16:34
     */
    public function edit()
    {
        $params = (new UserValidate())->post()->goCheck('setInfo');
        UserLogic::setUserInfo($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 调整用户余额
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/23 14:33
     */
    public function adjustMoney()
    {
        $params = (new AdjustUserMoney())->post()->goCheck();
        $res = UserLogic::adjustUserMoney($params);
        if (true === $res) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail($res);
    }

}