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

use app\common\enum\notice\NoticeEnum;
use app\common\logic\BaseLogic;


/**
 * 短信逻辑
 * Class SmsLogic
 * @package app\api\logic
 */
class SmsLogic extends BaseLogic
{

    /**
     * @notes 发送验证码
     * @param $params
     * @return false|mixed
     * @author 兔兔答题
     * @date 2022/9/15 16:17
     */
    public static function sendCode($params): mixed
    {
        try {
            $scene = NoticeEnum::getSceneByTag($params['scene']);
            if (empty($scene)) {
                throw new \Exception('场景值异常');
            }

            $result = event('Notice', [
                'scene_id' => $scene,
                'params'   => [
                    'mobile' => $params['mobile'],
                    'code'   => mt_rand(1000, 9999),
                ]
            ]);

            return $result[0];

        } catch (\Exception $e) {
            self::$error = $e->getMessage();
            return false;
        }
    }

}