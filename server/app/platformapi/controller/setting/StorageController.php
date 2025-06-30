<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\controller\setting;


use app\platformapi\controller\BaseAdminController;
use app\platformapi\logic\setting\StorageLogic;
use app\platformapi\validate\setting\StorageValidate;
use think\response\Json;


/**
 * 存储设置控制器
 * Class StorageController
 * @package app\platformapi\controller\setting\shop
 */
class StorageController extends BaseAdminController
{

    /**
     * @notes 获取存储引擎列表
     * @return Json
     * @author 兔兔答题
     * @date 2022/4/20 16:13
     */
    public function lists()
    {
        return $this->success('获取成功', StorageLogic::lists());
    }


    /**
     * @notes 存储配置信息
     * @return Json
     * @author 兔兔答题
     * @date 2022/4/20 16:19
     */
    public function detail()
    {
        $param = (new StorageValidate())->get()->goCheck('detail');
        return $this->success('获取成功', StorageLogic::detail($param));
    }


    /**
     * @notes 设置存储参数
     * @return Json
     * @author 兔兔答题
     * @date 2022/4/20 16:19
     */
    public function setup()
    {
        $params = (new StorageValidate())->post()->goCheck('setup');
        $result = StorageLogic::setup($params);
        if (true === $result) {
            return $this->success('配置成功', [], 1, 1);
        }
        return $this->success($result, [], 1, 1);
    }


    /**
     * @notes 切换存储引擎
     * @return Json
     * @author 兔兔答题
     * @date 2022/4/20 16:19
     */
    public function change()
    {
        $params = (new StorageValidate())->post()->goCheck('change');
        StorageLogic::change($params);
        return $this->success('切换成功', [], 1, 1);
    }
}
