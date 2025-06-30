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
use app\common\enum\RefundEnum;
use app\common\lists\ListsExtendInterface;
use app\common\lists\ListsSearchInterface;
use app\common\model\refund\RefundRecord;
use app\common\service\FileService;


/**
 * 退款记录列表
 * Class RefundRecordLists
 * @package app\tenantapi\lists\product
 */
class RefundRecordLists extends BaseAdminDataLists implements ListsSearchInterface, ListsExtendInterface
{

    /**
     * @notes 查询条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2023/3/1 9:51
     */
    public function setSearch(): array
    {
        return [
            '=' => ['r.sn', 'r.order_sn', 'r.refund_type'],
        ];
    }


    /**
     * @notes 查询条件
     * @param bool $flag
     * @return array
     * @author 兔兔答题
     * @date 2023/3/1 9:51
     */
    public function queryWhere($flag = true)
    {
        $where = [];
        if (!empty($this->params['user_info'])) {
            $where[] = ['u.sn|u.nickname|u.mobile|u.account', 'like', '%' . $this->params['user_info'] . '%'];
        }
        if (!empty($this->params['start_time'])) {
            $where[] = ['r.create_time', '>=', strtotime($this->params['start_time'])];
        }
        if (!empty($this->params['end_time'])) {
            $where[] = ['r.create_time', '<=', strtotime($this->params['end_time'])];
        }

        if ($flag == true) {
            if (isset($this->params['refund_status']) && $this->params['refund_status'] != '') {
                $where[] = ['r.refund_status', '=', $this->params['refund_status']];
            }
        }

        return $where;
    }


    /**
     * @notes 获取列表
     * @return array
     * @author 兔兔答题
     * @date 2023/3/1 9:51
     */
    public function lists(): array
    {
        $lists = (new RefundRecord())->alias('r')
            ->field('r.*,u.nickname,u.avatar')
            ->join('user u', 'u.id = r.user_id')
            ->order(['r.id' => 'desc'])
            ->where($this->searchWhere)
            ->where($this->queryWhere())
            ->limit($this->limitOffset, $this->limitLength)
            ->append(['refund_type_text', 'refund_status_text', 'refund_way_text'])
            ->select()
            ->toArray();

        foreach ($lists as &$item) {
            $item['avatar'] = FileService::getFileUrl($item['avatar']);
        }

        return $lists;
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2023/3/1 9:51
     */
    public function count(): int
    {
        return (new RefundRecord())->alias('r')
            ->join('user u', 'u.id = r.user_id')
            ->where($this->searchWhere)
            ->where($this->queryWhere())
            ->count();
    }


    /**
     * @notes 额外参数
     * @return mixed|null
     * @author 兔兔答题
     * @date 2023/3/1 9:51
     */
    public function extend()
    {
        $count = (new RefundRecord())->alias('r')
            ->join('user u', 'u.id = r.user_id')
            ->field([
                'count(r.id) as total',
                'count(if(r.refund_status='.RefundEnum::REFUND_ING.', true, null)) as ing',
                'count(if(r.refund_status='.RefundEnum::REFUND_SUCCESS.', true, null)) as success',
                'count(if(r.refund_status='.RefundEnum::REFUND_ERROR.', true, null)) as error',
            ])
            ->where($this->searchWhere)
            ->where($this->queryWhere(false))
            ->select()->toArray();

        return array_shift($count);
    }
}
