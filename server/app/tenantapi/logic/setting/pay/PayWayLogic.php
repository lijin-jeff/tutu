<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\setting\pay;


use app\common\enum\PayEnum;
use app\common\enum\YesNoEnum;
use app\common\logic\BaseLogic;
use app\common\model\pay\TenantPayConfig;
use app\common\model\pay\TenantPayWay;
use app\common\service\FileService;

/**
 * 支付方式
 * Class PayWayLogic
 * @package app\tenantapi\logic\setting\pay
 */
class PayWayLogic extends BaseLogic
{

    /**
     * @notes 获取支付方式
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/2/23 16:25
     */
    public static function getPayWay()
    {
        $payWay = TenantPayWay::select()->append(['pay_way_name'])
            ->toArray();

        if (empty($payWay)) {
            return [];
        }

        $lists = [];
        for ($i = 1; $i <= max(array_column($payWay, 'scene')); $i++) {
            foreach ($payWay as $val) {
                if ($val['scene'] == $i) {
                    $val['icon'] = FileService::getFileUrl(TenantPayConfig::where('id', $val['pay_config_id'])->value('icon'));
                    $lists[$i][] = $val;
                }
            }
        }

        return $lists;
    }


    /**
     * @notes 设置支付方式
     * @param $params
     * @return bool|string
     * @throws \Exception
     * @author 兔兔答题
     * @date 2023/2/23 16:26
     */
    public static function setPayWay($params)
    {
        $payWay = new TenantPayWay;
        $data = [];
        foreach ($params as $key => $value) {
            $isDefault = array_column($value, 'is_default');
            $isDefaultNum = array_count_values($isDefault);
            $status = array_column($value, 'status');
            $sceneName = PayEnum::getPaySceneDesc($key);
            if (!in_array(YesNoEnum::YES, $isDefault)) {
                return $sceneName . '支付场景缺少默认支付';
            }
            if ($isDefaultNum[YesNoEnum::YES] > 1) {
                return $sceneName . '支付场景的默认值只能存在一个';
            }
            if (!in_array(YesNoEnum::YES, $status)) {
                return $sceneName . '支付场景至少开启一个支付状态';
            }

            foreach ($value as $val) {
                $result = TenantPayWay::where('id', $val['id'])->findOrEmpty();
                if ($result->isEmpty()) {
                    continue;
                }
                if ($val['is_default'] == YesNoEnum::YES && $val['status'] == YesNoEnum::NO) {
                    return $sceneName . '支付场景的默认支付未开启支付状态';
                }
                $data[] = [
                    'is_default' => $val['is_default'],
                    'status' => $val['status'],
                ];
            }
        }
        $payWay->saveAll($data);
        return true;
    }
}

