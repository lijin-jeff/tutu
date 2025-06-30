<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\lists\setting\pay;

use app\tenantapi\lists\BaseAdminDataLists;
use app\common\model\pay\TenantPayConfig;

/**
 * 支付配置列表
 * Class PayConfigLists
 * @package app\tenantapi\lists\setting\pay
 */
class PayConfigLists extends BaseAdminDataLists
{

    /**
     * @notes 获取列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/2/23 16:15
     */
    public function lists(): array
    {
        $lists = TenantPayConfig::field('id,name,pay_way,icon,sort')
            ->append(['pay_way_name'])
            ->order('sort','desc')
            ->select()
            ->toArray();

        return $lists;
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2023/2/23 16:15
     */
    public function count(): int
    {
        return TenantPayConfig::count();
    }



}