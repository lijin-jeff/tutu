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
 * 字典数据验证
 * Class DictDataValidate
 * @package app\platformapi\validate\dict
 */
class DictDataValidate extends BaseValidate
{

    protected $rule = [
        'id' => 'require|checkDictData',
        'name' => 'require|length:1,255',
        'value' => 'require',
        'type_id' => 'require|checkDictType',
        'status' => 'require|in:0,1',
    ];


    protected $message = [
        'id.require' => '参数缺失',
        'name.require' => '请填写字典数据名称',
        'name.length' => '字典数据名称长度须在1-255位字符',
        'value.require' => '请填写字典数据值',
        'type_id.require' => '字典类型缺失',
        'status.require' => '请选择字典数据状态',
        'status.in' => '字典数据状态参数错误',
    ];


    /**
     * @notes 添加场景
     * @return DictDataValidate
     * @author 兔兔答题
     * @date 2022/6/20 16:54
     */
    public function sceneAdd()
    {
        return $this->remove('id', true);
    }


    /**
     * @notes ID场景
     * @return DictDataValidate
     * @author 兔兔答题
     * @date 2022/6/20 16:54
     */
    public function sceneId()
    {
        return $this->only(['id']);
    }


    /**
     * @notes 编辑场景
     * @return DictDataValidate
     * @author 兔兔答题
     * @date 2022/6/20 18:36
     */
    public function sceneEdit()
    {
        return $this->remove('type_id', true);
    }


    /**
     * @notes 校验字典数据
     * @param $value
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/6/20 16:55
     */
    protected function checkDictData($value)
    {
        $article = DictData::findOrEmpty($value);
        if ($article->isEmpty()) {
            return '字典数据不存在';
        }
        return true;
    }


    /**
     * @notes 校验字典类型
     * @param $value
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/6/20 17:03
     */
    protected function checkDictType($value)
    {
        $type = DictType::findOrEmpty($value);
        if ($type->isEmpty()) {
            return '字典类型不存在';
        }
        return true;
    }

}