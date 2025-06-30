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
 * 微信开放平台
 * Class AppSettingLogic
 * @package app\tenantapi\logic\setting\app
 */
class OpenSettingLogic extends BaseLogic
{

    /**
     * @notes 获取微信开放平台设置
     * @return array
     * @author 兔兔答题
     * @date 2022/3/29 11:03
     */
    public static function getConfig()
    {
        $config = [
            'app_id' => ConfigService::get('open_platform', 'app_id', ''),
            'app_secret' => ConfigService::get('open_platform', 'app_secret', ''),
        ];

        return $config;
    }


    /**
     * @notes 微信开放平台设置
     * @param $params
     * @author 兔兔答题
     * @date 2022/3/29 11:03
     */
    public static function setConfig($params)
    {
        ConfigService::set('open_platform', 'app_id', $params['app_id'] ?? '');
        ConfigService::set('open_platform', 'app_secret', $params['app_secret'] ?? '');
    }
}