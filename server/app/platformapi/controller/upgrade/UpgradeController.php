<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\platformapi\controller\upgrade;

use app\platformapi\controller\BaseAdminController;
use app\platformapi\lists\upgrade\UpgradeLists;
use app\platformapi\logic\upgrade\UpgradeLogic;
use app\platformapi\validate\upgrade\downloadPkgValidate;
use app\platformapi\validate\upgrade\UpgradeValidate;
use think\response\Json;

/**
 * 系统更新
 */
class UpgradeController extends BaseAdminController
{
    /**
     * @notes 查看系统更新列表
     * @return Json
     * @author 兔兔答题
     * @date 2021/8/14 17:17
     */
    public function lists(): Json
    {
        return $this->dataLists(new UpgradeLists());
    }

    /**
     * @notes 执行系统更新
     * @return Json
     * @author 兔兔答题
     * @date 2021/8/14 16:51
     */
    public function upgrade(): Json
    {
        $params = (new UpgradeValidate())->post()->goCheck();
        $params['update_type'] = 1; // 一键更新类型
        if (true === UpgradeLogic::upgrade($params)) {
            return $this->success('更新成功', [], 1, 1);
        }
        return $this->fail('更新失败:'. UpgradeLogic::getError());
    }

    /**
     * @notes 下载更新包
     * @return Json
     * @author 兔兔答题
     * @date 2021/10/8 14:23
     */
    public function downloadPkg(): Json
    {
        $params = (new downloadPkgValidate())->post()->goCheck();
        $result = UpgradeLogic::getPkgLine($params);
        if (false === $result) {
            return $this->fail(UpgradeLogic::getError());
        }
        return $this->success('', $result);
    }
}