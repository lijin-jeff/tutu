<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\api\controller\exam;

use app\api\controller\BaseApiController;
use app\api\logic\exam\CategoryLogic;

class CategoryController extends BaseApiController
{
    public array $notNeedLogin = ['category'];

    /**
     * 试题类型列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/2 23:52
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function category(): \think\response\Json
    {
        return $this->success('分类获取成功', CategoryLogic::categoryTree());
    }
}