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

namespace app\tenantapi\lists\exam;


use app\common\lists\BaseDataLists;
use app\common\model\exam\TenantExamPaper;
use app\common\lists\ListsSearchInterface;


/**
 * 试卷管理列表
 * Class TenantExamPaperLists
 * @package app\platform\listsexam
 */
class TenantExamPaperLists extends BaseDataLists implements ListsSearchInterface
{


    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2025/06/10 13:57
     */
    public function setSearch(): array
    {
        return [
            '='      => ['is_show', 'is_rand'],
            '%like%' => ['title'],
        ];
    }


    /**
     * @notes 获取试卷管理列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2025/06/10 13:57
     */
    public function lists(): array
    {
        return TenantExamPaper::where($this->searchWhere)
            ->field(['id', 'uid', 'title', 'is_show', 'sort', 'create_time', 'update_time', 'is_rand', 'image', 'option_count', 'option_score', 'remark'])
            ->limit($this->limitOffset, $this->limitLength)
            ->order(['id' => 'desc'])
            ->select()
            ->toArray();
    }


    /**
     * @notes 获取试卷管理数量
     * @return int
     * @author 兔兔答题
     * @date 2025/06/10 13:57
     */
    public function count(): int
    {
        return TenantExamPaper::where($this->searchWhere)->count();
    }

}