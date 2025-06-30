<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\tenantapi\controller\exam;


use app\common\controller\BaseLikeAdminController;
use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\exam\TenantExamChapterLists;
use app\tenantapi\logic\exam\TenantExamChapterLogic;
use app\tenantapi\validate\exam\TenantExamChapterValidate;


/**
 * 题库章节控制器
 * Class TenantExamChapterController
 * @package app\platform\controller\exam
 */
class TenantExamChapterController extends BaseAdminController
{


    /**
     * @notes 获取题库章节列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/12 15:53
     */
    public function lists(): \think\response\Json
    {
        return $this->dataLists(new TenantExamChapterLists($this->tenantId));
    }


    /**
     * @notes 添加题库章节
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/12 15:53
     */
    public function add(): \think\response\Json
    {
        $params = (new TenantExamChapterValidate())->post()->goCheck('add');
        $result = TenantExamChapterLogic::add(array_merge($params, ['tenant_id' => $this->tenantId]));
        if (true === $result) {
            return $this->success('添加成功', [], 1, 1);
        }
        return $this->fail(TenantExamChapterLogic::getError());
    }


    /**
     * @notes 编辑题库章节
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/12 15:53
     */
    public function edit(): \think\response\Json
    {
        $params = (new TenantExamChapterValidate())->post()->goCheck('edit');
        $result = TenantExamChapterLogic::edit(array_merge($params, ['tenant_id' => $this->tenantId]));
        if (true === $result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(TenantExamChapterLogic::getError());
    }


    /**
     * @notes 删除题库章节
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/12 15:53
     */
    public function delete(): \think\response\Json
    {
        $params = (new TenantExamChapterValidate())->post()->goCheck('delete');
        TenantExamChapterLogic::delete(array_merge($params, ['tenant_id' => $this->tenantId]));
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取题库章节详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2025/04/12 15:53
     */
    public function detail(): \think\response\Json
    {
        $params = (new TenantExamChapterValidate())->goCheck('detail');
        $result = TenantExamChapterLogic::detail(array_merge($params, ['tenant_id' => $this->tenantId]));
        return $this->data($result);
    }

    /**
     * 题库章节树
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/4/1 03:42
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function categoryTree(): \think\response\Json
    {
        return $this->success('题库章节获取成功', TenantExamChapterLogic::categoryTree(['tenant_id' => $this->tenantId]));
    }

    /**
     * 获取一级分类
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/4/1 03:00
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function parentList(): \think\response\Json
    {
        return $this->success('查询成功', TenantExamChapterLogic::parentList(array_merge($this->request->all(), ['tenant_id' => $this->tenantId])));
    }
}