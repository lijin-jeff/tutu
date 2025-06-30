<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller\finance;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\lists\finance\RefundLogLists;
use app\tenantapi\lists\finance\RefundRecordLists;
use app\tenantapi\logic\finance\RefundLogic;

/**
 * 退款控制器
 * Class RefundController
 * @package app\tenantapi\controller\finance
 */
class RefundController extends BaseAdminController
{


    /**
     * @notes 退还统计
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2023/3/3 12:10
     */
    public function stat()
    {
        $result = RefundLogic::stat();
        return $this->success('', $result);
    }


    /**
     * @notes 退款记录
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/3/1 9:47
     */
    public function record()
    {
        return $this->dataLists(new RefundRecordLists());
    }


    /**
     * @notes 退款日志
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2023/3/1 9:47
     */
    public function log()
    {
        $recordId = $this->request->get('record_id', 0);
        $result = RefundLogic::refundLog($recordId);
        return $this->success('', $result);
    }

}