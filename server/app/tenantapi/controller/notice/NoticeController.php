<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\notice;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\notice\NoticeSettingLists;
use app\tenantapi\logic\notice\NoticeLogic;
use app\tenantapi\validate\notice\NoticeValidate;

/**
 * 通知控制器
 * Class NoticeController
 * @package app\tenantapi\controller\notice
 */
class NoticeController extends BaseAdminController
{
    /**
     * @notes 查看通知设置列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 11:18
     */
    public function settingLists()
    {
        return $this->dataLists(new NoticeSettingLists());
    }


    /**
     * @notes 查看通知设置详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 11:18
     */
    public function detail()
    {
        $params = (new NoticeValidate())->goCheck('detail');
        $result = NoticeLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 通知设置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 11:18
     */
    public function set()
    {
        $params = $this->request->post();
        $result = NoticeLogic::set($params);
        if ($result) {
            return $this->success('设置成功');
        }
        return $this->fail(NoticeLogic::getError());
    }
}