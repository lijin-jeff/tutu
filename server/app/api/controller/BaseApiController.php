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

use app\common\cache\UserTokenCache;
use app\common\controller\BaseLikeAdminController;
use app\common\enum\AdminTerminalEnum;

class BaseApiController extends BaseLikeAdminController
{
    protected int $userId = 0;

    protected array $userInfo = [];

    protected array $requestParams = [];

    public function initialize(): void
    {
        $this->request->source = AdminTerminalEnum::USER;
        if (isset($this->request->userInfo) && $this->request->userInfo) {
            $this->userInfo = $this->request->userInfo;
            $this->userId = $this->request->userInfo['user_id'];
        }
        if (count($this->userInfo)) {
            $this->requestParams = array_merge($this->request->all(), $this->userInfo);
        } else {
            $this->requestParams = $this->request->all();
        }
    }
}