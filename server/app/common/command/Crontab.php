<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\command;

use app\common\enum\CrontabEnum;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use Cron\CronExpression;
use think\facade\Console;
use app\common\model\Crontab as CrontabModel;

/**
 * 定时任务
 * Class Crontab
 * @package app\command
 */
class Crontab extends Command
{
    protected function configure()
    {
        $this->setName('crontab')
            ->setDescription('定时任务');
    }

    protected function execute(Input $input, Output $output)
    {
        $lists = CrontabModel::where('status', CrontabEnum::START)->select()->toArray();
        if (empty($lists)) {
            return false;
        }
        $time =  time();
        foreach ($lists as $item) {
            if (empty($item['last_time'])) {
                $lastTime = (new CronExpression($item['expression']))
                    ->getNextRunDate()
                    ->getTimestamp();
                CrontabModel::where('id', $item['id'])->update([
                    'last_time' => $lastTime,
                ]);
                continue;
            }

            $nextTime = (new CronExpression($item['expression']))
                ->getNextRunDate($item['last_time'])
                ->getTimestamp();
            if ($nextTime > $time) {
                // 未到时间，不执行
                continue;
            }
            // 开始执行
            self::start($item);
        }
    }

    public static function start($item)
    {
        // 开始执行
        $startTime = microtime(true);
        try {
            $params = explode(' ', $item['params']);
            if (is_array($params) && !empty($item['params'])) {
                Console::call($item['command'], $params);
            } else {
                Console::call($item['command']);
            }
            // 清除错误信息
            CrontabModel::where('id', $item['id'])->update(['error' => '']);
        } catch (\Exception $e) {
            // 记录错误信息
            CrontabModel::where('id', $item['id'])->update([
                'error' => $e->getMessage(),
                'status' => CrontabEnum::ERROR
            ]);
        } finally {
            $endTime = microtime(true);
            // 本次执行时间
            $useTime = round(($endTime - $startTime), 2);
            // 最大执行时间
            $maxTime = max($useTime, $item['max_time']);
            // 更新最后执行时间
            CrontabModel::where('id', $item['id'])->update([
                'last_time' => time(),
                'time' => $useTime,
                'max_time' => $maxTime
            ]);
        }
    }
}