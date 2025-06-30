<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\validate;


use app\common\validate\BaseValidate;

/**
 * 文件验证
 * Class FileValidate
 * @package app\platformapi\validate
 */
class FileValidate extends BaseValidate
{
    protected $rule = [
        'id'   => 'require|number',
        'cid'  => 'require|number',
        'ids'  => 'require|array',
        'type' => 'require|in:10,20,30',
        'pid'  => 'require|number',
        'name' => 'require|max:20'
    ];

    protected $message = [
        'id.require'   => '缺少id参数',
        'cid.require'  => '缺少cid参数',
        'ids.require'  => '缺少ids参数',
        'type.require' => '缺少type参数',
        'pid.require'  => '缺少pid参数',
        'name.require' => '请填写分组名称',
        'name.max' => '分组名称长度须为20字符内',
    ];


    /**
     * @notes id验证场景
     * @return FileValidate
     * @author 兔兔答题
     * @date 2021/12/29 14:32
     */
    public function sceneId()
    {
        return $this->only(['id']);
    }


    /**
     * @notes 重命名文件场景
     * @return FileValidate
     * @author 兔兔答题
     * @date 2021/12/29 14:32
     */
    public function sceneRename()
    {
        return $this->only(['id', 'name']);
    }


    /**
     * @notes 新增分类场景
     * @return FileValidate
     * @author 兔兔答题
     * @date 2021/12/29 14:33
     */
    public function sceneAddCate()
    {
        return $this->only(['type', 'pid', 'name']);
    }


    /**
     * @notes 编辑分类场景
     * @return FileValidate
     * @author 兔兔答题
     * @date 2021/12/29 14:33
     */
    public function sceneEditCate()
    {
        return $this->only(['id', 'name']);
    }


    /**
     * @notes 移动场景
     * @return FileValidate
     * @author 兔兔答题
     * @date 2021/12/29 14:33
     */
    public function sceneMove()
    {
        return $this->only(['ids', 'cid']);
    }


    /**
     * @notes 删除场景
     * @return FileValidate
     * @author 兔兔答题
     * @date 2021/12/29 14:35
     */
    public function sceneDelete()
    {
        return $this->only(['ids']);
    }
}