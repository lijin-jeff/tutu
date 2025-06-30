<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\controller\setting\dict;

use app\platformapi\controller\BaseAdminController;
use app\platformapi\lists\setting\dict\DictDataLists;
use app\platformapi\logic\setting\dict\DictDataLogic;
use app\platformapi\validate\dict\DictDataValidate;


/**
 * 字典数据
 * Class DictDataController
 * @package app\platformapi\controller\dictionary
 */
class DictDataController extends BaseAdminController
{

    /**
     * @notes 获取字典数据列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 16:35
     */
    public function lists()
    {
        return $this->dataLists(new DictDataLists());
    }


    /**
     * @notes 添加字典数据
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 17:13
     */
    public function add()
    {
        $params = (new DictDataValidate())->post()->goCheck('add');
        DictDataLogic::save($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes 编辑字典数据
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 17:13
     */
    public function edit()
    {
        $params = (new DictDataValidate())->post()->goCheck('edit');
        DictDataLogic::save($params);
        return $this->success('编辑成功', [], 1, 1);
    }


    /**
     * @notes 删除字典数据
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 17:13
     */
    public function delete()
    {
        $params = (new DictDataValidate())->post()->goCheck('id');
        DictDataLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取字典详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 17:14
     */
    public function detail()
    {
        $params = (new DictDataValidate())->goCheck('id');
        $result = DictDataLogic::detail($params);
        return $this->data($result);
    }


}