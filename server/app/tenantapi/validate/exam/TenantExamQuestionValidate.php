<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\validate\exam;


use app\common\validate\BaseValidate;


/**
 * 试题管理验证器
 * Class TenantExamQuestionValidate
 * @package app\platform\validate\exam
 */
class TenantExamQuestionValidate extends BaseValidate
{

    /**
     * 设置校验规则
     * @var string[]
     */
    protected $rule = [
        'id'                      => 'require',
        'tenant_exam_library_uid' => 'require',
        'title'                   => 'require|checkTitle',
        'option'                  => 'require',
        'score'                   => 'require',
        'answer'                  => 'require',
        'exam_type'               => 'require|in:1,2,3,4,5,6,7,8',
        'sort'                    => 'require',
        'is_show'                 => 'require',
        'level'                   => 'require',
    ];


    /**
     * 参数描述
     * @var string[]
     */
    protected $field = [
        'id'                      => 'id',
        'tenant_exam_library_uid' => '试题题库',
        'title'                   => '试题题干',
        'option'                  => '试题选项',
        'score'                   => '试题积分',
        'answer'                  => '试题答案',
        'exam_type'               => '试题题型',
        'sort'                    => '显示权重',
        'is_show'                 => '显示状态',
        'level'                   => '试题难度',
    ];

    /**
     * @return TenantExamQuestionValidate
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/4/13 02:56
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function sceneList(): TenantExamQuestionValidate
    {
        return $this->only(["tenant_exam_library_uid"]);
    }

    /**
     * @notes 添加场景
     * @return TenantExamQuestionValidate
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public function sceneAdd(): TenantExamQuestionValidate
    {
        return $this->only(['tenant_exam_library_uid', 'title', 'option', 'score', 'answer', 'exam_type', 'sort', 'is_show', 'level']);
    }


    /**
     * @notes 编辑场景
     * @return TenantExamQuestionValidate
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public function sceneEdit(): TenantExamQuestionValidate
    {
        return $this->only(['id', 'tenant_exam_library_uid', 'title', 'option', 'score', 'answer', 'exam_type', 'sort', 'is_show', 'level']);
    }


    /**
     * @notes 删除场景
     * @return TenantExamQuestionValidate
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public function sceneDelete(): TenantExamQuestionValidate
    {
        return $this->only(['id']);
    }


    /**
     * @notes 详情场景
     * @return TenantExamQuestionValidate
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public function sceneDetail(): TenantExamQuestionValidate
    {
        return $this->only(['id']);
    }

    /**
     * @param $value
     * @return bool|string
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/4/13 03:47
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function checkTitle($value): bool|string
    {
        $title = strip_tags(html_entity_decode($value));
        if (empty($title)) {
            return "试题题干不能为空";
        }
        return true;
    }

}