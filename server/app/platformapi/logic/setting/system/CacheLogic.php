<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\logic\setting\system;

use app\common\logic\BaseLogic;
use think\facade\Cache;

/**
 * 系统缓存逻辑
 * Class CacheLogic
 * @package app\platformapi\logic\setting\system
 */
class CacheLogic extends BaseLogic
{
    /**
     * @notes 清楚系统缓存
     * @author 兔兔答题
     * @date 2022/4/8 16:29
     */
    public static function clear()
    {
       Cache::clear();
       del_target_dir(app()->getRootPath().'runtime/file',true);
    }
}