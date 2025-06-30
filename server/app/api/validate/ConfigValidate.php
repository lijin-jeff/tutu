<?php
declare(strict_types=1);
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

class ConfigValidate extends BaseValidate
{
    protected $rule = [
        'client'   => 'require',
        'position' => 'require',
        'type'     => 'require',
    ];

    protected $message = [
        'client.require'   => '平台参数缺失',
        'position.require' => '平台参数缺失',
        'type.require'     => '类型参数缺失',
    ];

    /**
     * 图片配置验证
     * @return ConfigValidate
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/2 18:06
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function scenePlatform(): ConfigValidate
    {
        return $this->only(['platform', 'type', 'client']);
    }
}