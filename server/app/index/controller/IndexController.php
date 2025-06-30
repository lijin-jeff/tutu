<?php
declare(strict_types=1);

namespace app\index\controller;

use app\BaseController;
use app\common\service\JsonService;
use think\facade\Request;

class IndexController extends BaseController
{

    /**
     * @notes 主页
     * @param string $name
     * @return \think\response\Json|\think\response\View
     * @author 兔兔答题
     * @date 2022/10/27 18:12
     */
    public function index($name = '你好,兔兔答题')
    {
        $template = app()->getRootPath() . 'public/platform/index.html';

        if (file_exists($template)) {
            return view($template);
        }
        return JsonService::success($name);
    }
}
