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
use app\tenantapi\logic\decorate\DecoratePageLogic;
use app\tenantapi\validate\decorate\DecoratePageValidate;


/**
 * 装修页面
 * Class DecoratePageController
 * @package app\tenantapi\controller\decorate
 */
class PageController extends BaseAdminController
{

    /**
     * @notes 获取装修修页面详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/14 18:43
     */
    public function detail()
    {
        $type   = $this->request->get('type/d');
        $result = DecoratePageLogic::getDetail(['type' => $type]);
        return $this->success('获取成功', $result);
    }


    /**
     * @notes 保存装修配置
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/15 9:57
     */
    public function save(): \think\response\Json
    {
        $params = (new DecoratePageValidate())->post()->goCheck();
        $result = DecoratePageLogic::save($params);
        if (false === $result) {
            return $this->fail(DecoratePageLogic::getError());
        }
        return $this->success('操作成功', [], 1, 1);
    }


}