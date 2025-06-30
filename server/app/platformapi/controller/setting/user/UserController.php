<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\platformapi\controller\setting\user;

use app\platformapi\{
    controller\BaseAdminController,
    logic\setting\user\UserLogic,
    validate\setting\UserConfigValidate
};


/**
 * 设置-用户设置控制器
 * Class TenantController
 * @package app\platformapi\controller\config
 */
class UserController extends BaseAdminController
{

    /**
     * @notes 获取用户设置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:08
     */
    public function getConfig()
    {
        $result = (new UserLogic())->getConfig();
        return $this->data($result);
    }


    /**
     * @notes 设置用户设置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:08
     */
    public function setConfig()
    {
        $params = (new UserConfigValidate())->post()->goCheck('user');
        (new UserLogic())->setConfig($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 获取注册配置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:08
     */
    public function getRegisterConfig()
    {
        $result = (new UserLogic())->getRegisterConfig();
        return $this->data($result);
    }


    /**
     * @notes 设置注册配置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:08
     */
    public function setRegisterConfig()
    {
        $params = (new UserConfigValidate())->post()->goCheck('register');
        (new UserLogic())->setRegisterConfig($params);
        return $this->success('操作成功', [], 1, 1);
    }

}