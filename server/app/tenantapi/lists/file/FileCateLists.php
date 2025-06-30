<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\lists\file;


use app\tenantapi\lists\BaseAdminDataLists;
use app\common\lists\ListsSearchInterface;
use app\common\model\file\TenantFileCate;

/**
 * 文件分类列表
 * Class FileCateLists
 * @package app\tenantapi\lists\file
 */
class FileCateLists extends BaseAdminDataLists implements ListsSearchInterface
{

    /**
     * @notes 文件分类搜素条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2021/12/29 14:24
     */
    public function setSearch(): array
    {
        return [
            '=' => ['type']
        ];
    }


    /**
     * @notes 获取文件分类列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2021/12/29 14:24
     */
    public function lists(): array
    {
        $lists = (new TenantFileCate())->field(['id,pid,type,name'])
            ->where($this->searchWhere)
            ->order('id desc')
            ->select()->toArray();

        return linear_to_tree($lists, 'children');
    }


    /**
     * @notes 获取文件分类数量
     * @return int
     * @author 兔兔答题
     * @date 2021/12/29 14:24
     */
    public function count(): int
    {
        return (new TenantFileCate())->where($this->searchWhere)->count();
    }
}