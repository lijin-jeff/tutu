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
 * 系统更新
 * Class UpgradeValidate
 * @package app\adminapi\validate
 */
class UpgradeValidate extends BaseValidate
{
    protected $rule = [
        'id'            => 'require|checkIsAbleUpgrade',
        'update_type'   => 'require|eg:1'
    ];

    protected $message = [
        'id.require'            => '参数缺失',
        'update_type.require'   => '参数缺失',
        'update_type.eg'        => '更新类型错误',
    ];

    /**
     * @notes 检查是否可以更新
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2021/8/14 16:22
     */
    protected function checkIsAbleUpgrade($value, $rule, $data): bool|string
    {
        unset($value);
        unset($rule);

        // 本地更新版本号
        $localVersionData = local_version();
        $localVersionNo = $localVersionData['version'];


        //目标更新版本信息
        $targetVersionData = UpgradeLogic::getVersionDataById($data['id']);

        if (empty($targetVersionData)) {
            return '未获取到对应版本信息';
        }

        //目标更新的版本号
        $targetVersionNo = $targetVersionData['version_no'];

        //本地版本需要小于目标更新版本
        if ($localVersionNo > $targetVersionNo) {
            return '当前系统无法升级到该版本，请逐个版本升级。';
        }

        //获取远程列表
        $remoteData = UpgradeLogic::getRemoteVersion()['lists'] ?? [];
        if (empty($remoteData)) {
            return '获取更新数据失败';
        }

        //是否满足升级
        foreach ($remoteData as $k => $item) {
            if ($item['version_no'] != $localVersionNo) {
                continue;
            }

            if (empty($remoteData[$k - 1])) {
                return '已为最新版本';
            }

            if ($remoteData[$k - 1]['version_no'] != $targetVersionNo) {
                return '当前系统无法升级到该版本，请逐个版本升级。';
            }
        }
        return true;
    }
}