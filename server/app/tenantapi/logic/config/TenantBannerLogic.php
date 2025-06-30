<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\config;


use app\common\logic\BaseLogic;
use app\common\model\config\TenantBanner;
use think\facade\Db;


/**
 * 轮播图管理逻辑
 * Class TenantBannerLogic
 * @package app\platform\logic\config
 */
class TenantBannerLogic extends BaseLogic
{


    /**
     * @notes 添加轮播图管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public static function add(array $params): bool
    {
        $model = TenantBanner::create([
            'uid'        => uid(),
            'title'      => $params['title'] ?? '',
            'is_show'    => $params['is_show'],
            'sort'       => $params['sort'],
            'position'   => $params['position'],
            'client'     => $params['client'],
            'image'      => $params['image'] ?? '',
            'tenant_id'  => $params['tenant_id'],
            'image_type' => $params['image_type'],
            'icon'       => $params['icon'],
            'url'        => $params['url'] ?? ''
        ]);
        return !empty($model->getKey()) ? true : false;
    }


    /**
     * @notes 编辑轮播图管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public static function edit(array $params): bool
    {
        return TenantBanner::where([
                ['id', '=', $params['id']],
                ['tenant_id', "=", $params['tenant_id']]
            ])->update([
                'title'      => $params['title'] ?? '',
                'is_show'    => $params['is_show'],
                'sort'       => $params['sort'],
                'position'   => $params['position'],
                'client'     => $params['client'],
                'image'      => $params['image'] ?? '',
                'image_type' => $params['image_type'],
                'icon'       => $params['icon'],
                'url'        => $params['url'] ?? ''
            ]) > 0;
    }


    /**
     * @notes 删除轮播图管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public static function delete(array $params): bool
    {
        if (is_array($params["id"])) {
            return TenantBanner::whereIn("id", $params["id"])->where([
                    ['tenant_id', '=', $params['tenant_id']]
                ])->update(['delete_time' => time()]) > 0;
        }
        return TenantBanner::where([
                ['id', '=', $params['id']],
                ['tenant_id', '=', $params['tenant_id']]
            ])->update(['delete_time' => time()]) > 0;
    }


    /**
     * @notes 获取轮播图管理详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2025/05/01 00:46
     */
    public static function detail($params): array
    {
        return TenantBanner::where([
            ['id', '=', $params['id']],
            ['tenant_id', '=', $params['tenant_id']]
        ])->find()->toArray();
    }
}