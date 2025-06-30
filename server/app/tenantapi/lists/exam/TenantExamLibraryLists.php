<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\lists\exam;


use app\common\lists\BaseDataLists;
use app\common\model\exam\TenantExamLibrary;
use app\common\lists\ListsSearchInterface;


/**
 * 题库管理列表
 * Class TenantExamLibraryLists
 * @package app\platform\listsexam
 */
class TenantExamLibraryLists extends BaseDataLists implements ListsSearchInterface
{
    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public function setSearch(): array
    {
        return [
            '='      => ['is_show', 'category_uid', 'free_state', 'year', 'recommend_state', 'hot_state'],
            '%like%' => ['title', 'author'],
        ];
    }


    /**
     * @notes 获取题库管理列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public function lists(): array
    {
        return TenantExamLibrary::where($this->searchWhere)
            ->where([
                ['tenant_id', '=', $this->tenantId],
            ])
            ->with(["category" => function ($query) {
                $query->field(['uid', 'title']);
            }])
            ->append(['exam_count'])
            ->field(['id', 'uid', 'title', 'is_show', 'sort', 'create_time', 'image', 'remark', 'category_uid', 'author', 'free_state', 'money', 'discount', 'year', 'recommend_state', 'hot_state'])
            ->limit($this->limitOffset, $this->limitLength)
            ->order(['id' => 'desc'])
            ->select()
            ->toArray();
    }


    /**
     * @notes 获取题库管理数量
     * @return int
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public function count(): int
    {
        return TenantExamLibrary::where($this->searchWhere)->where([
            ['tenant_id', '=', $this->tenantId],
        ])->count();
    }

}