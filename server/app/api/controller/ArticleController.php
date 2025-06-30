<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\controller;


use app\api\lists\article\ArticleCollectLists;
use app\api\lists\article\ArticleLists;
use app\api\logic\ArticleLogic;

/**
 * 文章管理
 * Class ArticleController
 * @package app\api\controller
 */
class ArticleController extends BaseApiController
{

    public array $notNeedLogin = ['lists', 'cate', 'detail'];


    /**
     * @notes 文章列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 15:30
     */
    public function lists(): \think\response\Json
    {
        return $this->dataLists(new ArticleLists());
    }


    /**
     * @notes 文章分类列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 15:30
     */
    public function cate(): \think\response\Json
    {
        return $this->success('文章分类查询成功', ArticleLogic::cate());
    }


    /**
     * @notes 收藏列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 16:31
     */
    public function collect(): \think\response\Json
    {
        return $this->dataLists(new ArticleCollectLists());
    }


    /**
     * @notes 文章详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 17:09
     */
    public function detail(): \think\response\Json
    {
        $id = $this->request->get('id', '');
        if (!empty($id)) {
            $result = ArticleLogic::detail($id, $this->userId);
            return $this->success('文章详情查询成功', $result);
        }
        return $this->fail('文章详情查询失败');
    }


    /**
     * @notes 加入收藏
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 17:01
     */
    public function addCollect(): \think\response\Json
    {
        $articleId = $this->request->post('id', '');
        ArticleLogic::addCollect($articleId, $this->userId);
        return $this->success('在看成功');
    }


    /**
     * @notes 取消收藏
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/20 17:01
     */
    public function cancelCollect(): \think\response\Json
    {
        $articleId = $this->request->post('id', '');
        ArticleLogic::cancelCollect($articleId, $this->userId);
        return $this->success('取消在看');
    }


}