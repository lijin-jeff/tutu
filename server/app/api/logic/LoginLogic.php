<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\logic;

use app\api\service\{UserTokenService, WechatUserService};
use app\common\cache\WebScanLoginCache;
use app\common\enum\{notice\NoticeEnum, ScoreEnum, YesNoEnum};
use app\common\enum\LoginEnum;
use app\common\enum\user\UserTerminalEnum;
use app\common\logic\BaseLogic;
use app\common\model\user\{UserAuth};
use app\common\model\user\User;
use app\common\service\{sms\SmsDriver, wechat\WeChatMnpService};
use app\common\service\ConfigService;
use app\common\service\FileService;
use app\common\service\wechat\WeChatConfigService;
use app\common\service\wechat\WeChatOaService;
use app\common\service\wechat\WeChatRequestService;
use think\facade\{Config, Db};

/**
 * 登录逻辑
 * Class LoginLogic
 * @package app\api\logic
 */
class LoginLogic extends BaseLogic
{

    /**
     * @notes 账号密码注册
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/9/7 15:37
     */
    public static function register(array $params): bool
    {
        try {
//            if (!self::verifySmsCode($params['account'], (int)$params['code'])) {
//                return false;
//            }
            $userSn = User::createUserSn('tt_');
            $passwordSalt = Config::get('project.unique_identification');
            $password = create_password($params['password'], $passwordSalt);
            $avatar = ConfigService::get('default_image', 'user_avatar');
            $nickname = ConfigService::get('default_nickname', 'user_nickname');
            $userModel = User::create([
                'sn'        => $userSn,
                'uid'       => uid(),
                'tenant_id' => request()->tenantId,
                'avatar'    => $avatar,
                'mobile'    => $params['account'],
                'nickname'  => $nickname,
                'account'   => $params['account'],
                'password'  => $password,
                'channel'   => $params['channel'],
            ]);
            ScoreLogic::addScore((int)request()->tenantId, $userModel->getKey(), 300.00, ScoreEnum::User_REGISTER, '注册赠送积分');
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }

    private static function verifySmsCode(string $phone, int $code): bool
    {
        $smsDriver = new SmsDriver();
        $result = $smsDriver->verify($phone, $code, NoticeEnum::LOGIN_CAPTCHA);
        if ($result) {
            return true;
        }
        self::setError('验证码错误');
        return false;
    }


    /**
     * @notes 账号/手机号登录，手机号验证码
     * @param $params
     * @return array|false
     * @author 兔兔答题
     * @date 2022/9/6 19:26
     */
    public static function login($params): bool|array
    {
        try {
            // 账号/手机号 密码登录
            $where = ['account|mobile' => $params['account']];
            if ($params['scene'] == LoginEnum::MOBILE_CAPTCHA) {
                //手机验证码登录
                $where = ['mobile' => $params['account']];
            }

            $user = User::where($where)->findOrEmpty();
            if ($user->isEmpty()) {
                throw new \Exception('用户不存在');
            }

            //更新登录信息
            $user->login_time = time();
            $user->login_ip = request()->ip();
            $user->save();

            //设置token
            $userInfo = UserTokenService::setToken($user, $params['terminal']);

            //返回登录信息
            $avatar = $user->avatar ?: Config::get('project.default_image.user_avatar');
            $avatar = FileService::getFileUrl($avatar);
            // 验证是否微信小程序授权
            $needMp = false;
            if ((int)$params['terminal'] === UserTerminalEnum::WECHAT_MMP) {
                $userAuth = UserAuth::where('user_id', '=', $user->id)->column(['openid']);
                if (empty($userAuth)) $needMp = true;
            }
            return [
                'nickname' => $userInfo['nickname'],
                'sn'       => $userInfo['sn'],
                'avatar'   => $avatar,
                'token'    => $userInfo['token'],
                'need_mp'  => $needMp,
            ];
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 退出登录
     * @param $userInfo
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/16 17:56
     */
    public static function logout($userInfo)
    {
        //token不存在，不注销
        if (!isset($userInfo['token'])) {
            return false;
        }

        //设置token过期
        return UserTokenService::expireToken($userInfo['token']);
    }


    /**
     * @notes 获取微信请求code的链接
     * @param string $url
     * @return string
     * @author 兔兔答题
     * @date 2022/9/20 19:47
     */
    public static function codeUrl(string $url)
    {
        return (new WeChatOaService())->getCodeUrl($url);
    }


    /**
     * @notes 公众号登录
     * @param array $params
     * @return array|false
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author 兔兔答题
     * @date 2022/9/20 19:47
     */
    public static function oaLogin(array $params)
    {
        Db::startTrans();
        try {
            //通过code获取微信 openid
            $response = (new WeChatOaService())->getOaResByCode($params['code']);
            $userServer = new WechatUserService($response, UserTerminalEnum::WECHAT_OA);
            $userInfo = $userServer->getResopnseByUserInfo()->authUserLogin()->getUserInfo();

            // 更新登录信息
            self::updateLoginInfo($userInfo['id']);

            Db::commit();
            return $userInfo;

        } catch (\Exception $e) {
            Db::rollback();
            self::$error = $e->getMessage();
            return false;
        }
    }


    /**
     * @notes 小程序-静默登录
     * @param array $params
     * @return array|false
     * @author 兔兔答题
     * @date 2022/9/20 19:47
     */
    public static function silentLogin(array $params)
    {
        try {
            //通过code获取微信 openid
            $response = (new WeChatMnpService())->getMnpResByCode($params['code']);
            $userServer = new WechatUserService($response, UserTerminalEnum::WECHAT_MMP);
            $userInfo = $userServer->getResopnseByUserInfo('silent')->getUserInfo();

            if (!empty($userInfo)) {
                // 更新登录信息
                self::updateLoginInfo($userInfo['id']);
            }

            return $userInfo;
        } catch (\Exception  $e) {
            self::$error = $e->getMessage();
            return false;
        }
    }


    /**
     * @notes 小程序-授权登录
     * @param array $params
     * @return array|false
     * @author 兔兔答题
     * @date 2022/9/20 19:47
     */
    public static function mnpLogin(array $params): bool|array
    {
        Db::startTrans();
        try {
            //通过code获取微信 openid
            $response = (new WeChatMnpService())->getMnpResByCode($params['code']);
            $userServer = new WechatUserService($response, UserTerminalEnum::WECHAT_MMP);
            $userInfo = $userServer->getResopnseByUserInfo()->authUserLogin()->getUserInfo();

            // 更新登录信息
            self::updateLoginInfo($userInfo['id']);

            Db::commit();
            return $userInfo;
        } catch (\Exception  $e) {
            Db::rollback();
            self::$error = $e->getMessage();
            return false;
        }
    }


    /**
     * @notes 更新登录信息
     * @param $userId
     * @throws \Exception
     * @author 兔兔答题
     * @date 2022/9/20 19:46
     */
    public static function updateLoginInfo($userId): void
    {
        $user = User::findOrEmpty($userId);
        if ($user->isEmpty()) {
            throw new \Exception('账号不存在，请先注册');
        }

        $time = time();
        $user->login_time = $time;
        $user->login_ip = request()->ip();
        $user->update_time = $time;
        $user->save();
    }


    /**
     * @notes 小程序端绑定微信
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/9/20 19:46
     */
    public static function mnpAuthLogin(array $params): bool
    {
        try {
            //通过code获取微信openid
            $response = (new WeChatMnpService())->getMnpResByCode($params['code']);
            $response['user_id'] = $params['user_id'];
            $response['terminal'] = UserTerminalEnum::WECHAT_MMP;

            return self::createAuth($response);

        } catch (\Exception  $e) {
            self::$error = $e->getMessage();
            return false;
        }
    }


    /**
     * @notes 公众号端绑定微信
     * @param array $params
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author 兔兔答题
     * @date 2022/9/16 10:43
     */
    public static function oaAuthLogin(array $params): bool
    {
        try {
            //通过code获取微信openid
            $response = (new WeChatOaService())->getOaResByCode($params['code']);
            $response['user_id'] = $params['user_id'];
            $response['terminal'] = UserTerminalEnum::WECHAT_OA;

            return self::createAuth($response);

        } catch (\Exception  $e) {
            self::$error = $e->getMessage();
            return false;
        }
    }


    /**
     * @notes 生成授权记录
     * @param $response
     * @return bool
     * @throws \Exception
     * @author 兔兔答题
     * @date 2022/9/16 10:43
     */
    public static function createAuth($response)
    {
        //先检查openid是否有记录
        $isAuth = UserAuth::where('openid', '=', $response['openid'])->findOrEmpty();
        if (!$isAuth->isEmpty()) {
            throw new \Exception('该微信已被绑定');
        }

        if (isset($response['unionid']) && !empty($response['unionid'])) {
            //在用unionid找记录，防止生成两个账号，同个unionid的问题
            $userAuth = UserAuth::where(['unionid' => $response['unionid']])
                ->findOrEmpty();
            if (!$userAuth->isEmpty() && $userAuth->user_id != $response['user_id']) {
                throw new \Exception('该微信已被绑定');
            }
        }

        //如果没有授权，直接生成一条微信授权记录
        UserAuth::create([
            'user_id'  => $response['user_id'],
            'openid'   => $response['openid'],
            'unionid'  => $response['unionid'] ?? '',
            'terminal' => $response['terminal'],
        ]);
        return true;
    }


    /**
     * @notes 获取扫码登录地址
     * @return array|false
     * @author 兔兔答题
     * @date 2022/10/20 18:23
     */
    public static function getScanCode($redirectUri)
    {
        try {
            $config = WeChatConfigService::getOpConfig();
            $appId = $config['app_id'];
            $redirectUri = UrlEncode($redirectUri);

            // 设置有效时间标记状态, 超时扫码不可登录
            $state = MD5(time() . rand(10000, 99999));
            (new WebScanLoginCache())->setScanLoginState($state);

            // 扫码地址
            $url = WeChatRequestService::getScanCodeUrl($appId, $redirectUri, $state);
            return ['url' => $url];

        } catch (\Exception $e) {
            self::$error = $e->getMessage();
            return false;
        }
    }


    /**
     * @notes 网站扫码登录
     * @param $params
     * @return array|false
     * @author 兔兔答题
     * @date 2022/10/21 10:28
     */
    public static function scanLogin($params)
    {
        Db::startTrans();
        try {
            // 通过code 获取 access_token,openid,unionid等信息
            $userAuth = WeChatRequestService::getUserAuthByCode($params['code']);

            if (empty($userAuth['openid']) || empty($userAuth['access_token'])) {
                throw new \Exception('获取用户授权信息失败');
            }

            // 获取微信用户信息
            $response = WeChatRequestService::getUserInfoByAuth($userAuth['access_token'], $userAuth['openid']);

            // 生成用户或更新用户信息
            $userServer = new WechatUserService($response, UserTerminalEnum::PC);
            $userInfo = $userServer->getResopnseByUserInfo()->authUserLogin()->getUserInfo();

            // 更新登录信息
            self::updateLoginInfo($userInfo['id']);

            Db::commit();
            return $userInfo;

        } catch (\Exception $e) {
            Db::rollback();
            self::$error = $e->getMessage();
            return false;
        }
    }


    /**
     * @notes 更新用户信息
     * @param $params
     * @param $userId
     * @return int
     * @author 兔兔答题
     * @date 2023/2/22 11:19
     */
    public static function updateUser($params, $userId): int
    {
        return User::where(['id' => $userId])->update([
                'nickname'    => $params['nickname'],
                'avatar'      => FileService::setFileUrl($params['avatar']),
                'is_new_user' => YesNoEnum::NO,
                'remark'      => $params['remark'],
                'sex'         => $params['sex'],
                'update_time' => time()
            ]) > 0;
    }
}