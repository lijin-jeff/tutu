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

use app\api\lists\AccountLogLists;

/**
 * 账户流水
 * Class AccountLogController
 * @package app\api\controller
 */
class AccountLogController extends BaseApiController
{
    /**
     * @notes 账户流水
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/2/24 14:34
     */
    public function lists(): \think\response\Json
    {
        return $this->dataLists(new AccountLogLists());
    }
}