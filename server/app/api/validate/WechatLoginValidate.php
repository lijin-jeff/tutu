<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\validate;

use app\common\validate\BaseValidate;


/**
 * 微信登录验证
 * Class WechatLoginValidate
 * @package app\api\validate
 */
class WechatLoginValidate extends BaseValidate
{
    protected $rule = [
        'code'         => 'require',
        'nickname'     => 'require',
        'headimgurl'   => 'require',
        'openid'       => 'require',
        'access_token' => 'require',
        'terminal'     => 'require',
        'avatar'       => 'require',
        'sex'          => 'require|in:0,1,2',
    ];

    protected $message = [
        'code.require'         => 'code缺少',
        'nickname.require'     => '昵称缺少',
        'headimgurl.require'   => '头像缺少',
        'openid.require'       => 'opendid缺少',
        'access_token.require' => 'access_token缺少',
        'terminal.require'     => '终端参数缺少',
        'avatar.require'       => '头像缺少',
    ];


    /**
     * @notes 公众号登录场景
     * @return WechatLoginValidate
     * @author 兔兔答题
     * @date 2022/9/16 10:57
     */
    public function sceneOa(): WechatLoginValidate
    {
        return $this->only(['code']);
    }


    /**
     * @notes 小程序-授权登录场景
     * @return WechatLoginValidate
     * @author 兔兔答题
     * @date 2022/9/16 11:15
     */
    public function sceneMnpLogin(): WechatLoginValidate
    {
        return $this->only(['code']);
    }


    /**
     * @notes
     * @return WechatLoginValidate
     * @author 兔兔答题
     * @date 2022/9/16 11:15
     */
    public function sceneWechatAuth(): WechatLoginValidate
    {
        return $this->only(['code']);
    }


    /**
     * @notes 更新用户信息场景
     * @return WechatLoginValidate
     * @author 兔兔答题
     * @date 2023/2/22 11:14
     */
    public function sceneUpdateUser(): WechatLoginValidate
    {
        return $this->only(['nickname', 'avatar', 'sex']);
    }


}