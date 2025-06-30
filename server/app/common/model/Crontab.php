<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\model;

use app\common\enum\CrontabEnum;
use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 定时任务模型
 * Class Crontab
 * @package app\common\model
 */
class Crontab extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    protected $name = 'dev_crontab';


    /**
     * @notes 类型获取器
     * @param $value
     * @return string
     * @author 兔兔答题
     * @date 2022/3/29 12:05
     */
    public function getTypeDescAttr($value)
    {
        $desc = [
            CrontabEnum::CRONTAB => '定时任务',
            CrontabEnum::DAEMON => '守护进程',
        ];
        return $desc[$value] ?? '';
    }


    /**
     * @notes 状态获取器
     * @param $value
     * @return string
     * @author 兔兔答题
     * @date 2022/3/29 12:06
     */
    public function getStatusDescAttr($value)
    {
        $desc = [
            CrontabEnum::START => '运行',
            CrontabEnum::STOP => '停止',
            CrontabEnum::ERROR => '错误',
        ];
        return $desc[$value] ?? '';
    }


    /**
     * @notes 最后执行时间获取器
     * @param $value
     * @return string
     * @author 兔兔答题
     * @date 2022/3/29 12:06
     */
    public function getLastTimeAttr($value)
    {
        return empty($value) ? '' : date('Y-m-d H:i:s', $value);
    }
}