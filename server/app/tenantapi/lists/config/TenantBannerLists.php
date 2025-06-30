<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
declare(strict_types=1);

namespace app\tenantapi\lists\config;


use app\common\lists\BaseDataLists;
use app\common\lists\ListsSearchInterface;
use app\common\model\config\TenantBanner;


/**
 * 轮播图管理列表
 * Class TenantBannerLists
 * @package app\platform\listsconfig
 */
class TenantBannerLists extends BaseDataLists implements ListsSearchInterface
{


    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function setSearch(): array
    {
        return [
            '='      => ['is_show', 'sort', 'position', 'client', 'image_type'],
            '%like%' => ['title'],
        ];
    }


    /**
     * @notes 获取轮播图管理列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function lists(): array
    {
        return TenantBanner::where($this->searchWhere)
            ->where([
                ['tenant_id', '=', $this->tenantId],
            ])
            ->field(['id', 'title', 'is_show', 'sort', 'create_time', 'update_time', 'position', 'client', 'image', 'image_type', 'url', 'icon'])
            ->limit($this->limitOffset, $this->limitLength)
            ->order(['id' => 'desc'])
            ->select()
            ->toArray();
    }


    /**
     * @notes 获取轮播图管理数量
     * @return int
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public function count(): int
    {
        return TenantBanner::where($this->searchWhere)->where([
            ['tenant_id', '=', $this->tenantId],
        ])->count();
    }

}