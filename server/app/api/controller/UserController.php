<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\api\controller;


use app\api\logic\LoginLogic;
use app\api\logic\UserLogic;
use app\api\validate\PasswordValidate;
use app\api\validate\SetUserInfoValidate;
use app\api\validate\UserValidate;
use app\api\validate\WechatLoginValidate;

/**
 * 用户控制器
 * Class TenantController
 * @package app\api\controller
 */
class UserController extends BaseApiController
{
    public array $notNeedLogin = ['resetPassword'];


    /**
     * @notes 获取个人中心
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/16 18:19
     */
    public function center(): \think\response\Json
    {
        $data = UserLogic::center($this->userInfo);
        return $this->success('', $data);
    }


    /**
     * @notes 获取个人信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 19:46
     */
    public function info(): \think\response\Json
    {
        $result = UserLogic::info($this->userId);
        return $this->success('个人信息获取成功', $result);
    }


    /**
     * @notes 重置密码
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/16 18:06
     */
    public function resetPassword(): \think\response\Json
    {
        $params = (new PasswordValidate())->post()->goCheck('resetPassword');
        $result = UserLogic::resetPassword($params);
        if (true === $result) {
            return $this->success('重置成功', [], 1, 1);
        }
        return $this->fail(UserLogic::getError());
    }


    /**
     * @notes 修改密码
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 19:16
     */
    public function changePassword(): \think\response\Json
    {
        $params = (new PasswordValidate())->post()->goCheck('changePassword');
        $result = UserLogic::changePassword($params, $this->userId);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(UserLogic::getError());
    }


    /**
     * @notes 获取小程序手机号
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/21 16:46
     */
    public function getMobileByMnp(): \think\response\Json
    {
        $params            = (new UserValidate())->post()->goCheck('getMobileByMnp');
        $params['user_id'] = $this->userId;
        $result            = UserLogic::getMobileByMnp($params);
        if ($result === false) {
            return $this->fail(UserLogic::getError());
        }
        return $this->success('绑定成功', [], 1, 1);
    }


    /**
     * @notes 编辑用户信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/21 17:01
     */
    public function setInfo(): \think\response\Json
    {
        $params = (new SetUserInfoValidate())->post()->goCheck(null, ['id' => $this->userId]);
        $result = UserLogic::setInfo($this->userId, $params);
        if (false === $result) {
            return $this->fail(UserLogic::getError());
        }
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 绑定/变更 手机号
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/21 17:29
     */
    public function bindMobile(): \think\response\Json
    {
        $params            = (new UserValidate())->post()->goCheck('bindMobile');
        $params['user_id'] = $this->userId;
        $result            = UserLogic::bindMobile($params);
        if ($result) {
            return $this->success('绑定成功', [], 1, 1);
        }
        return $this->fail(UserLogic::getError());
    }

    /**
     * @notes 更新用户头像昵称
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/22 11:15
     */
    public function updateUser(): \think\response\Json
    {
        $params = (new WechatLoginValidate())->post()->goCheck("updateUser");
        if (LoginLogic::updateUser($params, $this->userId)) {
            return $this->success('更新成功', [], 1, 1);
        }
        return $this->fail('更新失败', [], 1);
    }
}