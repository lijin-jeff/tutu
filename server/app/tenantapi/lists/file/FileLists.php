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

use app\common\enum\FileEnum;
use app\tenantapi\lists\BaseAdminDataLists;
use app\tenantapi\logic\FileLogic;
use app\common\lists\ListsSearchInterface;
use app\common\model\file\TenantFile;
use app\common\service\FileService;

/**
 * 文件列表
 * Class FileLists
 * @package app\tenantapi\lists\file
 */
class FileLists extends BaseAdminDataLists implements ListsSearchInterface
{

    /**
     * @notes 文件搜索条件
     * @return \string[][]
     * @author 兔兔答题
     * @date 2021/12/29 14:27
     */
    public function setSearch(): array
    {
        return [
            '='      => ['type', 'source'],
            '%like%' => ['name']
        ];
    }

    /**
     * @notes 额外查询处理
     * @return array
     * @author 兔兔答题
     * @date 2024/2/7 10:26
     */
    public function queryWhere(): array
    {
        $where = [];
        // 如果cid为0则为未分组
        if ("0" === $this->params['cid']) {
            $where[] = ['cid', '=', '0'];
        }
        if (!empty($this->params['cid'])) {
            $cateChild = FileLogic::getCateIds($this->params['cid']);
            $cateChild[] = (int)$this->params['cid'];
            $where[] = ['cid', 'in', $cateChild];
        }

        return $where;
    }


    /**
     * @notes 获取文件列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2021/12/29 14:27
     */
    public function lists(): array
    {
        $lists = (new TenantFile())->field(['id,cid,type,name,uri,create_time'])
            ->order('id', 'desc')
            ->where($this->searchWhere)
            ->where($this->queryWhere())
            ->where('source', FileEnum::SOURCE_ADMIN)
            ->limit($this->limitOffset, $this->limitLength)
            ->select()
            ->toArray();

        foreach ($lists as &$item) {
            $item['url'] = FileService::getFileUrl($item['uri']);
        }

        return $lists;
    }


    /**
     * @notes 获取文件数量
     * @return int
     * @author 兔兔答题
     * @date 2021/12/29 14:29
     */
    public function count(): int
    {
        return (new TenantFile())->where($this->searchWhere)
            ->where($this->queryWhere())
//            ->where('source', FileEnum::SOURCE_ADMIN)
            ->count();
    }
}
