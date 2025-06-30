<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\lists\dept;

use app\tenantapi\lists\BaseAdminDataLists;
use app\common\lists\ListsExcelInterface;
use app\common\lists\ListsSearchInterface;
use app\common\model\dept\TenantJobs;

/**
 * 岗位列表
 * Class JobsLists
 * @package app\tenantapi\lists\dept
 */
class JobsLists extends BaseAdminDataLists implements ListsSearchInterface,ListsExcelInterface
{

    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2022/5/26 9:46
     */
    public function setSearch(): array
    {
        return [
            '%like%' => ['name'],
            '=' => ['code', 'status']
        ];
    }


    /**
     * @notes  获取管理列表
     * @return array
     * @author 兔兔答题
     * @date 2022/2/21 17:11
     */
    public function lists(): array
    {
        $lists = TenantJobs::where($this->searchWhere)
            ->append(['status_desc'])
            ->limit($this->limitOffset, $this->limitLength)
            ->order(['sort' => 'desc', 'id' => 'desc'])
            ->select()
            ->toArray();

        return $lists;
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2022/5/26 9:48
     */
    public function count(): int
    {
        return TenantJobs::where($this->searchWhere)->count();
    }


    /**
     * @notes 导出文件名
     * @return string
     * @author 兔兔答题
     * @date 2022/11/24 16:17
     */
    public function setFileName(): string
    {
        return '岗位列表';
    }


    /**
     * @notes 导出字段
     * @return string[]
     * @author 兔兔答题
     * @date 2022/11/24 16:17
     */
    public function setExcelFields(): array
    {
        return [
            'code' => '岗位编码',
            'name' => '岗位名称',
            'remark' => '备注',
            'status_desc' => '状态',
            'create_time' => '添加时间',
        ];
    }

}