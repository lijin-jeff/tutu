<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\exam;


use app\common\logic\BaseLogic;
use app\common\model\exam\TenantExamCategory;


/**
 * 题库分类逻辑
 * Class ExamCategoryLogic
 * @package app\platform\logic\exam
 */
class ExamCategoryLogic extends BaseLogic
{
    /**
     * 查询一级分类
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/4/1 02:58
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function parentList(array $params): array
    {
        return TenantExamCategory::where([
            ['tenant_id', '=', $params['tenant_id']],
            ["parent_uid", "=", '']
        ])->column(["uid as value", "title as label"]);
    }

    /**
     * @notes 添加题库分类
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/04/01 01:51
     */
    public static function add(array $params): bool
    {
        try {
            $model = TenantExamCategory::create([
                'title'        => $params['title'],
                'is_show'      => $params['is_show'],
                'sort'         => $params['sort'],
                'cover'        => $params['cover'],
                'is_recommend' => $params['is_recommend'],
                'icon'         => $params['icon'],
                'uid'          => uid(),
                "parent_uid"   => $params["parent_uid"] ?? "",
                'tenant_id'    => $params['tenant_id'],
            ]);
            if (!$model->getKey()) {
                return false;
            }
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 编辑题库分类
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/04/01 01:51
     */
    public static function edit(array $params): bool
    {
        try {
            $row = TenantExamCategory::where([
                ['id', '=', $params['id']],
                ['tenant_id', '=', $params['tenant_id']]
            ])->update([
                'title'        => $params['title'],
                'is_show'      => $params['is_show'],
                'sort'         => $params['sort'],
                'cover'        => $params['cover'],
                'is_recommend' => $params['is_recommend'],
                'icon'         => $params['icon'],
                "parent_uid"   => $params["parent_uid"] ?? '',
            ]);
            return $row > 0;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 删除题库分类
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/04/01 01:51
     */
    public static function delete(array $params): bool
    {
        if (is_array($params["id"])) {
            return TenantExamCategory::whereIn("id", $params["id"])->where([
                    ['tenant_id', '=', $params['tenant_id']]
                ])->update(['delete_time' => time()]) > 0;
        }
        return TenantExamCategory::where([
                ['id', '=', $params['id']],
                ['tenant_id', '=', $params['tenant_id']]
            ])->update(['delete_time' => time()]) > 0;
    }


    /**
     * @notes 获取题库分类详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2025/04/01 01:51
     */
    public static function detail($params): array
    {
        return TenantExamCategory::where([
            ['id', '=', $params['id']],
            ['tenant_id', '=', $params['tenant_id']]
        ])->find()->toArray();
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
        $items = TenantExamCategory::where([
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