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
 * 题库分类验证器
 * Class ExamCategoryValidate
 * @package app\platform\validate\exam
 */
class ExamCategoryValidate extends BaseValidate
{

    /**
     * 设置校验规则
     * @var string[]
     */
    protected $rule = [
        'id'           => 'require',
        'title'        => 'require',
        'is_show'      => 'require|integer',
        'sort'         => 'require',
        'is_recommend' => 'require',
    ];


    /**
     * 参数描述
     * @var string[]
     */
    protected $field = [
        'id'           => 'id',
        'title'        => '分类名称',
        'is_show'      => '启用状态',
        'sort'         => '显示权重',
        'is_recommend' => '是否推荐',
    ];


    /**
     * @notes 添加场景
     * @return ExamCategoryValidate
     * @author 兔兔答题
     * @date 2025/04/01 01:51
     */
    public function sceneAdd(): ExamCategoryValidate
    {
        return $this->only(['title', 'is_show', 'sort', 'is_recommend']);
    }


    /**
     * @notes 编辑场景
     * @return ExamCategoryValidate
     * @author 兔兔答题
     * @date 2025/04/01 01:51
     */
    public function sceneEdit(): ExamCategoryValidate
    {
        return $this->only(['id', 'title', 'is_show', 'sort', 'is_recommend']);
    }


    /**
     * @notes 删除场景
     * @return ExamCategoryValidate
     * @author 兔兔答题
     * @date 2025/04/01 01:51
     */
    public function sceneDelete(): ExamCategoryValidate
    {
        return $this->only(['id']);
    }


    /**
     * @notes 详情场景
     * @return ExamCategoryValidate
     * @author 兔兔答题
     * @date 2025/04/01 01:51
     */
    public function sceneDetail(): ExamCategoryValidate
    {
        return $this->only(['id']);
    }

}