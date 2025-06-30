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
use app\common\model\exam\TenantExamLibrary;
use app\common\service\FileService;
use think\facade\Db;


/**
 * 题库管理逻辑
 * Class TenantExamLibraryLogic
 * @package app\platform\logic\exam
 */
class TenantExamLibraryLogic extends BaseLogic
{


    /**
     * @notes 添加题库管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public static function add(array $params): bool
    {
        try {
            $model = TenantExamLibrary::create([
                'uid'             => uid(),
                'title'           => $params['title'],
                'is_show'         => $params['is_show'],
                'sort'            => $params['sort'],
                'image'           => $params['image'] ? FileService::setFileUrl($params['image']) : '',
                'remark'          => $params['remark'],
                'category_uid'    => $params['category_uid'],
                'author'          => $params['author'],
                'free_state'      => $params['free_state'],
                'money'           => $params['money'],
                'discount'        => $params['discount'],
                'year'            => $params['year'],
                'tenant_id'       => $params['tenant_id'],
                'recommend_state' => $params['recommend_state'],
                'hot_state'       => $params['hot_state'],
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
     * @notes 编辑题库管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public static function edit(array $params): bool
    {
        try {
            $row = TenantExamLibrary::where([
                ['id', '=', $params['id']],
                ['tenant_id', '=', $params['tenant_id']]
            ])->update([
                'title'           => $params['title'],
                'is_show'         => $params['is_show'],
                'sort'            => $params['sort'],
                'image'           => $params['image'] ? FileService::setFileUrl($params['image']) : '',
                'remark'          => $params['remark'],
                'category_uid'    => $params['category_uid'],
                'author'          => $params['author'],
                'free_state'      => $params['free_state'],
                'money'           => $params['money'],
                'discount'        => $params['discount'],
                'year'            => $params['year'],
                'recommend_state' => $params['recommend_state'],
                'hot_state'       => $params['hot_state'],
            ]);
            return $row > 0;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 删除题库管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public static function delete(array $params): bool
    {
        if (is_array($params["id"])) {
            return TenantExamLibrary::whereIn("id", $params["id"])->where([
                    ['tenant_id', '=', $params['tenant_id']]
                ])->update(['delete_time' => time()]) > 0;
        }
        return TenantExamLibrary::where([
                ['id', '=', $params['id']],
                ['tenant_id', '=', $params['tenant_id']]
            ])->update(['delete_time' => time()]) > 0;
    }


    /**
     * @notes 获取题库管理详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2025/04/01 04:41
     */
    public static function detail($params): array
    {
        return TenantExamLibrary::where([
            ['id', '=', $params['id']],
            ['tenant_id', '=', $params['tenant_id']]
        ])->find()->toArray();
    }
}