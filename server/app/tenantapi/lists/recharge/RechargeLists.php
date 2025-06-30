<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\lists\recharge;

use app\tenantapi\lists\BaseAdminDataLists;
use app\common\enum\PayEnum;
use app\common\lists\ListsExcelInterface;
use app\common\lists\ListsSearchInterface;
use app\common\model\recharge\RechargeOrder;
use app\common\service\FileService;

/**
 * 充值记录列表
 * Class RecharLists
 * @package app\tenantapi\lists
 */
class RechargeLists extends BaseAdminDataLists implements ListsSearchInterface, ListsExcelInterface
{
    /**
     * @notes 导出字段
     * @return string[]
     * @author 兔兔答题
     * @date 2023/2/24 16:07
     */
    public function setExcelFields(): array
    {
        return [
            'sn' => '充值单号',
            'nickname' => '用户昵称',
            'order_amount' => '充值金额',
            'pay_way_text' => '支付方式',
            'pay_status_text' => '支付状态',
            'pay_time' => '支付时间',
            'create_time' => '下单时间',
        ];
    }


    /**
     * @notes 导出表名
     * @return string
     * @author 兔兔答题
     * @date 2023/2/24 16:07
     */
    public function setFileName(): string
    {
        return '充值记录';
    }


    /**
     * @notes 搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2023/2/24 16:08
     */
    public function setSearch(): array
    {
        return [
            '=' => ['ro.sn', 'ro.pay_way', 'ro.pay_status'],
        ];
    }


    /**
     * @notes 搜索条件
     * @author 兔兔答题
     * @date 2023/2/24 16:08
     */
    public function queryWhere()
    {
        $where = [];
        // 用户编号
        if (!empty($this->params['user_info'])) {
            $where[] = ['u.sn|u.nickname|u.mobile|u.account', 'like', '%' . $this->params['user_info'] . '%'];
        }

        // 下单时间
        if (!empty($this->params['start_time']) && !empty($this->params['end_time'])) {
            $time = [strtotime($this->params['start_time']), strtotime($this->params['end_time'])];
            $where[] = ['ro.create_time', 'between', $time];
        }

        return $where;
    }


    /**
     * @notes 获取列表
     * @return array
     * @author 兔兔答题
     * @date 2023/2/24 16:13
     */
    public function lists(): array
    {
        $field = 'ro.id,ro.sn,ro.order_amount,ro.pay_way,ro.pay_time,ro.pay_status,ro.create_time,ro.refund_status';
        $field .= ',u.avatar,u.nickname,u.account';
        $lists = RechargeOrder::alias('ro')
            ->join('user u', 'u.id = ro.user_id')
            ->field($field)
            ->where($this->queryWhere())
            ->where($this->searchWhere)
            ->order('ro.id', 'desc')
            ->limit($this->limitOffset, $this->limitLength)
            ->append(['pay_status_text', 'pay_way_text'])
            ->select()
            ->toArray();

        foreach ($lists as &$item) {
            $item['avatar'] = FileService::getFileUrl($item['avatar']);
            $item['pay_time'] = empty($item['pay_time']) ? '' : date('Y-m-d H:i:s', $item['pay_time']);
        }

        return $lists;
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2023/2/24 16:13
     */
    public function count(): int
    {
        return RechargeOrder::alias('ro')
            ->join('user u', 'u.id = ro.user_id')
            ->where($this->queryWhere())
            ->where($this->searchWhere)
            ->count();
    }


}