<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\lists\setting\dict;

use app\platformapi\lists\BaseAdminDataLists;
use app\common\lists\ListsSearchInterface;
use app\common\model\dict\DictType;


/**
 * 字典类型列表
 * Class DictTypeLists
 * @package app\platformapi\lists\dictionary
 */
class DictTypeLists extends BaseAdminDataLists implements ListsSearchInterface
{

    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2022/6/20 15:53
     */
    public function setSearch(): array
    {
        return [
            '%like%' => ['name', 'type'],
            '=' => ['status']
        ];
    }


    /**
     * @notes 获取列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/6/20 15:54
     */
    public function lists(): array
    {
        return DictType::where($this->searchWhere)
            ->limit($this->limitOffset, $this->limitLength)
            ->append(['status_desc'])
            ->order(['id' => 'desc'])
            ->select()
            ->toArray();
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2022/6/20 15:54
     */
    public function count(): int
    {
        return DictType::where($this->searchWhere)->count();
    }

}