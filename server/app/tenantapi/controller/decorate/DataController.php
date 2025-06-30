<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\tenantapi\controller\decorate;

use app\tenantapi\controller\BaseAdminController;
use app\tenantapi\logic\decorate\DecorateDataLogic;
use think\response\Json;

/**
 * 装修-数据
 * Class DataController
 * @package app\tenantapi\controller\decorate
 */
class DataController extends BaseAdminController
{
    /**
     * @notes 文章列表
     * @return Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author mjf
     * @date 2024/3/14 18:13
     */
    public function article(): Json
    {
        $limit = $this->request->get('limit/d', 10);
        $result = DecorateDataLogic::getArticleLists($limit);
        return $this->success('获取成功', $result);
    }

    /**
     * @notes pc设置
     * @return Json
     * @author mjf
     * @date 2024/3/14 18:13
     */
    public function pc(): Json
    {
        $result = DecorateDataLogic::pc();
        return $this->data($result);
    }

}