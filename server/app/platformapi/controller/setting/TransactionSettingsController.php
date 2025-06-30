<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\controller\setting;


use app\platformapi\controller\BaseAdminController;
use app\platformapi\logic\setting\TransactionSettingsLogic;
use app\platformapi\validate\setting\TransactionSettingsValidate;

/**
 * 交易设置
 * Class TransactionSettingsController
 * @package app\platformapi\controller\setting
 */
class TransactionSettingsController extends BaseAdminController
{
    /**
     * @notes 获取交易设置
     * @return \think\response\Json
     * @author ljj
     * @date 2022/2/15 11:40 上午
     */
    public function getConfig()
    {
        $result = TransactionSettingsLogic::getConfig();
        return $this->data($result);
    }

    /**
     * @notes 设置交易设置
     * @return \think\response\Json
     * @author ljj
     * @date 2022/2/15 11:50 上午
     */
    public function setConfig()
    {
        $params = (new TransactionSettingsValidate())->post()->goCheck('setConfig');
        TransactionSettingsLogic::setConfig($params);
        return $this->success('操作成功',[],1,1);
    }
}