<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\lists\article;

use app\tenantapi\lists\BaseAdminDataLists;
use app\common\lists\ListsSearchInterface;
use app\common\lists\ListsSortInterface;
use app\common\model\article\ArticleCate;

/**
 * 资讯分类列表
 * Class ArticleCateLists
 * @package app\tenantapi\lists\article
 */
class ArticleCateLists extends BaseAdminDataLists implements ListsSearchInterface, ListsSortInterface
{


    /**
     * @notes  设置搜索条件
     * @return array
     * @author 兔兔答题
     * @date 2022/2/8 18:39
     */
    public function setSearch(): array
    {
        return [];
    }

    /**
     * @notes  设置支持排序字段
     * @return array
     * @author 兔兔答题
     * @date 2022/2/9 15:11
     */
    public function setSortFields(): array
    {
        return ['create_time' => 'create_time', 'id' => 'id'];
    }

    /**
     * @notes  设置默认排序
     * @return array
     * @author 兔兔答题
     * @date 2022/2/9 15:08
     */
    public function setDefaultOrder(): array
    {
        return ['sort' => 'desc','id' => 'desc'];
    }

    /**
     * @notes  获取管理列表
     * @return array
     * @author 兔兔答题
     * @date 2022/2/21 17:11
     */
    public function lists(): array
    {
        $ArticleCateLists = ArticleCate::where($this->searchWhere)
            ->append(['is_show_desc'])
            ->limit($this->limitOffset, $this->limitLength)
            ->order($this->sortOrder)
            ->append(['article_count'])
            ->select()
            ->toArray();

        return $ArticleCateLists;
    }

    /**
     * @notes  获取数量
     * @return int
     * @author 兔兔答题
     * @date 2022/2/9 15:12
     */
    public function count(): int
    {
        return ArticleCate::where($this->searchWhere)->count();
    }

    public function extend()
    {
        return [];
    }
}