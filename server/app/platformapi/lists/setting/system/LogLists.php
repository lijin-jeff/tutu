<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\lists\setting\system;


use app\platformapi\lists\BaseAdminDataLists;
use app\common\lists\ListsExcelInterface;
use app\common\lists\ListsSearchInterface;
use app\common\model\OperationLog;

/**
 * 日志列表
 * Class LogLists
 * @package app\platformapi\lists\setting\system
 */
class LogLists extends BaseAdminDataLists implements ListsSearchInterface, ListsExcelInterface
{
    /**
     * @notes 设置搜索条件
     * @return \string[][]
     * @author ljj
     * @date 2021/8/3 4:21 下午
     */
    public function setSearch(): array
    {
        return [
            '%like%' => ['admin_name','url','ip','type'],
            'between_time' => 'create_time',
        ];
    }

    /**
     * @notes 查看系统日志列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author ljj
     * @date 2021/8/3 4:21 下午
     */
    public function lists(): array
    {
        $lists = OperationLog::field('id,action,admin_name,admin_id,url,type,params,ip,create_time')
            ->where($this->searchWhere)
            ->limit($this->limitOffset, $this->limitLength)
            ->order('id','desc')
            ->select()
            ->toArray();

        return $lists;
    }

    /**
     * @notes 查看系统日志总数
     * @return int
     * @author ljj
     * @date 2021/8/3 4:23 下午
     */
    public function count(): int
    {
        return OperationLog::where($this->searchWhere)->count();
    }

    /**
     * @notes 设置导出字段
     * @return string[]
     * @author ljj
     * @date 2021/8/3 4:48 下午
     */
    public function setExcelFields(): array
    {
        return [
            // '数据库字段名(支持别名) => 'Excel表字段名'
            'id' => '记录ID',
            'action' => '操作',
            'admin_name' => '管理员',
            'admin_id' => '管理员ID',
            'url' => '访问链接',
            'type' => '访问方式',
            'params' => '访问参数',
            'ip' => '来源IP',
            'create_time' => '日志时间',
        ];
    }

    /**
     * @notes 设置默认表名
     * @return string
     * @author ljj
     * @date 2021/8/3 4:48 下午
     */
    public function setFileName(): string
    {
        return '系统日志';
    }
}