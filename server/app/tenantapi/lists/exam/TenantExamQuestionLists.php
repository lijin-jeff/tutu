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
use app\common\model\exam\TenantExamQuestion;


/**
 * 试题管理列表
 * Class TenantExamQuestionLists
 * @package app\platform\listsexam
 */
class TenantExamQuestionLists extends BaseDataLists implements ListsSearchInterface
{


    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public function setSearch(): array
    {
        return [
            '='      => ['exam_type', 'is_show', 'level', 'tenant_exam_library_uid'],
            '%like%' => ['title'],
        ];
    }


    /**
     * @notes 获取试题管理列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public function lists(): array
    {
        $items = TenantExamQuestion::where($this->searchWhere)
            ->where([
                ["tenant_id", "=", $this->tenantId],
            ])
            ->field(['id', 'title', 'score', 'answer', 'exam_type', 'sort', 'is_show', 'create_time', 'level', 'chapter_uid'])
            ->limit($this->limitOffset, $this->limitLength)
            ->order(['id' => 'desc'])
            ->select()
            ->toArray();
        foreach ($items as &$item) {
            $item["title"] = strip_tags(html_entity_decode($item["title"]));
            $item["answer"] = implode(",", $item["answer"]);
        }
        return $items;
    }


    /**
     * @notes 获取试题管理数量
     * @return int
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public function count(): int
    {
        return TenantExamQuestion::where($this->searchWhere)->where([
            ["tenant_id", "=", $this->tenantId],
        ])->count();
    }

}