<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\model\exam;


use app\common\model\BaseModel;
use app\common\model\dict\DictData;
use think\model\concern\SoftDelete;


/**
 * 试题管理模型
 * Class TenantExamQuestion
 * @package app\common\model\exam
 */
class TenantExamQuestion extends BaseModel
{
    use SoftDelete;

    protected $name = 'tenant_exam_question';

    protected $deleteTime = 'delete_time';

    public function getOptionAttr(mixed $name): array
    {
        return json_decode($name, true);
    }

    public function getAnswerAttr(mixed $name): array
    {
        return json_decode($name, true);
    }

    public function getScoreAttr(mixed $score): float
    {
        return floatval($score);
    }

    /**
     * 处理试题类型
     * @param $value
     * @param $data
     * @return string
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:32
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function getExamTypeNameAttr($value, $data): string
    {
        $dictData = DictData::query()->where([
            ['type_id', '=', 10],
            ['status', '=', 1]
        ])->column(['value', 'name']);
        $dictDataGroup = [];
        foreach ($dictData as $item) {
            $dictDataGroup[$item['value']] = $item['name'];
        }
        return $dictDataGroup[$data['exam_type']] ?? '未知题型';
    }
}