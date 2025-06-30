<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\controller\tools;

use app\platformapi\controller\BaseAdminController;
use app\platformapi\lists\tools\DataTableLists;
use app\platformapi\lists\tools\GenerateTableLists;
use app\platformapi\logic\tools\GeneratorLogic;
use app\platformapi\validate\tools\EditTableValidate;
use app\platformapi\validate\tools\GenerateTableValidate;


/**
 * 代码生成器控制器
 * Class GeneratorController
 * @package app\platformapi\controller\article
 */
class GeneratorController extends BaseAdminController
{

    public array $notNeedLogin = ['download'];


    /**
     * @notes 获取数据库中所有数据表信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/14 10:57
     */
    public function dataTable()
    {
        return $this->dataLists(new DataTableLists());
    }


    /**
     * @notes 获取已选择的数据表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/14 10:57
     */
    public function generateTable()
    {
        return $this->dataLists(new GenerateTableLists());
    }


    /**
     * @notes 选择数据表
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/15 10:09
     */
    public function selectTable()
    {
        $params = (new GenerateTableValidate())->post()->goCheck('select');
        $result = GeneratorLogic::selectTable($params, $this->adminId);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(GeneratorLogic::getError());
    }


    /**
     * @notes 生成代码
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/23 19:08
     */
    public function generate()
    {
        $params = (new GenerateTableValidate())->post()->goCheck('id');
        $result = GeneratorLogic::generate($params);
        if (false === $result) {
            return $this->fail(GeneratorLogic::getError());
        }
        return $this->success('操作成功', $result, 1, 1);
    }


    /**
     * @notes 下载文件
     * @return \think\response\File|\think\response\Json
     * @author 兔兔答题
     * @date 2022/6/24 9:51
     */
    public function download()
    {
        $params = (new GenerateTableValidate())->goCheck('download');
        $result = GeneratorLogic::download($params['file']);
        if (false === $result) {
            return $this->fail(GeneratorLogic::getError() ?: '下载失败');
        }
        return download($result, '兔兔答题-curd.zip');
    }


    /**
     * @notes 预览代码
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/23 19:07
     */
    public function preview()
    {
        $params = (new GenerateTableValidate())->post()->goCheck('id');
        $result = GeneratorLogic::preview($params);
        if (false === $result) {
            return $this->fail(GeneratorLogic::getError());
        }
        return $this->data($result);
    }


    /**
     * @notes 同步字段
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/17 15:22
     */
    public function syncColumn()
    {
        $params = (new GenerateTableValidate())->post()->goCheck('id');
        $result = GeneratorLogic::syncColumn($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(GeneratorLogic::getError());
    }


    /**
     * @notes 编辑表信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/20 10:44
     */
    public function edit()
    {
        $params = (new EditTableValidate())->post()->goCheck();
        $result = GeneratorLogic::editTable($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(GeneratorLogic::getError());
    }


    /**
     * @notes 获取已选择的数据表详情
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/15 19:00
     */
    public function detail()
    {
        $params = (new GenerateTableValidate())->goCheck('id');
        $result = GeneratorLogic::getTableDetail($params);
        return $this->success('', $result);
    }


    /**
     * @notes 删除已选择的数据表信息
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/6/15 19:00
     */
    public function delete()
    {
        $params = (new GenerateTableValidate())->post()->goCheck('id');
        $result = GeneratorLogic::deleteTable($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(GeneratorLogic::getError());
    }


    /**
     * @notes 获取模型
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/12/14 11:07
     */
    public function getModels()
    {
        $result = GeneratorLogic::getAllModels();
        return $this->success('', $result, 1, 1);
    }

}

