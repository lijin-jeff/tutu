<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\channel;

use app\common\logic\BaseLogic;
use app\common\service\ConfigService;
use app\common\service\FileService;

/**
 * 公众号设置逻辑
 * Class OfficialAccountSettingLogic
 * @package app\tenantapi\logic\channel
 */
class OfficialAccountSettingLogic extends BaseLogic
{
    /**
     * @notes 获取公众号配置
     * @return array
     * @author ljj
     * @date 2022/2/16 10:08 上午
     */
    public function getConfig()
    {
        $domainName = $_SERVER['SERVER_NAME'];
        $qrCode = ConfigService::get('oa_setting', 'qr_code', '');
        $qrCode = empty($qrCode) ? $qrCode : FileService::getFileUrl($qrCode);
        $config = [
            'name'              => ConfigService::get('oa_setting', 'name', ''),
            'original_id'       => ConfigService::get('oa_setting', 'original_id', ''),
            'qr_code'           => $qrCode,
            'app_id'            => ConfigService::get('oa_setting', 'app_id', ''),
            'app_secret'        => ConfigService::get('oa_setting', 'app_secret', ''),
            // url()方法返回Url实例，通过与空字符串连接触发该实例的__toString()方法以得到路由地址
            'url'               => url('tenantapi/channel.official_account_reply/index', [],'',true).'',
            'token'             => ConfigService::get('oa_setting', 'token'),
            'encoding_aes_key'  => ConfigService::get('oa_setting', 'encoding_aes_key', ''),
            'encryption_type'   => ConfigService::get('oa_setting', 'encryption_type', 1),
            'business_domain'   => $domainName,
            'js_secure_domain'  => $domainName,
            'web_auth_domain'   => $domainName,
        ];
        return $config;
    }

    /**
     * @notes 设置公众号配置
     * @param $params
     * @author ljj
     * @date 2022/2/16 10:08 上午
     */
    public function setConfig($params)
    {
        $qrCode = isset($params['qr_code']) ? FileService::setFileUrl($params['qr_code']) : '';

        ConfigService::set('oa_setting','name', $params['name'] ?? '');
        ConfigService::set('oa_setting','original_id', $params['original_id'] ?? '');
        ConfigService::set('oa_setting','qr_code', $qrCode);
        ConfigService::set('oa_setting','app_id',$params['app_id']);
        ConfigService::set('oa_setting','app_secret',$params['app_secret']);
        ConfigService::set('oa_setting','token',$params['token'] ?? '');
        ConfigService::set('oa_setting','encoding_aes_key',$params['encoding_aes_key'] ?? '');
        ConfigService::set('oa_setting','encryption_type',$params['encryption_type']);
    }
}