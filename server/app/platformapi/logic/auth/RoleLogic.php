<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\logic\auth;

use app\common\logic\BaseLogic;
use app\common\model\auth\SystemRole;
use app\common\model\auth\SystemRoleMenu;
use app\common\{cache\AdminAuthCache, model\auth\TenantSystemRole};
use think\facade\Db;


/**
 * 角色逻辑层
 * Class RoleLogic
 * @package app\platformapi\logic\auth
 */
class RoleLogic extends BaseLogic
{

    /**
     * @notes 添加角色
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2021/12/29 11:50
     */
    public static function add(array $params): bool
    {
        Db::startTrans();
        try {
            $menuId = !empty($params['menu_id']) ? $params['menu_id'] : [];

            $role = SystemRole::create([
                'name' => $params['name'],
                'desc' => $params['desc'] ?? '',
                'sort' => $params['sort'] ?? 0,
            ]);

            $data = [];
            foreach ($menuId as $item) {
                if (empty($item)) {
                    continue;
                }
                $data[] = [
                    'role_id' => $role['id'],
                    'menu_id' => $item,
                ];
            }
            (new SystemRoleMenu)->insertAll($data);

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            self::$error = $e->getMessage();
            return false;
        }
    }


    /**
     * @notes 编辑角色
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2021/12/29 14:16
     */
    public static function edit(array $params): bool
    {
        Db::startTrans();
        try {
            $menuId = !empty($params['menu_id']) ? $params['menu_id'] : [];

            SystemRole::update([
                'name' => $params['name'],
                'desc' => $params['desc'] ?? '',
                'sort' => $params['sort'] ?? 0,
            ], ['id' => $params['id']]);

            if (!empty($menuId)) {
                SystemRoleMenu::where(['role_id' => $params['id']])->delete();
                $data = [];
                foreach ($menuId as $item) {
                    $data[] = [
                        'role_id' => $params['id'],
                        'menu_id' => $item,
                    ];
                }
                (new SystemRoleMenu)->insertAll($data);
            }

            (new AdminAuthCache())->deleteTag();

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            self::$error = $e->getMessage();
            return false;
        }
    }

    /**
     * @notes 删除角色
     * @param int $id
     * @return bool
     * @author 兔兔答题
     * @date 2021/12/29 14:16
     */
    public static function delete(int $id)
    {
        SystemRole::destroy(['id' => $id]);
        (new AdminAuthCache())->deleteTag();
        return true;
    }


    /**
     * @notes 角色详情
     * @param int $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2021/12/29 14:17
     */
    public static function detail(int $id): array
    {
        $detail = SystemRole::field('id,name,desc,sort')->find($id);
        $authList = $detail->roleMenuIndex()->select()->toArray();
        $menuId = array_column($authList, 'menu_id');
        $detail['menu_id'] = $menuId;
        return $detail->toArray();
    }


    /**
     * @notes 角色数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 10:39
     */
    public static function getAllData()
    {
        $tenant_id = request()->param('tenant_id');
        $isTenant = $tenant_id !== null;
        $deptModel = $isTenant ? new TenantSystemRole() : new SystemRole();
        $sql = $deptModel->order(['sort' => 'desc', 'id' => 'desc']);
        if($isTenant) {
            $data = $sql->where('tenant_id', '=', $tenant_id)->select()->toArray();
        } else {
            $data = $sql->select()->toArray();
        }

        return $data;
    }
}