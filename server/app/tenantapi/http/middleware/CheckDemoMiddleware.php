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


use app\common\service\JsonService;

/**
 * 校验演示环境
 * Class CheckDemoMiddleware
 * @package app\tenantapi\http\middleware
 */
class CheckDemoMiddleware
{

    // 允许post的接口
    protected $ablePost = [
        'login/account',
        'login/logout',
    ];

    public function handle($request, \Closure $next)
    {
        if ($request->method() != 'POST') {
            return $next($request);
        }

        $accessUri = strtolower($request->controller() . '/' . $request->action());
        if (!in_array($accessUri, $this->ablePost) && env('project.demo_env')) {
            return JsonService::fail('演示环境不支持修改数据，请下载源码本地部署体验');
        }

        return $next($request);
    }

}