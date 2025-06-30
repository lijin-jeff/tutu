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
use app\tenantapi\logic\channel\OfficialAccountMenuLogic;

/**
 * 微信公众号菜单控制器
 * Class OfficialAccountMenuController
 * @package app\tenantapi\controller\channel
 */
class OfficialAccountMenuController extends BaseAdminController
{

    /**
     * @notes 保存菜单
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:41
     */
    public function save()
    {
        $params = $this->request->post();
        $result = OfficialAccountMenuLogic::save($params);
        if(false === $result) {
            return $this->fail(OfficialAccountMenuLogic::getError());
        }
        return $this->success('保存成功',[],1,1);
    }


    /**
     * @notes 保存发布菜单
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:42
     */
    public function saveAndPublish()
    {
        $params = $this->request->post();
        $result = OfficialAccountMenuLogic::saveAndPublish($params);
        if($result) {
            return $this->success('保存并发布成功',[],1,1);
        }
        return $this->fail(OfficialAccountMenuLogic::getError());
    }



    /**
     * @notes 查看菜单详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 10:42
     */
    public function detail()
    {
        $result = OfficialAccountMenuLogic::detail();
        return $this->data($result);
    }
}