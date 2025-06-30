<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\api\validate\exam;

use app\common\validate\BaseValidate;

class ExaminationValidate extends BaseValidate
{
    protected $rule = [
        // 模拟考试提交配置
        'score'              => 'require',
        'option_type_config' => 'require',
        'exam_time'          => 'require|number',
        'checkbox_type'      => 'require|in:1,2',
        'option_type'        => 'require|in:1,2',
        'question_uid'       => 'require',
    ];

    protected $message = [
        'score.require'              => '及格分数不能为空',
        'option_type_config.require' => '题型配置不能为空',
        'exam_time.require'          => '考试时间不能为空',
        'exam_time.number'           => '考试时间格式不正确',
        'checkbox_type.require'      => '多选题得分模式不能为空',
        'checkbox_type.in'           => '多选题得分模式格式错误',
        'option_type.require'        => '选项顺序不能为空',
        'option_type.in'             => '选项顺序格式错误',
        'question_uid.require'       => '题库编号不能为空',
    ];

    /**
     * 模拟考试配置提交
     * @return ExaminationValidate
     */
    public function sceneMock(): ExaminationValidate
    {
        return $this->only(['score', 'option_type_config', 'exam_time', 'checkbox_type', 'option_type', 'question_uid']);
    }
}