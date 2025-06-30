<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

declare (strict_types=1);

namespace app\tenantapi\http\middleware;

/**
 * 演示环境数据加密
 * Class DemoDataMiddleware
 * @package app\tenantapi\http\middleware
 */
class EncryDemoDataMiddleware
{

    // 需要过滤的接口
    protected $needCheck = [
        // 存储配置
        'setting.storage/detail',
        // 短信配置
        'notice.smsConfig/detail',
        // 公众号配置
        'channel.official_account_setting/getConfig',
        // 小程序配置
        'channel.mnp_settings/getConfig',
        // 开放平台配置
        'channel.open_setting/getConfig',
        // 支付配置
        'setting.pay.pay_config/getConfig',
    ];

    // 可以排除字段
    protected $excludeParams = [
        'name',
        'icon',
        'image',
        'qr_code',
        'interface_version',
        'merchant_type',
    ];


    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        // 非需校验的接口 或者 未开启演示模式
        $accessUri = strtolower($request->controller() . '/' . $request->action());
        if (!in_array($accessUri, lower_uri($this->needCheck)) || !env('project.demo_env')) {
            return $response;
        }

        // 非json数据
        if (!method_exists($response, 'header') || !in_array('application/json; charset=utf-8', $response->getHeader())) {
            return $response;
        }

        $data = $response->getData();
        if (!is_array($data) || empty($data)) {
            return $response;
        }

        foreach ($data['data'] as $key => $item) {
            // 字符串
            if (is_string($item)) {
                $data['data'][$key] = $this->getEncryData($key, $item);
                continue;
            }
            // 数组
            if (is_array($item)) {
                foreach ($item as $itemKey => $itemValue) {
                    $data['data'][$key][$itemKey] = $this->getEncryData($itemKey, $itemValue);
                }
            }
        }

        return $response->data($data);
    }


    /**
     * @notes 加密配置
     * @param $key
     * @param $value
     * @return mixed|string
     * @author 兔兔答题
     * @date 2023/3/6 11:49
     */
    protected function getEncryData($key, $value)
    {
        // 非隐藏字段
        if (in_array($key, $this->excludeParams)) {
            return $value;
        }

        // 隐藏字段
        if (is_string($value)) {
            return '******';
        }
        return $value;
    }

}