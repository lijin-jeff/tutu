<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\channel;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\channel\OfficialAccountReplyLists;
use app\tenantapi\logic\channel\OfficialAccountReplyLogic;
use app\tenantapi\validate\channel\OfficialAccountReplyValidate;

/**
 * 微信公众号回复控制器
 * Class OfficialAccountReplyController
 * @package app\tenantapi\controller\channel
 */
class OfficialAccountReplyController extends BaseAdminController
{

    public array $notNeedLogin = ['index'];


    /**
     * @notes 查看回复列表(关注/关键词/默认)
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:58
     */
    public function lists()
    {
        return $this->dataLists(new OfficialAccountReplyLists());
    }


    /**
     * @notes 添加回复(关注/关键词/默认)
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:58
     */
    public function add()
    {
        $params = (new OfficialAccountReplyValidate())->post()->goCheck('add');
        $result = OfficialAccountReplyLogic::add($params);
        if ($result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(OfficialAccountReplyLogic::getError());
    }


    /**
     * @notes 查看回复详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:58
     */
    public function detail()
    {
        $params = (new OfficialAccountReplyValidate())->goCheck('detail');
        $result = OfficialAccountReplyLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 编辑回复(关注/关键词/默认)
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:58
     */
    public function edit()
    {
        $params = (new OfficialAccountReplyValidate())->post()->goCheck('edit');
        $result = OfficialAccountReplyLogic::edit($params);
        if ($result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(OfficialAccountReplyLogic::getError());
    }


    /**
     * @notes 删除回复(关注/关键词/默认)
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:59
     */
    public function delete()
    {
        $params = (new OfficialAccountReplyValidate())->post()->goCheck('delete');
        OfficialAccountReplyLogic::delete($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 更新排序
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:59
     */
    public function sort()
    {
        $params = (new OfficialAccountReplyValidate())->post()->goCheck('sort');
        OfficialAccountReplyLogic::sort($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 更新状态
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:59
     */
    public function status()
    {
        $params = (new OfficialAccountReplyValidate())->post()->goCheck('status');
        OfficialAccountReplyLogic::status($params);
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 微信公众号回调
     * @throws \ReflectionException
     * @author 兔兔答题
     * @date 2022/3/29 10:59
     */
    public function index()
    {
        $result = OfficialAccountReplyLogic::index();
        return response($result->getBody())->header([
            'Content-Type' => 'text/plain;charset=utf-8'
        ]);
    }
}