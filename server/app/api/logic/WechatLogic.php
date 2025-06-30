<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\logic;

use app\common\logic\BaseLogic;
use app\common\service\wechat\WeChatOaService;
use EasyWeChat\Kernel\Exceptions\Exception;

/**
 * 微信
 * Class WechatLogic
 * @package app\api\logic
 */
class WechatLogic extends BaseLogic
{

    /**
     * @notes 微信JSSDK授权接口
     * @param $params
     * @return false|mixed[]
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @author 兔兔答题
     * @date 2023/3/1 11:49
     */
    public static function jsConfig($params)
    {
        try {
            $url = urldecode($params['url']);
            return (new WeChatOaService())->getJsConfig($url, [
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'onMenuShareQZone',
                'openLocation',
                'getLocation',
                'chooseWXPay',
                'updateAppMessageShareData',
                'updateTimelineShareData',
                'openAddress',
                'scanQRCode'
            ]);
        } catch (Exception $e) {
            self::setError('获取jssdk失败:' . $e->getMessage());
            return false;
        }
    }
}