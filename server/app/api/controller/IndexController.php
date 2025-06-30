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


use app\api\logic\ConfigLogic;
use app\api\logic\IndexLogic;
use app\api\validate\CommonValidate;
use app\api\validate\ConfigValidate;
use think\response\Json;


/**
 * index
 * Class IndexController
 * @package app\api\controller
 */
class IndexController extends BaseApiController
{


    public array $notNeedLogin = ['index', 'config', 'policy', 'decorate', 'imageConfig', 'dataQuery'];


    /**
     * 系统全局查询
     * @return Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function dataQuery(): Json
    {
        (new CommonValidate())->get()->goCheck('page');
        return $this->success('查询成功', IndexLogic::dataQuery($this->requestParams));
    }


    /**
     * @notes 首页数据
     * @return Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/21 19:15
     */
    public function index(): Json
    {
        $result = IndexLogic::getIndexData();
        return $this->data($result);
    }


    /**
     * @notes 全局配置
     * @return Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/21 19:41
     */
    public function config(): Json
    {
        $result = IndexLogic::getConfigData();
        return $this->data($result);
    }


    /**
     * @notes 政策协议
     * @return Json
     * @author 兔兔答题
     * @date 2022/9/20 20:00
     */
    public function policy(): Json
    {
        $type = $this->request->get('type', '');
        $result = IndexLogic::getPolicyByType($type);
        return $this->success('信息获取成功', $result);
    }


    /**
     * @notes 装修信息
     * @return Json
     * @author 兔兔答题
     * @date 2022/9/21 18:37
     */
    public function decorate(): Json
    {
        $type = $this->request->get('type/d');
        $result = IndexLogic::getDecorate($type);
        return $this->data($result);
    }

    /**
     * 获取图片先关类型的配置
     * @return Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/2 16:22
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function imageConfig(): Json
    {
        $params = (new ConfigValidate())->get()->goCheck('platform');
        return $this->success('获取成功', ConfigLogic::imageList($params));
    }
}