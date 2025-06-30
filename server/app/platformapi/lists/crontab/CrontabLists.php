<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\lists\crontab;

use app\platformapi\lists\BaseAdminDataLists;
use app\common\model\Crontab;

/**
 * 定时任务列表
 * Class CrontabLists
 * @package app\platformapi\lists\crontab
 */
class CrontabLists extends BaseAdminDataLists
{
    /**
     * @notes 定时任务列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/3/29 14:30
     */
    public function lists(): array
    {
        $field = 'id,name,type,type as type_desc,command,params,expression,
        status,status as status_desc,error,last_time,time,max_time';

        $lists = Crontab::field($field)
            ->limit($this->limitOffset, $this->limitLength)
            ->order('id', 'desc')
            ->select()
            ->toArray();

        return $lists;
    }


    /**
     * @notes 定时任务数量
     * @return int
     * @author 兔兔答题
     * @date 2022/3/29 14:38
     */
    public function count(): int
    {
        return Crontab::count();
    }
}