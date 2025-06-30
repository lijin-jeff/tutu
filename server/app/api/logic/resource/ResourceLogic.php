<?php
// +----------------------------------------------------------------------
// | 兔兔答题开发团队介绍
// +----------------------------------------------------------------------
// | 欢迎你使用本套系统，本套系统由兔兔答题开发团队全力开发。
// | 如果本套系统是商业系统，请严格遵守系统使用相关协议，出现违背协议的法律行为，所有违法行为均与兔兔答题无关。
// | 官网地址：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题团队 版权所有 拥有最终解释权
// +----------------------------------------------------------------------
// | 作者: 兔兔答题开发团队
// +----------------------------------------------------------------------
namespace app\api\logic\resource;

use app\common\logic\BaseLogic;
use app\common\model\resource\TenantResource;
use app\common\model\resource\TenantResourceCategory;
use app\common\model\resource\TenantResourceCollect;
use think\facade\Db;

class ResourceLogic extends BaseLogic
{
    /**
     * 资源分类树
     * @return array
     */
    public static function categoryList(): array
    {
        $items = TenantResourceCategory::where([
            ["parent_uid", "=", ""]
        ])->with(["children" => function ($query) {
            $query->field(["parent_uid", "uid", "title as label"]);
        }])->field(["parent_uid", "uid", "title as label"])->select()->toArray();
        foreach ($items as $key => $value) {
            $items[$key]["value"] = $value["uid"];
            foreach ($value["children"] as $k => $v) {
                $items[$key]["children"][$k]["value"] = $v["uid"];
                unset($items[$key]["children"][$k]["uid"]);
            }
            unset($items[$key]["uid"]);
        }
        return $items;
    }

    /**
     * 资源列表
     * @param array $params
     * @return array
     */
    public static function resourceList(array $params): array
    {
        $pageNo = (int)(isset($params['page_no']) ? $params['page_no'] : 1);
        $pageSize = (int)(isset($params['page_size']) ? $params['page_size'] : 20);
        $pageSize = min($pageSize, 20);
        $items = TenantResource::query()->where([['is_show', '=', 1]])
            ->where(function ($query) use ($params) {
                if (!empty($params['category_uid'])) {
                    $query->where('category_uid', '=', $params['category_uid']);
                }
                if (!empty($params['keywords'])) {
                    $query->whereLike('title', '%' . $params['keywords'] . '%');
                }
            })
            ->with(['category' => function ($query) {
                $query->field(['uid', 'title']);
            }])
            ->field(['uid', 'category_uid', 'title', 'image', 'year', 'free_state', 'view_count', 'download_count'])
            ->paginate([
                'list_rows' => $pageSize,
                'page'      => $pageNo
            ]);

        return [
            'lists'     => $items->items(),
            'page_no'   => $pageNo,
            'page_size' => $pageSize,
            'count'     => $items->total(),
            'extend'    => []
        ];
    }

    /**
     * 资源详情
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function resourceContent(array $params): array
    {
        $resource = TenantResource::query()->where([
            ['uid', '=', $params['uid']],
            ['is_show', '=', 1]
        ])->field(['uid', 'title', 'remark', 'free_state', 'money', 'author', 'year', 'view_count', 'download_count'])->findOrEmpty();
        if ($resource->isEmpty()) return [];
        TenantResource::query()->where([
            ['uid', '=', $params['uid']]
        ])->update(['view_count' => Db::raw('view_count + 1')]);
        $resource = $resource->toArray();
        $resource['collection_state'] = false;
        if (!empty($params['user_uid'])) {
            $collection = TenantResourceCollect::query()->where([
                ['resource_uid', '=', $params['uid']],
                ['user_uid', '=', $params['user_uid']]
            ])->value('id');
            if (!empty($collection)) $resource['collection_state'] = true;
        }
        return $resource;
    }

    /**
     * 下载资源
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function resourceDownload(array $params): array
    {
        $resource = TenantResource::query()->where([
            ['uid', '=', $params['uid']],
            ['is_show', '=', 1]
        ])->field(['file_url'])->findOrEmpty();
        if ($resource->isEmpty()) return [];
        return $resource->toArray();
    }

    /**
     * 资源收藏
     * @param array $params
     * @return bool
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function resourceCollection(array $params): bool
    {
        try {
            TenantResourceCollect::create([
                'resource_uid' => $params['uid'],
                'user_uid'     => $params['user_uid']
            ]);
            return true;
        } catch (\Exception $exception) {
            $str = "";
            preg_match("/t_tenant_resource_collect.idx_ur/", $exception->getMessage(), $str);
            if (!empty($str)) {
                self::setError('已收藏');
            } else {
                self::setError($exception->getMessage());
            }
        }
        return false;
    }
}
