<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\lists\finance;


use app\tenantapi\lists\BaseAdminDataLists;
use app\common\model\refund\RefundLog;


/**
 * 退款日志列表
 * Class RefundLogLists
 * @package app\tenantapi\lists\product
 */
class RefundLogLists extends BaseAdminDataLists
{

    /**
     * @notes 查询条件
     * @return array
     * @author 兔兔答题
     * @date 2023/3/1 9:55
     */
    public function queryWhere()
    {
        $where[] = ['record_id', '=', $this->params['record_id'] ?? 0];
        return $where;
    }


    /**
     * @notes 获取列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/3/1 9:56
     */
    public function lists(): array
    {
        $lists = (new RefundLog())
            ->order(['id' => 'desc'])
            ->where($this->queryWhere())
            ->limit($this->limitOffset, $this->limitLength)
            ->hidden(['refund_msg'])
            ->append(['handler', 'refund_status_text'])
            ->select()
            ->toArray();
        return $lists;
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2023/3/1 9:56
     */
    public function count(): int
    {
        return (new RefundLog())
            ->where($this->queryWhere())
            ->count();
    }

}
