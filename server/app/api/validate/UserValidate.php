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
 * 用户验证器
 * Class TenantValidate
 * @package app\shopapi\validate
 */
class UserValidate extends BaseValidate
{

    protected $rule = [
        'code' => 'require',
    ];

    protected $message = [
        'code.require' => '参数缺失',
    ];


    /**
     * @notes 获取小程序手机号场景
     * @return UserValidate
     * @author 兔兔答题
     * @date 2022/9/21 16:44
     */
    public function sceneGetMobileByMnp()
    {
        return $this->only(['code']);
    }


    /**
     * @notes 绑定/变更 手机号
     * @return UserValidate
     * @author 兔兔答题
     * @date 2022/9/21 17:37
     */
    public function sceneBindMobile()
    {
        return $this->only(['mobile', 'code']);
    }


}