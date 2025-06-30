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
use app\common\logic\BaseLogic;
use app\common\model\pay\TenantPayConfig;
use app\common\service\FileService;

/**
 * 支付配置
 * Class PayConfigLogic
 * @package app\tenantapi\logic\setting\pay
 */
class PayConfigLogic extends BaseLogic
{

    /**
     * @notes 设置配置
     * @param $params
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/2/23 16:16
     */
    public static function setConfig($params)
    {
        $payConfig = TenantPayConfig::find($params['id']);

        $config = '';
        if ($payConfig['pay_way'] == PayEnum::WECHAT_PAY) {
            $config = [
                'interface_version' => $params['config']['interface_version'],
                'merchant_type'     => $params['config']['merchant_type'],
                'mch_id'            => $params['config']['mch_id'],
                'pay_sign_key'      => $params['config']['pay_sign_key'],
                'apiclient_cert'    => $params['config']['apiclient_cert'],
                'apiclient_key'     => $params['config']['apiclient_key'],
            ];
        }
        if ($payConfig['pay_way'] == PayEnum::ALI_PAY) {
            $config = [
                'mode'            => $params['config']['mode'],
                'merchant_type'   => $params['config']['merchant_type'],
                'app_id'          => $params['config']['app_id'],
                'private_key'     => $params['config']['private_key'],
                'ali_public_key'  => $params['config']['mode'] == 'normal_mode' ? $params['config']['ali_public_key'] : '',
                'public_cert'     => $params['config']['mode'] == 'certificate' ? $params['config']['public_cert'] : '',
                'ali_public_cert' => $params['config']['mode'] == 'certificate' ? $params['config']['ali_public_cert'] : '',
                'ali_root_cert'   => $params['config']['mode'] == 'certificate' ? $params['config']['ali_root_cert'] : '',
            ];
        }

        $payConfig->name = $params['name'];
        $payConfig->icon = FileService::setFileUrl($params['icon']);
        $payConfig->sort = $params['sort'];
        $payConfig->config = $config;
        $payConfig->remark = $params['remark'] ?? '';
        return $payConfig->save();
    }


    /**
     * @notes 获取配置
     * @param $params
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/2/23 16:16
     */
    public static function getConfig($params)
    {
        $payConfig = TenantPayConfig::find($params['id'])->toArray();
        $payConfig['icon'] = FileService::getFileUrl($payConfig['icon']);
        $payConfig['domain'] = request()->domain();
        return $payConfig;
    }

}
