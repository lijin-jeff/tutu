<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\logic;

use app\common\enum\YesNoEnum;
use app\common\logic\BaseLogic;
use app\common\model\article\Article;
use app\common\model\article\ArticleCate;
use app\common\model\article\ArticleCollect;


/**
 * 文章逻辑
 * Class ArticleLogic
 * @package app\api\logic
 */
class ArticleLogic extends BaseLogic
{

    /**
     * @notes 文章详情
     * @param $articleId
     * @param $userId
     * @return array
     * @author 兔兔答题
     * @date 2022/9/20 17:09
     */
    public static function detail($articleId, $userId)
    {
        // 文章详情
        $article = Article::getArticleDetailArr($articleId);
        // 关注状态
        $article['collect']     = ArticleCollect::isCollectArticle($userId, $articleId);
        $article['create_time'] = date('Y-m-d', strtotime($article['create_time']));
        $article['is_share']    = false;
        $article['share_count'] = mt_rand(0, 100);
        return $article;
    }


    /**
     * @notes 加入收藏
     * @param $userId
     * @param $articleId
     * @author 兔兔答题
     * @date 2022/9/20 16:52
     */
    public static function addCollect($articleId, $userId): void
    {
        $where   = ['user_id' => $userId, 'article_id' => $articleId];
        $collect = ArticleCollect::where($where)->findOrEmpty();
        if ($collect->isEmpty()) {
            ArticleCollect::create([
                'user_id'    => $userId,
                'article_id' => $articleId,
                'status'     => YesNoEnum::YES
            ]);
        } else {
            ArticleCollect::update([
                'status' => YesNoEnum::YES
            ], ['id' => $collect['id']]);
        }
    }


    /**
     * @notes 取消收藏
     * @param $articleId
     * @param $userId
     * @author 兔兔答题
     * @date 2022/9/20 16:59
     */
    public static function cancelCollect($articleId, $userId): void
    {
        ArticleCollect::update(['status' => YesNoEnum::NO], [
            'user_id'    => $userId,
            'article_id' => $articleId,
            'status'     => YesNoEnum::YES
        ]);
    }


    /**
     * @notes 文章分类
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/23 14:11
     */
    public static function cate()
    {
        return ArticleCate::field('id,name')
            ->where('is_show', '=', 1)
            ->order(['sort' => 'desc', 'id' => 'desc'])
            ->select()->toArray();
    }

}