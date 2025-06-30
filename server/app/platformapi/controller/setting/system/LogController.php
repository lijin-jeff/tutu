<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\controller\setting\system;


use app\platformapi\controller\BaseAdminController;
use app\platformapi\lists\setting\system\LogLists;

/**
 * 系统日志
 * Class LogController
 * @package app\platformapi\controller\setting\system
 */
class LogController extends BaseAdminController
{
    /**
     * @notes 查看系统日志列表
     * @return \think\response\Json
     * @author ljj
     * @date 2021/8/3 4:25 下午
     */
    public function lists()
    {
        return $this->dataLists(new LogLists());
    }
}