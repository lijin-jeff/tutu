<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\article;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\article\ArticleLists;
use app\tenantapi\logic\article\ArticleLogic;
use app\tenantapi\validate\article\ArticleValidate;

/**
 * 资讯管理控制器
 * Class ArticleController
 * @package app\tenantapi\controller\article
 */
class ArticleController extends BaseAdminController
{

    /**
     * @notes  查看资讯列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/22 9:47
     */
    public function lists()
    {
        return $this->dataLists(new ArticleLists());
    }

    /**
     * @notes  添加资讯
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/22 9:57
     */
    public function add()
    {
        $params = (new ArticleValidate())->post()->goCheck('add');
        ArticleLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }

    /**
     * @notes  编辑资讯
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/22 10:12
     */
    public function edit()
    {
        $params = (new ArticleValidate())->post()->goCheck('edit');
        $result = ArticleLogic::edit($params);
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(ArticleLogic::getError());
    }

    /**
     * @notes  删除资讯
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/22 10:17
     */
    public function delete()
    {
        $params = (new ArticleValidate())->post()->goCheck('delete');
        ArticleLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }

    /**
     * @notes  资讯详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/22 10:15
     */
    public function detail()
    {
        $params = (new ArticleValidate())->goCheck('detail');
        $result = ArticleLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes  更改资讯状态
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/22 10:18
     */
    public function updateStatus()
    {
        $params = (new ArticleValidate())->post()->goCheck('status');
        $result = ArticleLogic::updateStatus($params);
        if (false === $result) {
            return $this->fail(ArticleLogic::getError());
        }
        return $this->success('修改成功', [], 1, 1);
    }


}