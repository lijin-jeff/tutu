<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\lists\auth;

use app\platformapi\lists\BaseAdminDataLists;
use app\common\model\auth\SystemMenu;


/**
 *  菜单列表
 * Class MenuLists
 * @package app\platformapi\lists\auth
 */
class MenuLists extends BaseAdminDataLists
{

    /**
     * @notes 获取菜单列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/6/29 16:41
     */
    public function lists(): array
    {
        $lists = SystemMenu::order(['sort' => 'desc', 'id' => 'asc'])
            ->select()
            ->toArray();
        return linear_to_tree($lists, 'children');
    }


    /**
     * @notes 获取菜单数量
     * @return int
     * @author 兔兔答题
     * @date 2022/6/29 16:41
     */
    public function count(): int
    {
        return SystemMenu::count();
    }

}