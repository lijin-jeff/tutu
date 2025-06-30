<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\model\tools;

use app\common\enum\GeneratorEnum;
use app\common\model\BaseModel;
use app\common\model\tools\GenerateColumn;


/**
 * 代码生成器-数据表信息模型
 * Class GenerateTable
 * @package app\common\model\tools
 */
class GenerateTable extends BaseModel
{

    protected $json = ['menu', 'tree', 'relations', 'delete'];

    protected $jsonAssoc = true;

    /**
     * @notes 关联数据表字段
     * @return \think\model\relation\HasMany
     * @author 兔兔答题
     * @date 2022/6/15 10:46
     */
    public function tableColumn()
    {
        return $this->hasMany(GenerateColumn::class, 'table_id', 'id');
    }

    /**
     * @notes 模板类型描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 兔兔答题
     * @date 2022/6/14 11:25
     */
    public function getTemplateTypeDescAttr($value, $data)
    {
        return GeneratorEnum::getTemplateTypeDesc($data['template_type']);
    }



}