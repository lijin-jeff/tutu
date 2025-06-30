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

namespace app\api\http\middleware;


use app\common\enum\AdminTerminalEnum;
use app\common\exception\ControllerExtendException;
use app\api\controller\BaseApiController;
use app\common\service\JsonService;
use think\exception\ClassNotFoundException;
use think\exception\HttpException;


class InitMiddleware
{

    /**
     * @notes 初始化
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @throws ControllerExtendException
     * @author 兔兔答题
     * @date 2022/9/6 18:17
     */
    public function handle($request, \Closure $next)
    {
        //获取控制器
        try {
            $controller      = str_replace('.', '\\', $request->controller());
            $controller      = '\\app\\api\\controller\\' . $controller . 'Controller';
            $controllerClass = invoke($controller);
            if (($controllerClass instanceof BaseApiController) === false) {
                throw new ControllerExtendException($controller, '404');
            }
        } catch (ClassNotFoundException $e) {
            throw new HttpException(404, 'controller not exists:' . $e->getClass());
        }
        //创建控制器对象
        $request->controllerObject = invoke($controller);
        $tenantId                  = request()->header('tenantId', '');
        if (empty($tenantId)) {
            return JsonService::fail('租户ID不能为空', [], 0, 0);
        }
        $request->tenantId = $tenantId;
        $request->source   = AdminTerminalEnum::TENANT;

        return $next($request);
    }

}