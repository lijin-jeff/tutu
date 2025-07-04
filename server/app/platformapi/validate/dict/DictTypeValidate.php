<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\validate\dict;


use app\common\model\dict\DictData;
use app\common\model\dict\DictType;
use app\common\validate\BaseValidate;

/**
 * 字典类型验证
 * Class DictTypeValidate
 * @package app\platformapi\validate\dict
 */
class DictTypeValidate extends BaseValidate
{
    
    protected $rule = [
        'id' => 'require|checkDictType',
        'name' => 'require|length:1,255',
        'type' => 'require|unique:' . DictType::class,
        'status' => 'require|in:0,1',
        'remark' => 'max:200',
    ];


    protected $message = [
        'id.require' => '参数缺失',
        'name.require' => '请填写字典名称',
        'name.length' => '字典名称长度须在1~255位字符',
        'type.require' => '请填写字典类型',
        'type.unique' => '字典类型已存在',
        'status.require' => '请选择状态',
        'remark.max' => '备注长度不能超过200',
    ];


    /**
     * @notes 添加场景
     * @return DictTypeValidate
     * @author 兔兔答题
     * @date 2022/6/20 16:00
     */
    public function sceneAdd()
    {
        return $this->remove('id', true);
    }


    /**
     * @notes 详情场景
     * @return DictTypeValidate
     * @author 兔兔答题
     * @date 2022/6/20 16:00
     */
    public function sceneDetail()
    {
        return $this->only(['id']);
    }
    

    public function sceneEdit()
    {
    }


    /**
     * @notes 删除场景
     * @return DictTypeValidate
     * @author 兔兔答题
     * @date 2022/6/20 16:03
     */
    public function sceneDelete()
    {
        return $this->only(['id'])
            ->append('id', 'checkAbleDelete');
    }



    /**
     * @notes 检查字典类型是否存在
     * @param $value
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/6/20 16:04
     */
    protected function checkDictType($value)
    {
        $dictType = DictType::findOrEmpty($value);
        if ($dictType->isEmpty()) {
            return '字典类型不存在';
        }
        return true;
    }



    /**
     * @notes 验证是否可删除
     * @param $value
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/6/20 16:04
     */
    protected function checkAbleDelete($value)
    {
        $dictData = DictData::whereIn('type_id', $value)->select();

        foreach ($dictData as $item) {
            if (!empty($item)) {
                return '字典类型已被使用，请先删除绑定该字典类型的数据';
            }
        }

        return true;
    }



}