<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller;


use app\tenantapi\lists\file\FileCateLists;
use app\tenantapi\lists\file\FileLists;
use app\tenantapi\logic\FileLogic;
use app\tenantapi\validate\FileValidate;
use think\response\Json;

/**文件管理
 * Class FileController
 * @package app\tenantapi\controller
 */
class FileController extends BaseAdminController
{

    /**
     * @notes 文件列表
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 14:30
     */
    public function lists()
    {
        return $this->dataLists(new FileLists());
    }


    /**
     * @notes 文件移动成功
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 14:30
     */
    public function move()
    {
        $params = (new FileValidate())->post()->goCheck('move');
        FileLogic::move($params);
        return $this->success('移动成功', [], 1, 1);
    }


    /**
     * @notes 重命名文件
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 14:31
     */
    public function rename()
    {
        $params = (new FileValidate())->post()->goCheck('rename');
        FileLogic::rename($params);
        return $this->success('重命名成功', [], 1, 1);
    }


    /**
     * @notes 删除文件
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 14:31
     */
    public function delete()
    {
        $params = (new FileValidate())->post()->goCheck('delete');
        FileLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 分类列表
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 14:31
     */
    public function listCate()
    {
        return $this->dataLists(new FileCateLists());
    }


    /**
     * @notes 添加文件分类
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 14:31
     */
    public function addCate()
    {
        $params = (new FileValidate())->post()->goCheck('addCate');
        FileLogic::addCate($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes 编辑文件分类
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 14:31
     */
    public function editCate()
    {
        $params = (new FileValidate())->post()->goCheck('editCate');
        FileLogic::editCate($params);
        return $this->success('编辑成功', [], 1, 1);
    }


    /**
     * @notes 删除文件分类
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 14:32
     */
    public function delCate()
    {
        $params = (new FileValidate())->post()->goCheck('id');
        FileLogic::delCate($params);
        return $this->success('删除成功', [], 1, 1);
    }
}