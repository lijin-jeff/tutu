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

use app\api\validate\{LoginAccountValidate, RegisterValidate, WebScanLoginValidate, WechatLoginValidate};
use app\api\logic\LoginLogic;

/**
 * 登录注册
 * Class LoginController
 * @package app\api\controller
 */
class LoginController extends BaseApiController
{

    public array $notNeedLogin = ['register', 'account', 'logout', 'codeUrl', 'oaLogin', 'mnpLogin', 'getScanCode', 'scanLogin', 'forgetUpdatePassword'];


    /**
     * @notes 注册账号
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/7 15:38
     */
    public function register(): \think\response\Json
    {
        $params = (new RegisterValidate())->post()->goCheck('register');
        $result = LoginLogic::register($params);
        if (true === $result) {
            return $this->success('注册成功', [], 1, 1);
        }
        return $this->fail(LoginLogic::getError());
    }


    /**
     * @notes 账号密码/手机号密码/手机号验证码登录
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/16 10:42
     */
    public function account(): \think\response\Json
    {
        $params = (new LoginAccountValidate())->post()->goCheck();
        $result = LoginLogic::login($params);
        if (false === $result) {
            return $this->fail(LoginLogic::getError());
        }
        return $this->success('登录成功', $result);
    }


    /**
     * @notes 退出登录
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/16 10:42
     */
    public function logout(): \think\response\Json
    {
        LoginLogic::logout($this->userInfo);
        return $this->success();
    }


    /**
     * @notes 获取微信请求code的链接
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/15 18:27
     */
    public function codeUrl(): \think\response\Json
    {
        $url    = $this->request->get('url');
        $result = ['url' => LoginLogic::codeUrl($url)];
        return $this->success('获取成功', $result);
    }


    /**
     * @notes 公众号登录
     * @return \think\response\Json
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author 兔兔答题
     * @date 2022/9/20 19:48
     */
    public function oaLogin(): \think\response\Json
    {
        $params = (new WechatLoginValidate())->post()->goCheck('oa');
        $res    = LoginLogic::oaLogin($params);
        if (false === $res) {
            return $this->fail(LoginLogic::getError());
        }
        return $this->success('', $res);
    }


    /**
     * @notes 小程序-登录接口
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 19:48
     */
    public function mnpLogin(): \think\response\Json
    {
        $params = (new WechatLoginValidate())->post()->goCheck('mnpLogin');
        $res    = LoginLogic::mnpLogin($params);
        if (false === $res) {
            return $this->fail(LoginLogic::getError());
        }
        return $this->success('登录成功', $res);
    }


    /**
     * @notes 小程序绑定微信
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 19:48
     */
    public function mnpAuthBind(): \think\response\Json
    {
        $params            = (new WechatLoginValidate())->post()->goCheck("wechatAuth");
        $params['user_id'] = $this->userId;
        $result            = LoginLogic::mnpAuthLogin($params);
        if ($result === false) {
            return $this->fail(LoginLogic::getError());
        }
        return $this->success('绑定成功', [], 1, 1);
    }


    /**
     * @notes 公众号绑定微信
     * @return \think\response\Json
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author 兔兔答题
     * @date 2022/9/20 19:48
     */
    public function oaAuthBind(): \think\response\Json
    {
        $params            = (new WechatLoginValidate())->post()->goCheck("wechatAuth");
        $params['user_id'] = $this->userId;
        $result            = LoginLogic::oaAuthLogin($params);
        if ($result === false) {
            return $this->fail(LoginLogic::getError());
        }
        return $this->success('绑定成功', [], 1, 1);
    }


    /**
     * @notes 获取扫码地址
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/10/20 18:25
     */
    public function getScanCode(): \think\response\Json
    {
        $redirectUri = $this->request->get('url/s');
        $result      = LoginLogic::getScanCode($redirectUri);
        if (false === $result) {
            return $this->fail(LoginLogic::getError() ?? '未知错误');
        }
        return $this->success('', $result);
    }


    /**
     * @notes 网站扫码登录
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/10/21 10:28
     */
    public function scanLogin(): \think\response\Json
    {
        $params = (new WebScanLoginValidate())->post()->goCheck();
        $result = LoginLogic::scanLogin($params);
        if (false === $result) {
            return $this->fail(LoginLogic::getError() ?? '登录失败');
        }
        return $this->success('', $result);
    }
}