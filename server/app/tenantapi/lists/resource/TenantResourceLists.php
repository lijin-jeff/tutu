<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
declare (strict_types=1);

namespace app\tenantapi\lists\resource;


use app\common\lists\BaseDataLists;
use app\common\lists\ListsSearchInterface;
use app\common\model\resource\TenantResource;


/**
 * 资源管理列表
 * Class TenantResourceLists
 * @package app\platform\listsresource
 */
class TenantResourceLists extends BaseDataLists implements ListsSearchInterface
{


    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function setSearch(): array
    {
        return [
            '='      => ['is_show', 'category_uid', 'free_state', 'year'],
            '%like%' => ['title', 'author'],
        ];
    }


    /**
     * @notes 获取资源管理列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function lists(): array
    {
        return TenantResource::where($this->searchWhere)
            ->with(['category' => function ($query) {
                $query->field(['uid', 'title']);
            }])
            ->field(['id', 'uid', 'title', 'is_show', 'sort', 'create_time', 'update_time', 'image', 'remark', 'category_uid', 'author', 'free_state', 'money', 'year', 'file_url'])
            ->limit($this->limitOffset, $this->limitLength)
            ->order(['id' => 'desc'])
            ->select()
            ->toArray();
    }


    /**
     * @notes 获取资源管理数量
     * @return int
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public function count(): int
    {
        return TenantResource::where($this->searchWhere)->count();
    }

}