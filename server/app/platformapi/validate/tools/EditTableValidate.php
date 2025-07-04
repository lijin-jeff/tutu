<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\validate\tools;


use app\common\model\tools\GenerateTable;
use app\common\validate\BaseValidate;


/**
 * 编辑表验证
 * Class EditTableValidate
 * @package app\platformapi\validate\tools
 */
class EditTableValidate extends BaseValidate
{

    protected $rule = [
        'id' => 'require|checkTableData',
        'table_name' => 'require',
        'table_comment' => 'require',
        'template_type' => 'require|in:0,1',
        'generate_type' => 'require|in:0,1',
        'module_name' => 'require',
        'table_column' => 'require|array|checkColumn',
    ];

    protected $message = [
        'id.require' => '表id缺失',
        'table_name.require' => '请填写表名称',
        'table_comment.require' => '请填写表描述',
        'template_type.require' => '请选择模板类型',
        'template_type.in' => '模板类型参数错误',
        'generate_type.require' => '请选择生成方式',
        'generate_type.in' => '生成方式类型错误',
        'module_name.require' => '请填写模块名称',
        'table_column.require' => '表字段信息缺失',
        'table_column.array' => '表字段信息类型错误',
    ];


    /**
     * @notes 校验当前数据表是否存在
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/6/15 18:58
     */
    protected function checkTableData($value, $rule, $data)
    {
        $table = GenerateTable::findOrEmpty($value);
        if ($table->isEmpty()) {
            return '信息不存在';
        }
        return true;
    }


    /**
     * @notes 校验表字段参数
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/6/20 10:42
     */
    protected function checkColumn($value, $rule, $data)
    {
        foreach ($value as $item) {
            if (!isset($item['id'])) {
                return '表字段id参数缺失';
            }
            if (!isset($item['query_type'])) {
                return '请选择查询方式';
            }
            if (!isset($item['view_type'])) {
                return '请选择显示类型';
            }
        }
        return true;
    }

}