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
use app\common\lists\ListsSearchInterface;
use app\common\model\exam\TenantExamChapter;


/**
 * 题库章节列表
 * Class TenantExamChapterLists
 * @package app\platform\listsexam
 */
class TenantExamChapterLists extends BaseDataLists implements ListsSearchInterface
{


    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2025/04/12 15:53
     */
    public function setSearch(): array
    {
        return [
            '='      => ['is_show', 'tenant_exam_library_uid'],
            '%like%' => ['title'],
        ];
    }


    /**
     * @notes 获取题库章节列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2025/04/12 15:53
     */
    public function lists(): array
    {
        return TenantExamChapter::where($this->searchWhere)
            ->field(['id', 'uid', 'title', 'is_show', 'sort', 'parent_uid', 'create_time', 'update_time'])
            ->where([
                ['tenant_id', '=', $this->tenantId],
                ["parent_uid", "=", ""]
            ])
            ->with(["children" => function ($query) {
                $query->field(['id', 'title', 'is_show', 'sort', 'parent_uid', "uid", 'create_time', 'update_time']);
            }])
            ->limit($this->limitOffset, $this->limitLength)
            ->order(['id' => 'desc'])
            ->select()
            ->toArray();
    }


    /**
     * @notes 获取题库章节数量
     * @return int
     * @author 兔兔答题
     * @date 2025/04/12 15:53
     */
    public function count(): int
    {
        return TenantExamChapter::where($this->searchWhere)->where([
            ['tenant_id', '=', $this->tenantId],
            ["parent_uid", "=", ""]
        ])->with(["children" => function ($query) {
            $query->count();
        }])->count();
    }

}