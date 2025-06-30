<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\platformapi\logic\tenant;

use app\common\model\auth\TenantSystemMenu;

/**
 * 租户菜单逻辑
 *  Class TenantSystemMenuLogic
 * @package app\platformapi\logic\tenant
 */
class TenantSystemMenuLogic
{

    /**
     * @notes 初始化租户菜单信息
     * @param $tenant_id
     * @author yfdong
     * @date 2024/09/05 22:15
     */
    public static function initialization($tenant_id)
    {
        //初始化租户菜单字段
        $field = "id,pid,type,name,icon,sort,perms,paths,component,selected,params,is_cache,is_show,is_disable,tenant_id";
        //查询模板菜单配置文件 此处默认为租户号为0的模板数据
        $tenantSystemMenuList = TenantSystemMenu::where(['tenant_id' => 0])->field($field)->order('pid')->select()->toArray();
        //记录对应的关系
        foreach ($tenantSystemMenuList as $item) {
            $tenantSystemMenu[$item['id']] = $item;
        }
        //创建菜单数据
        foreach ($tenantSystemMenuList as $item) {
            $item['tenant_id'] = $tenant_id;
            //创建新的菜单并保存原本id对应现在的哪个信息
            $oldId = $item['id'];
            unset($item['id']);
            $newMenu = TenantSystemMenu::create($item);
            $tenantSystemMenu[$oldId] = $newMenu;
        }
        //获取当前租户的初始化菜单关系
        $tenantSystemMenuNewList = TenantSystemMenu::where(['tenant_id' => $tenant_id])->field($field)->order('pid')->select()->toArray();
        //更新对应的主菜单关系
        foreach ($tenantSystemMenuNewList as $item) {
            if ($item['pid'] != 0)
                $item['pid'] = $tenantSystemMenu[$item['pid']]['id'];
            $where = array('id' => intval($item['id']));
            TenantSystemMenu::update($item, $where);
        }
    }
}