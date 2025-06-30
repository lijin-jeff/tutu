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
use app\platformapi\lists\setting\dict\DictTypeLists;
use app\platformapi\logic\setting\dict\DictTypeLogic;
use app\platformapi\validate\dict\DictTypeValidate;


/**
 * 字典类型
 * Class DictTypeController
 * @package app\platformapi\controller\dict
 */
class DictTypeController extends BaseAdminController
{


    /**
     * @notes 获取字典类型列表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 15:50
     */
    public function lists()
    {
        return $this->dataLists(new DictTypeLists());
    }


    /**
     * @notes 添加字典类型
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 16:24
     */
    public function add()
    {
        $params = (new DictTypeValidate())->post()->goCheck('add');
        DictTypeLogic::add($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes 编辑字典类型
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 16:25
     */
    public function edit()
    {
        $params = (new DictTypeValidate())->post()->goCheck('edit');
        DictTypeLogic::edit($params);
        return $this->success('编辑成功', [], 1, 1);
    }


    /**
     * @notes 删除字典类型
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 16:25
     */
    public function delete()
    {
        $params = (new DictTypeValidate())->post()->goCheck('delete');
        DictTypeLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 获取字典详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 16:25
     */
    public function detail()
    {
        $params = (new DictTypeValidate())->goCheck('detail');
        $result = DictTypeLogic::detail($params);
        return $this->data($result);
    }


    /**
     * @notes 获取字典类型数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 10:46
     */
    public function all()
    {
        $result = DictTypeLogic::getAllData();
        return $this->data($result);
    }


}