<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\controller\crontab;

use app\platformapi\controller\BaseAdminController;
use app\platformapi\lists\crontab\CrontabLists;
use app\platformapi\logic\crontab\CrontabLogic;
use app\platformapi\validate\crontab\CrontabValidate;

/**
 * 定时任务控制器
 * Class CrontabController
 * @package app\platformapi\controller\crontab
 */
class CrontabController extends BaseAdminController
{
    /**
     * @notes 定时任务列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 14:27
     */
    public function lists()
    {
        return $this->dataLists(new CrontabLists());
    }


    /**
     * @notes 添加定时任务
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 14:27
     */
    public function add()
    {
        $params = (new CrontabValidate())->post()->goCheck('add');
        $result = CrontabLogic::add($params);
        if($result) {
            return $this->success('添加成功', [], 1, 1);
        }
        return $this->fail(CrontabLogic::getError());
    }


    /**
     * @notes 查看定时任务详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 14:27
     */
    public function detail()
    {
        $params = (new CrontabValidate())->goCheck('detail');
        $result = CrontabLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 编辑定时任务
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 14:27
     */
    public function edit()
    {
        $params = (new CrontabValidate())->post()->goCheck('edit');
        $result = CrontabLogic::edit($params);
        if($result) {
            return $this->success('编辑成功', [], 1, 1);
        }
        return $this->fail(CrontabLogic::getError());
    }


    /**
     * @notes 删除定时任务
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 14:27
     */
    public function delete()
    {
        $params = (new CrontabValidate())->post()->goCheck('delete');
        $result = CrontabLogic::delete($params);
        if($result) {
            return $this->success('删除成功', [], 1, 1);
        }
        return $this->fail('删除失败');
    }


    /**
     * @notes 操作定时任务
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 14:28
     */
    public function operate()
    {
        $params = (new CrontabValidate())->post()->goCheck('operate');
        $result = CrontabLogic::operate($params);
        if($result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(CrontabLogic::getError());
    }


    /**
     * @notes 获取规则执行时间
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/3/29 14:28
     */
    public function expression()
    {
        $params = (new CrontabValidate())->goCheck('expression');
        $result = CrontabLogic::expression($params);
        return $this->data($result);
    }
}