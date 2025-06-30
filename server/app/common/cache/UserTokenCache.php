<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\common\cache;

use app\common\cache\BaseCache;
use app\common\model\user\User;
use app\common\model\user\UserSession;

class UserTokenCache extends BaseCache
{

    private $prefix = 'token_user_';


    /**
     * @notes 通过token获取缓存用户信息
     * @param $token
     * @return array|false|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/16 10:11
     */
    public function getUserInfo($token)
    {
        //直接从缓存获取
        $userInfo = $this->get($this->prefix . $token);
        if ($userInfo) {
            return $userInfo;
        }

        //从数据获取信息被设置缓存(可能后台清除缓存）
        $userInfo = $this->setUserInfo($token);
        if ($userInfo) {
            return $userInfo;
        }

        return false;
    }


    /**
     * @notes 通过有效token设置用户信息缓存
     * @param $token
     * @return array|false|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/16 10:11
     */
    public function setUserInfo($token)
    {
        $userSession = UserSession::where([['token', '=', $token], ['expire_time', '>', time()]])->find();
        if (empty($userSession)) {
            return [];
        }

        $user = User::where('id', '=', $userSession->user_id)
            ->find();

        $userInfo = [
            'user_id'     => $user->id,
            'user_uid'    => $user->uid,
            'tenant_id'   => $user->tenant_id,
            'nickname'    => $user->nickname,
            'token'       => $token,
            'sn'          => $user->sn,
            'mobile'      => $user->mobile,
            'avatar'      => $user->avatar,
            'terminal'    => $userSession->terminal,
            'expire_time' => $userSession->expire_time,
        ];

        $ttl = new \DateTime(Date('Y-m-d H:i:s', $userSession->expire_time));
        $this->set($this->prefix . $token, $userInfo, $ttl);
        return $this->getUserInfo($token);
    }


    /**
     * @notes 删除缓存
     * @param $token
     * @return bool
     * @author 兔兔答题
     * @date 2022/9/16 10:13
     */
    public function deleteUserInfo($token)
    {
        return $this->delete($this->prefix . $token);
    }
}