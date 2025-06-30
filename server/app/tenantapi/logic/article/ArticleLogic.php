<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\article;

use app\common\logic\BaseLogic;
use app\common\model\article\Article;
use app\common\model\article\ArticleCate;
use app\common\service\FileService;
use Exception;
use think\facade\Db;

/**
 * 资讯管理逻辑
 * Class ArticleLogic
 * @package app\tenantapi\logic\article
 */
class ArticleLogic extends BaseLogic
{

    /**
     * @notes  添加资讯
     * @param array $params
     * @author 兔兔答题
     * @date 2022/2/22 9:57
     */
    public static function add(array $params)
    {
        Article::create([
            'title'         => $params['title'],
            'desc'          => $params['desc'] ?? '',
            'author'        => $params['author'] ?? '', //作者
            'sort'          => $params['sort'] ?? 0, // 排序
            'abstract'      => $params['abstract'], // 文章摘要
            'click_virtual' => $params['click_virtual'] ?? 0,
            'image'         => $params['image'] ? FileService::setFileUrl($params['image']) : '',
            'cid'           => $params['cid'],
            'is_show'       => $params['is_show'],
            'content'       => $params['content'] ?? '',
        ]);
    }


    /**
     * @notes  编辑资讯
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/2/22 10:12
     */
    public static function edit(array $params): bool
    {
        try {
            Article::update([
                'title'         => $params['title'],
                'desc'          => $params['desc'] ?? '', // 简介
                'author'        => $params['author'] ?? '', //作者
                'sort'          => $params['sort'] ?? 0, // 排序
                'abstract'      => $params['abstract'], // 文章摘要
                'click_virtual' => $params['click_virtual'] ?? 0,
                'image'         => $params['image'] ? FileService::setFileUrl($params['image']) : '',
                'cid'           => $params['cid'],
                'is_show'       => $params['is_show'],
                'content'       => $params['content'] ?? '',
            ], ['id' => $params['id']]);
            return true;
        } catch (Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes  删除资讯
     * @param array $params
     * @author 兔兔答题
     * @date 2022/2/22 10:17
     */
    public static function delete(array $params)
    {
        Article::destroy($params['id']);
    }

    /**
     * @notes  查看资讯详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2022/2/22 10:15
     */
    public static function detail($params): array
    {
        return Article::findOrEmpty($params['id'])->toArray();
    }

    /**
     * @notes  更改资讯状态
     * @param array $params
     * @return false|void
     * @author 兔兔答题
     * @date 2022/2/22 10:18
     */
    public static function updateStatus(array $params)
    {
        try {
            Article::update([
                'is_show' => $params['is_show']
            ], ['id' => $params['id']]);
        } catch (Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }

    /**
     * @notes 初始化租户文章列表
     * @param mixed $tenant_id
     * @return void
     * @throws Exception
     * @author yfdong
     * @date 2024/09/10 20:59
     */
    public static function initialization(mixed $tenant_id): void
    {
        Db::startTrans();
        try {
            $articleField = 'tenant_id,cid,title,desc,abstract,image,author,content,click_virtual,click_actual,is_show,sort';
            $articleCateField = 'id,tenant_id,name,sort,is_show';

            $templateArticle = Article::where('tenant_id', 0)->field($articleField)->select()->toArray();
            $templateArticleCate = ArticleCate::where('tenant_id', 0)->field($articleCateField)->select()->toArray();

            foreach ($templateArticle as $item) {
                $item['tenant_id'] = $tenant_id;
                foreach ($templateArticleCate as $citem) {
                    if ($item['cid'] === $citem['id']) {
                        $citem['tenant_id'] = $tenant_id;
                        unset($citem['id']);
                        $cate = ArticleCate::create($citem);
                        $item['cid'] = $cate->id;
                    }
                }
                Article::create($item);
            }
            Db::commit();
        } catch (Exception) {
            Db::rollback();
            throw new Exception('文章初始化失败');
        }
    }
}