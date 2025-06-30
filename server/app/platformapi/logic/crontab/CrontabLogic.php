<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\platformapi\logic\crontab;

use app\common\enum\CrontabEnum;
use app\common\logic\BaseLogic;
use app\common\model\Crontab;
use Cron\CronExpression;

/**
 * 定时任务逻辑层
 * Class CrontabLogic
 * @package app\platformapi\logic\crontab
 */
class CrontabLogic extends BaseLogic
{
    /**
     * @notes 添加定时任务
     * @param $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/3/29 14:41
     */
    public static function add($params)
    {
        try {
            $params['remark'] = $params['remark'] ?? '';
            $params['params'] = $params['params'] ?? '';
            $params['last_time'] = time();

            Crontab::create($params);

            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 查看定时任务详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2022/3/29 14:41
     */
    public static function detail($params)
    {
        $field = 'id,name,type,type as type_desc,command,params,status,status as status_desc,expression,remark';
        $crontab = Crontab::field($field)->findOrEmpty($params['id']);
        if ($crontab->isEmpty()) {
            return [];
        }
        return $crontab->toArray();
    }


    /**
     * @notes 编辑定时任务
     * @param $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/3/29 14:42
     */
    public static function edit($params)
    {
        try {
            $params['remark'] = $params['remark'] ?? '';
            $params['params'] = $params['params'] ?? '';

            Crontab::update($params, ['id' => $params['id']]);

            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 删除定时任务
     * @param $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/3/29 14:42
     */
    public static function delete($params)
    {
        try {
            Crontab::destroy($params['id']);

            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 操作定时任务
     * @param $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/3/29 14:42
     */
    public static function operate($params)
    {
        try {
            $crontab = Crontab::findOrEmpty($params['id']);
            if ($crontab->isEmpty()) {
                throw new \Exception('定时任务不存在');
            }
            switch ($params['operate']) {
                case 'start';
                    $crontab->status = CrontabEnum::START;
                    break;
                case 'stop':
                    $crontab->status = CrontabEnum::STOP;
                    break;
            }
            $crontab->save();

            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 获取规则执行时间
     * @param $params
     * @return array|string
     * @author 兔兔答题
     * @date 2022/3/29 14:42
     */
    public static function expression($params)
    {
        try {
            $cron = new CronExpression($params['expression']);
            $result = $cron->getMultipleRunDates(5);
            $result = json_decode(json_encode($result), true);
            $lists = [];
            foreach ($result as $k => $v) {
                $lists[$k]['time'] = $k + 1;
                $lists[$k]['date'] = str_replace('.000000', '', $v['date']);
            }
            $lists[] = ['time' => 'x', 'date' => '……'];
            return $lists;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}