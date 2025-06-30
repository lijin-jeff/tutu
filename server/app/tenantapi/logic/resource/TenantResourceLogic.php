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


use app\common\logic\BaseLogic;
use app\common\model\resource\TenantResource;
use think\facade\Db;


/**
 * 资源管理逻辑
 * Class TenantResourceLogic
 * @package app\platform\logic\resource
 */
class TenantResourceLogic extends BaseLogic
{


    /**
     * @notes 添加资源管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public static function add(array $params): bool
    {
        try {
            TenantResource::create([
                'title'        => $params['title'],
                'is_show'      => $params['is_show'],
                'sort'         => $params['sort'],
                'image'        => $params['image'],
                'remark'       => $params['remark'],
                'category_uid' => $params['category_uid'],
                'author'       => $params['author'],
                'free_state'   => $params['free_state'],
                'money'        => empty($params['money']) ? 0 : $params['money'],
                'year'         => $params['year'],
                'file_url'     => $params['file_url'],
                'uid'          => uid(),
                'tenant_id'    => $params['tenant_id'],
            ]);
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 编辑资源管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public static function edit(array $params): bool
    {
        try {
            TenantResource::where([
                ['id', '=', $params['id']],
                ['tenant_id', '=', $params['tenant_id']]
            ])->update([
                'title'        => $params['title'],
                'is_show'      => $params['is_show'],
                'sort'         => $params['sort'],
                'image'        => $params['image'],
                'remark'       => $params['remark'],
                'category_uid' => $params['category_uid'],
                'author'       => $params['author'],
                'free_state'   => $params['free_state'],
                'file_url'     => $params['file_url'],
                'money'        => empty($params['money']) ? 0 : $params['money'],
                'year'         => $params['year']
            ]);
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 删除资源管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public static function delete(array $params): bool
    {
        return TenantResource::destroy($params['id']);
    }


    /**
     * @notes 获取资源管理详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2025/06/17 00:37
     */
    public static function detail($params): array
    {
        return TenantResource::query()->where([
            ['id', '=', $params['id']],
            ['tenant_id', '=', $params['tenant_id']]
        ])->findOrEmpty();
    }
}