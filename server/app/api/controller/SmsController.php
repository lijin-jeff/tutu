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


use app\api\logic\SmsLogic;
use app\api\validate\SendSmsValidate;


/**
 * 短信
 * Class SmsController
 * @package app\api\controller
 */
class SmsController extends BaseApiController
{

    public array $notNeedLogin = ['sendCode'];


    /**
     * @notes 发送短信验证码
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/15 16:17
     */
    public function sendCode(): \think\response\Json
    {
        $params = (new SendSmsValidate())->post()->goCheck();
        $result = SmsLogic::sendCode($params);
        if (true === $result) {
            return $this->success('发送成功');
        }
        return $this->fail(SmsLogic::getError());
    }

}