<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\validate\setting;

use app\common\validate\BaseValidate;

/**
 * 网站设置验证器
 * Class WebSettingValidate
 * @package app\platformapi\validate\setting
 */
class WebSettingValidate extends BaseValidate
{
    protected $rule = [
        'name' => 'require|max:30',
        'web_favicon' => 'require',
        'web_logo_light' => 'require',
        'web_logo_dark' => 'require',
        'login_image' => 'require',
    ];

    protected $message = [
        'name.require' => '请填写网站名称',
        'name.max' => '网站名称最长为12个字符',
        'web_favicon.require' => '请上传网站图标',
        'web_logo_light.require' => '请上传网站亮色主题logo',
        'web_logo_dark.require' => '请上传网站暗色主题logo',
        'login_image.require' => '请上传登录页广告图',
    ];

    protected $scene = [
        'website' => ['name', 'web_favicon', 'web_logo_light','web_logo_dark', 'login_image', 'shop_name', 'shop_logo', 'pc_logo'],
    ];
}