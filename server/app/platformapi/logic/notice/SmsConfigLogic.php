<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\logic\notice;

use app\common\enum\notice\SmsEnum;
use app\common\logic\BaseLogic;
use app\common\service\ConfigService;

/**
 * 短信配置逻辑层
 * Class SmsConfigLogic
 * @package app\platformapi\logic\notice
 */
class SmsConfigLogic extends BaseLogic
{
    /**
     * @notes 获取短信配置
     * @return array
     * @author 兔兔答题
     * @date 2022/3/29 11:37
     */
    public static function getConfig()
    {
        $config = [
            ConfigService::get('sms', 'ali', ['type' => 'ali', 'name' => '阿里云短信', 'status' => 1]),
            ConfigService::get('sms', 'tencent', ['type' => 'tencent', 'name' => '腾讯云短信', 'status' => 0]),
        ];
        return $config;
    }


    /**
     * @notes 短信配置
     * @param $params
     * @return bool|void
     * @author 兔兔答题
     * @date 2022/3/29 11:37
     */
    public static function setConfig($params)
    {
        $type = $params['type'];
        $params['name'] = self::getNameDesc(strtoupper($type));
        ConfigService::set('sms', $type, $params);
        $default = ConfigService::get('sms', 'engine', false);
        if ($params['status'] == 1 && $default === false) {
            // 启用当前短信配置 并 设置当前短信配置为默认
            ConfigService::set('sms', 'engine', strtoupper($type));
            return true;
        }
        if ($params['status'] == 1 && $default != strtoupper($type)) {
            // 找到默认短信配置
            $defaultConfig = ConfigService::get('sms', strtolower($default));
            // 状态置为禁用 并 更新
            $defaultConfig['status'] = 0;
            ConfigService::set('sms', strtolower($default), $defaultConfig);
            // 设置当前短信配置为默认
            ConfigService::set('sms', 'engine', strtoupper($type));
            return true;
        }
    }


    /**
     * @notes 查看短信配置详情
     * @param $params
     * @return array|int|mixed|string|null
     * @author 兔兔答题
     * @date 2022/3/29 11:37
     */
    public static function detail($params)
    {
        $default = [];
        switch ($params['type']) {
            case 'ali':
                $default = [
                    'sign' => '',
                    'app_key' => '',
                    'secret_key' => '',
                    'status' => 1,
                    'name' => '阿里云短信',
                ];
                break;
            case 'tencent':
                $default = [
                    'sign' => '',
                    'app_id' => '',
                    'secret_key' => '',
                    'status' => 0,
                    'secret_id' => '',
                    'name' => '腾讯云短信',
                ];
                break;
        }
        $result = ConfigService::get('sms', $params['type'], $default);
        $result['status'] = intval($result['status'] ?? 0);
        return $result;
    }


    /**
     * @notes 获取短信平台名称
     * @param $value
     * @return string
     * @author 兔兔答题
     * @date 2022/3/29 11:37
     */
    public static function getNameDesc($value)
    {
        $desc = [
            'ALI' => '阿里云短信',
            'TENCENT' => '腾讯云短信',
        ];
        return $desc[$value] ?? '';
    }
}