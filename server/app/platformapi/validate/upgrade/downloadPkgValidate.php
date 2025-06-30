<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\validate\upgrade;

use app\platformapi\logic\upgrade\UpgradeLogic;
use app\common\validate\BaseValidate;

/**
 * 系统更新-获取更新包链接
 */
class downloadPkgValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|checkVersionData',
        'update_type' => 'require'
    ];

    protected $message = [
        'id.require' => '参数缺失',
        'update_type.require' => '参数缺失',
    ];

    /**
     * @notes 验证版本信息
     * @param $value
     * @return bool|string
     * @author 兔兔答题
     * @date 2021/10/9 15:05
     */
    protected function checkVersionData($value): bool|string
    {
        //目标更新版本信息
        $targetVersionData = UpgradeLogic::getVersionDataById($value);

        if (empty($targetVersionData)) {
            return '未获取到对应版本信息';
        }
        return true;
    }
}