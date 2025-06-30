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

/**
 * App设置逻辑层
 * Class AppSettingLogic
 * @package app\tenantapi\logic\setting\app
 */
class AppSettingLogic extends BaseLogic
{

    /**
     * @notes 获取App设置
     * @return array
     * @author 兔兔答题
     * @date 2022/3/29 10:25
     */
    public static function getConfig()
    {
        $config = [
            'ios_download_url' => ConfigService::get('app', 'ios_download_url', ''),
            'android_download_url' => ConfigService::get('app', 'android_download_url', ''),
            'download_title' => ConfigService::get('app', 'download_title', ''),
        ];
        return $config;
    }


    /**
     * @notes App设置
     * @param $params
     * @author 兔兔答题
     * @date 2022/3/29 10:26
     */
    public static function setConfig($params)
    {
        ConfigService::set('app', 'ios_download_url', $params['ios_download_url'] ?? '');
        ConfigService::set('app', 'android_download_url', $params['android_download_url'] ?? '');
        ConfigService::set('app', 'download_title', $params['download_title'] ?? '');
    }
}