<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\common\listener;

use app\common\logic\NoticeLogic;
use think\facade\Log;

/**
 * 通知事件监听
 * Class NoticeListener
 * @package app\listener
 */
class NoticeListener
{
    public function handle($params): bool|string
    {
        try {
            if (empty($params['scene_id'])) {
                throw new \Exception('场景ID不能为空');
            }
            // 根据不同的场景发送通知
            $result = NoticeLogic::noticeByScene($params);
            if (false === $result) {
                throw new \Exception(NoticeLogic::getError());
            }
            return true;
        } catch (\Exception $e) {
            Log::write('通知发送失败:'.$e->getMessage());
            return $e->getMessage();
        }
    }
}