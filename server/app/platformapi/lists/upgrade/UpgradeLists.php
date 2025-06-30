<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\lists\upgrade;

use app\platformapi\lists\BaseAdminDataLists;
use app\platformapi\logic\upgrade\UpgradeLogic;

/**
 * 系统更新列表
 */
class UpgradeLists extends BaseAdminDataLists
{
    /**
     * @notes 查看系统更新列表
     * @return array
     * @author 兔兔答题
     * @date 2021/8/14 17:16
     */
    public function lists(): array
    {
        $lists = UpgradeLogic::getRemoteVersion($this->pageNo, $this->pageSize)['lists'] ?? [];
        if (empty($lists)) {
            return $lists;
        }
        return UpgradeLogic::formatLists($lists, $this->pageNo);
    }

    /**
     * @notes 查看系统更新列表总数
     * @return int
     * @author 兔兔答题
     * @date 2021/8/14 17:15
     */
    public function count(): int
    {
        $result = UpgradeLogic::getRemoteVersion($this->limitOffset, $this->limitLength);
        return $result['count'] ?? 0;
    }
}