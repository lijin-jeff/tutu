<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\logic;

use app\common\enum\AdminTerminalEnum;
use app\common\enum\notice\NoticeEnum;
use app\common\enum\YesNoEnum;
use app\common\model\notice\NoticeRecord;
use app\common\model\notice\TenantNoticeRecord;
use app\common\model\notice\NoticeSetting;
use app\common\model\notice\TenantNoticeSetting;
use app\common\model\user\User;
use app\common\service\sms\SmsMessageService;


/**
 * 通知逻辑层
 * Class NoticeLogic
 * @package app\common\logic
 */
class NoticeLogic extends BaseLogic
{

    /**
     * @notes 根据场景发送短信
     * @param $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/9/15 15:28
     */
    public static function noticeByScene($params): bool
    {
        try {
            $noticeSetting = (AdminTerminalEnum::isPlatform() ? new NoticeSetting() : new TenantNoticeSetting)->where('scene_id', $params['scene_id'])->findOrEmpty()->toArray();
            if (empty($noticeSetting)) {
                throw new \Exception('找不到对应场景的配置');
            }
            // 合并额外参数
            $params = self::mergeParams($params);
            $res = false;
            self::setError('发送通知失败');

            // 短信通知
            if (isset($noticeSetting['sms_notice']['status']) && $noticeSetting['sms_notice']['status'] == YesNoEnum::YES) {
                $res = (new SmsMessageService())->send($params);
            }

            return $res;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 整理参数
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2022/9/15 15:28
     */
    public static function mergeParams($params): array
    {
        // 用户相关
        if (!empty($params['params']['user_id'])) {
            $user = User::findOrEmpty($params['params']['user_id'])->toArray();
            $params['params']['nickname'] = $user['nickname'];
            $params['params']['user_name'] = $user['nickname'];
            $params['params']['user_sn'] = $user['sn'];
            $params['params']['mobile'] = $params['params']['mobile'] ?? $user['mobile'];
        }

        // 跳转路径
        $jumpPath = self::getPathByScene($params['scene_id'], $params['params']['order_id'] ?? 0);
        $params['url'] = $jumpPath['url'];
        $params['page'] = $jumpPath['page'];

        return $params;
    }


    /**
     * @notes 根据场景获取跳转链接
     * @param $sceneId
     * @param $extraId
     * @return string[]
     * @author 兔兔答题
     * @date 2022/9/15 15:29
     */
    public static function getPathByScene($sceneId, $extraId)
    {
        // 小程序主页路径
        $page = '/pages/index/index';
        // 公众号主页路径
        $url = '/mobile/pages/index/index';
        return [
            'url' => $url,
            'page' => $page,
        ];
    }


    /**
     * @notes 替换消息内容中的变量占位符
     * @param $content
     * @param $params
     * @return array|mixed|string|string[]
     * @author 兔兔答题
     * @date 2022/9/15 15:29
     */
    public static function contentFormat($content, $params)
    {
        foreach ($params['params'] as $k => $v) {
            $search = '{' . $k . '}';
            $content = str_replace($search, $v, $content);
        }
        return $content;
    }


    /**
     * @notes 添加通知记录
     * @param $params
     * @param $noticeSetting
     * @param $sendType
     * @param $content
     * @param string $extra
     * @return NoticeRecord|\think\Model
     * @author 兔兔答题
     * @date 2022/9/15 15:29
     */
    public static function addNotice($params, $noticeSetting, $sendType, $content, $extra = '')
    {
        return (AdminTerminalEnum::isTenant() ? new TenantNoticeRecord() : new NoticeRecord)->create([
            'user_id' => $params['params']['user_id'] ?? 0,
            'title' => self::getTitleByScene($sendType, $noticeSetting),
            'content' => $content,
            'scene_id' => $noticeSetting['scene_id'],
            'read' => YesNoEnum::NO,
            'recipient' => $noticeSetting['recipient'],
            'send_type' => $sendType,
            'notice_type' => $noticeSetting['type'],
            'extra' => $extra,
        ]);
    }


    /**
     * @notes 通知记录标题
     * @param $sendType
     * @param $noticeSetting
     * @return string
     * @author 兔兔答题
     * @date 2022/9/15 15:30
     */
    public static function getTitleByScene($sendType, $noticeSetting)
    {
        switch ($sendType) {
            case NoticeEnum::SMS:
                $title = '';
                break;
            case NoticeEnum::OA:
                $title = $noticeSetting['oa_notice']['name'] ?? '';
                break;
            case NoticeEnum::MNP:
                $title = $noticeSetting['mnp_notice']['name'] ?? '';
                break;
            default:
                $title = '';
        }
        return $title;
    }

}