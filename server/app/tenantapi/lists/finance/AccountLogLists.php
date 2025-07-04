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
use app\common\enum\user\AccountLogEnum;
use app\common\lists\ListsSearchInterface;
use app\common\model\user\UserAccountLog;
use app\common\service\FileService;


/**
 * 账记流水列表
 * Class AccountLogLists
 * @package app\tenantapi\lists\finance
 */
class AccountLogLists extends BaseAdminDataLists implements ListsSearchInterface
{

    /**
     * @notes 搜索条件
     * @return array
     * @author 兔兔答题
     * @date 2023/2/24 15:26
     */
    public function setSearch(): array
    {
        return [
            '=' => ['al.change_type'],
        ];
    }


    /**
     * @notes 搜索条件
     * @author 兔兔答题
     * @date 2023/2/24 15:26
     */
    public function queryWhere()
    {
        $where = [];
        // 用户余额
        if (isset($this->params['type']) && $this->params['type'] == 'um') {
            $where[] = ['change_type', 'in', AccountLogEnum::getUserMoneyChangeType()];
        }

        if (!empty($this->params['user_info'])) {
            $where[] = ['u.sn|u.nickname|u.mobile|u.account', 'like', '%' . $this->params['user_info'] . '%'];
        }

        if (!empty($this->params['start_time'])) {
            $where[] = ['al.create_time', '>=', strtotime($this->params['start_time'])];
        }

        if (!empty($this->params['end_time'])) {
            $where[] = ['al.create_time', '<=', strtotime($this->params['end_time'])];
        }

        return $where;
    }


    /**
     * @notes 获取列表
     * @return array
     * @author 兔兔答题
     * @date 2023/2/24 15:31
     */
    public function lists(): array
    {
        $field = 'u.nickname,u.account,u.sn,u.avatar,u.mobile,al.action,al.change_amount,al.left_amount,al.change_type,al.source_sn,al.create_time';
        $lists = UserAccountLog::alias('al')
            ->join('user u', 'u.id = al.user_id')
            ->field($field)
            ->where($this->searchWhere)
            ->where($this->queryWhere())
            ->order('al.id', 'desc')
            ->limit($this->limitOffset, $this->limitLength)
            ->select()
            ->toArray();

        foreach ($lists as &$item) {
            $item['avatar'] = FileService::getFileUrl($item['avatar']);
            $item['change_type_desc'] = AccountLogEnum::getChangeTypeDesc($item['change_type']);
            $symbol = $item['action'] == AccountLogEnum::INC ? '+' : '-';
            $item['change_amount'] = $symbol . $item['change_amount'];
        }

        return $lists;
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2023/2/24 15:36
     */
    public function count(): int
    {
        return UserAccountLog::alias('al')
            ->join('user u', 'u.id = al.user_id')
            ->where($this->queryWhere())
            ->where($this->searchWhere)
            ->count();
    }
}