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
use app\tenantapi\lists\article\ArticleCateLists;
use app\tenantapi\logic\article\ArticleCateLogic;
use app\tenantapi\validate\article\ArticleCateValidate;

/**
 * 资讯分类管理控制器
 * Class ArticleCateController
 * @package app\tenantapi\controller\article
 */
class ArticleCateController extends BaseAdminController
{

    /**
     * @notes  查看资讯分类列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/21 17:11
     */
    public function lists(): \think\response\Json
    {
        return $this->dataLists(new ArticleCateLists());
    }


    /**
     * @notes  添加资讯分类
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/21 17:31
     */
    public function add(): \think\response\Json
    {
        $params = (new ArticleCateValidate())->post()->goCheck('add');
        ArticleCateLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes  编辑资讯分类
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/21 17:49
     */
    public function edit(): \think\response\Json
    {
        $params = (new ArticleCateValidate())->post()->goCheck('edit');
        $result = ArticleCateLogic::edit($params);
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(ArticleCateLogic::getError());
    }


    /**
     * @notes  删除资讯分类
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/21 17:52
     */
    public function delete(): \think\response\Json
    {
        $params = (new ArticleCateValidate())->post()->goCheck('delete');
        ArticleCateLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes  资讯分类详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/21 17:54
     */
    public function detail(): \think\response\Json
    {
        $params = (new ArticleCateValidate())->goCheck('detail');
        $result = ArticleCateLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes  更改资讯分类状态
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/2/21 10:15
     */
    public function updateStatus(): \think\response\Json
    {
        $params = (new ArticleCateValidate())->post()->goCheck('status');
        $result = ArticleCateLogic::updateStatus($params);
        if (true === $result) {
            return $this->success('修改成功', [], 1, 1);
        }
        return $this->fail(ArticleCateLogic::getError());
    }


    /**
     * @notes 获取文章分类
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 10:54
     */
    public function all(): \think\response\Json
    {
        $result = ArticleCateLogic::getAllData();
        return $this->data($result);
    }


}