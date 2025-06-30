<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\lists\tools;

use app\platformapi\lists\BaseAdminDataLists;
use app\common\lists\ListsSearchInterface;
use app\common\model\tools\GenerateTable;


/**
 * 代码生成所选数据表列表
 * Class GenerateTableLists
 * @package app\platformapi\lists\tools
 */
class GenerateTableLists extends BaseAdminDataLists implements ListsSearchInterface
{

    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2022/6/14 10:55
     */
    public function setSearch(): array
    {
        return [
            '%like%' => ['table_name', 'table_comment']
        ];
    }


    /**
     * @notes 查询列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/6/14 10:55
     */
    public function lists(): array
    {
        return GenerateTable::where($this->searchWhere)
            ->order(['id' => 'desc'])
            ->append(['template_type_desc'])
            ->limit($this->limitOffset, $this->limitLength)
            ->select()
            ->toArray();
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2022/6/14 10:55
     */
    public function count(): int
    {
        return GenerateTable::count();
    }

}