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

namespace app\tenantapi\logic\resource;


use app\common\model\resource\TenantResourceCategory;
use app\common\logic\BaseLogic;
use think\facade\Db;


/**
 * 资源分类逻辑
 * Class TenantResourceCategoryLogic
 * @package app\platform\logic\resource
 */
class TenantResourceCategoryLogic extends BaseLogic
{
    /**
     * 资源分类
     * @param array $params
     * @return array
     */
    public static function parentList(array $params): array
    {
        return TenantResourceCategory::where([
            ['tenant_id', '=', $params['tenant_id']],
            ["parent_uid", "=", '']
        ])->column(["uid as value", "title as label"]);
    }

    /**
     * @notes 添加资源分类
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/06/16 23:36
     */
    public static function add(array $params): bool
    {
        try {
            TenantResourceCategory::create([
                'uid'        => uid(),
                'title'      => $params['title'],
                'is_show'    => $params['is_show'],
                'sort'       => $params['sort'],
                'parent_uid' => empty($params['parent_uid']) ? '' : $params['parent_uid'],
                'image'      => $params['image'],
                'tenant_id'  => $params['tenant_id'],
            ]);
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 编辑资源分类
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/06/16 23:36
     */
    public static function edit(array $params): bool
    {
        try {
            TenantResourceCategory::where([
                ['id', '=', $params['id']],
                ['tenant_id', '=', $params['tenant_id']]
            ])->update([
                'title'      => $params['title'],
                'is_show'    => $params['is_show'],
                'sort'       => $params['sort'],
                'parent_uid' => empty($params['parent_uid']) ? '' : $params['parent_uid'],
                'image'      => $params['image']
            ]);
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 删除资源分类
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/06/16 23:36
     */
    public static function delete(array $params): bool
    {
        return TenantResourceCategory::destroy($params['id']);
    }


    /**
     * @notes 获取资源分类详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2025/06/16 23:36
     */
    public static function detail($params): array
    {
        return TenantResourceCategory::query()->where([
            ['id', '=', $params['id']],
            ['tenant_id', '=', $params['tenant_id']]
        ])->findOrEmpty();
    }

    /**
     * 分类树
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @date 2024/4/21 00:45
     * @author 兔兔答题
     */
    public static function categoryTree(array $params): array
    {
        $items = TenantResourceCategory::where([
            ['tenant_id', '=', $params['tenant_id']],
            ["parent_uid", "=", ""]
        ])->with(["children" => function ($query) {
            $query->field(["parent_uid", "uid", "title as label"]);
        }])->field(["parent_uid", "uid", "title as label"])->select()->toArray();
        foreach ($items as $key => $value) {
            $items[$key]["value"] = $value["uid"];
            foreach ($value["children"] as $k => $v) {
                $items[$key]["children"][$k]["value"] = $v["uid"];
                unset($items[$key]["children"][$k]["uid"], $items[$key]["children"][$k]["parent_uid"]);
            }
            unset($items[$key]["uid"]);
        }
        return $items;
    }
}