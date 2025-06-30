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
use app\common\model\exam\TenantExamExamination;


/**
 * 考试管理列表
 * Class TenantExamExaminationLists
 * @package app\platform\listsexam
 */
class TenantExamExaminationLists extends BaseDataLists implements ListsSearchInterface
{


    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2025/04/13 21:43
     */
    public function setSearch(): array
    {
        return [
            '='      => ['is_show', 'privilege', 'submit_count_type'],
            '%like%' => ['title'],
            ">="     => ['start_time'],
            "<="     => ['end_time'],
        ];
    }


    /**
     * @notes 获取考试管理列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2025/04/13 21:43
     */
    public function lists(): array
    {
        return TenantExamExamination::where($this->searchWhere)
            ->where([
                ["tenant_id", "=", $this->tenantId],
            ])
            ->with(['paper' => function ($query) {
                $query->field(['uid', 'title']);
            }])
            ->field(['id', 'title', 'score', 'sort', 'is_show', 'create_time', 'start_time', 'end_time', 'privilege', 'exam_time', 'exam_submit_type', 'login_style', 'content', 'paper_uid', 'image'])
            ->limit($this->limitOffset, $this->limitLength)
            ->order(['id' => 'desc'])
            ->select()
            ->toArray();
    }


    /**
     * @notes 获取考试管理数量
     * @return int
     * @author 兔兔答题
     * @date 2025/04/13 21:43
     */
    public function count(): int
    {
        return TenantExamExamination::where($this->searchWhere)->where([
            ["tenant_id", "=", $this->tenantId],
        ])->count();
    }

}