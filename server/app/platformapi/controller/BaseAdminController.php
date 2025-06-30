<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

declare (strict_types=1);

namespace app\platformapi\controller;

use app\common\enum\AdminTerminalEnum;
use think\App;
use app\common\controller\BaseLikeAdminController;

/**
 * 管理元控制器基类
 * Class BaseAdminController
 * @package app\platformapi\controller
 */
class BaseAdminController extends BaseLikeAdminController
{
    protected int   $adminId   = 0;
    protected array $adminInfo = [];

    public function initialize(): void
    {
        $this->request->source = AdminTerminalEnum::PLATFORM;
        if (isset($this->request->adminInfo) && $this->request->adminInfo) {
            $this->adminInfo = $this->request->adminInfo;
            $this->adminId   = $this->request->adminInfo['admin_id'];
        }
    }

}