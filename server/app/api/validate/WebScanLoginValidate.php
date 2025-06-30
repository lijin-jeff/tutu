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

use app\common\cache\WebScanLoginCache;
use app\common\validate\BaseValidate;

/**
 * 网站扫码登录验证
 * Class WebScanLoginValidate
 * @package app\api\validate
 */
class WebScanLoginValidate extends BaseValidate
{

    protected $rule = [
        'code' => 'require',
        'state' => 'require|checkState',
    ];

    protected $message = [
        'code.require' => '参数缺失',
        'state.require' => '昵称缺少',
    ];


    /**
     * @notes 校验登录状态标记
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/10/21 9:47
     */
    protected function checkState($value, $rule, $data)
    {
        $check = (new WebScanLoginCache())->getScanLoginState($value);

        if (empty($check)) {
            return '二维码已失效或不存在,请重新扫码';
        }

        return true;
    }

}