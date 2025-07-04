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

namespace app\tenantapi\http\middleware;

use app\common\cache\TenantAdminTokenCache;
use app\tenantapi\service\TenantTokenService;
use app\common\service\JsonService;
use think\facade\Config;

/**
 * 登录中间件
 * Class LoginMiddleware
 * @package app\tenantapi\http\middleware
 */
class LoginMiddleware
{
    /**
     * @notes 登录验证
     * @param $request
     * @param \Closure $next
     * @return mixed|\think\response\Json
     * @author 令狐冲
     * @date 2021/7/1 17:33
     */
    public function handle($request, \Closure $next)
    {
        $token = $request->header('token');
        //判断接口是否免登录
        $isNotNeedLogin = $request->controllerObject->isNotNeedLogin();

        //不直接判断$isNotNeedLogin结果，使不需要登录的接口通过，为了兼容某些接口可以登录或不登录访问
        if (empty($token) && !$isNotNeedLogin) {
            //没有token并且该地址需要登录才能访问
            return JsonService::fail('请求参数缺token', [], 0, 0);
        }

        $adminInfo = (new TenantAdminTokenCache())->getAdminInfo($token);


        if (empty($adminInfo) && !$isNotNeedLogin) {
            //token过期无效并且该地址需要登录才能访问
            return JsonService::fail('登录超时，请重新登录', [], -1);
        }

        //token临近过期，自动续期
        if ($adminInfo) {
            //获取临近过期自动续期时长
            $beExpireDuration = Config::get('project.admin_token.be_expire_duration');
            //token续期
            if (time() > ($adminInfo['expire_time'] - $beExpireDuration)) {
                $result = TenantTokenService::overtimeToken($token);
                //续期失败（数据表被删除导致）
                if (empty($result)) {
                    return JsonService::fail('登录过期', [], -1);
                }
            }

            if ($adminInfo['tenant_id'] !== $request->tenantId) {
                if (!$isNotNeedLogin) {
                    TenantTokenService::expireToken($token);
                    return JsonService::fail('非该站点成员禁止访问', [], -1);
                }
            }
        }

        //给request赋值，用于控制器
        $request->adminInfo = $adminInfo;
        $request->adminId = $adminInfo['admin_id'] ?? 0;

        return $next($request);
    }

}