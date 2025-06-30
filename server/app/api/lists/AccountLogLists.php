<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\lists;

use app\common\enum\user\AccountLogEnum;
use app\common\model\user\UserAccountLog;


/**
 * 账户流水列表
 * Class AccountLogLists
 * @package app\shopapi\lists
 */
class AccountLogLists extends BaseApiDataLists
{

    /**
     * @notes 搜索条件
     * @return array
     * @author 兔兔答题
     * @date 2023/2/24 14:43
     */
    public function queryWhere()
    {
        // 指定用户
        $where[] = ['user_id', '=', $this->userId];

        // 用户月明细
        if (isset($this->params['type']) && $this->params['type'] == 'um') {
            $where[] = ['change_type', 'in', AccountLogEnum::getUserMoneyChangeType()];
        }

        // 变动类型
        if (!empty($this->params['action'])) {
            $where[] = ['action', '=', $this->params['action']];
        }

        return $where;
    }


    /**
     * @notes 获取列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/2/24 14:43
     */
    public function lists(): array
    {
        $field = 'change_type,change_amount,action,create_time,remark';
        $lists = UserAccountLog::field($field)
            ->where($this->queryWhere())
            ->order('id', 'desc')
            ->limit($this->limitOffset, $this->limitLength)
            ->select()
            ->toArray();

        foreach ($lists as &$item) {
            $item['type_desc'] = AccountLogEnum::getChangeTypeDesc($item['change_type']);
            $symbol = $item['action'] == AccountLogEnum::DEC ? '-' : '+';
            $item['change_amount_desc'] = $symbol . $item['change_amount'];
        }

        return $lists;
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2023/2/24 14:44
     */
    public function count(): int
    {
        return UserAccountLog::where($this->queryWhere())->count();
    }
}