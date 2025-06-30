<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\lists\tools;

use app\platformapi\lists\BaseAdminDataLists;
use think\facade\Db;


/**
 * 数据表列表
 * Class GeneratorLists
 * @package app\platformapi\lists\tools
 */
class DataTableLists extends BaseAdminDataLists
{

    /**
     * @notes 查询结果
     * @return mixed
     * @author 兔兔答题
     * @date 2022/6/13 18:54
     */
    public function queryResult()
    {
        $sql = 'SHOW TABLE STATUS WHERE 1=1 ';
        if (!empty($this->params['name'])) {
            $sql .= "AND name LIKE '%" . $this->params['name'] . "%'";
        }
        if (!empty($this->params['comment'])) {
            $sql .= "AND comment LIKE '%" . $this->params['comment'] . "%'";
        }
        return Db::query($sql);
    }


    /**
     * @notes 处理列表
     * @return array
     * @author 兔兔答题
     * @date 2022/6/13 18:54
     */
    public function lists(): array
    {
        $lists = array_map("array_change_key_case", $this->queryResult());
        $offset = max(0, ($this->pageNo - 1) * $this->pageSize);
        $lists = array_slice($lists, $offset, $this->pageSize, true);
        return array_values($lists);
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2022/6/13 18:54
     */
    public function count(): int
    {
        return count($this->queryResult());
    }

}