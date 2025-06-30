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
namespace app\api\controller;

use app\api\logic\ConfigLogic;
use think\response\Json;

class ConfigController extends BaseApiController
{
    /**
     * 字典类型列表
     * @return Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 01:57
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function dictType(): Json
    {
        return $this->success('字典类型查询成功', ConfigLogic::dictType());
    }

    /**
     * 字典数据列表
     * @return Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 01:57
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function dictData(): Json
    {
        return $this->success('字段数据查询成功', ConfigLogic::dictData($this->request->all()));
    }
}