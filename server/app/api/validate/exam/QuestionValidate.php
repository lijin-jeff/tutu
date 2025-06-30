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

class QuestionValidate extends BaseValidate
{
    protected $rule = [
        'uid'            => 'require',
        'question_count' => 'require|number',
        'chapter_uid'    => 'require',
        'library_uid'    => 'require',
        'question_uid'   => 'require',
        'action'         => 'require|in:1,2',
    ];

    protected $message = [
        'uid.require'            => '题库编号不能为空',
        'question_count.require' => '试题数量不能为空',
        'question_count.number'  => '试题数量必须为数字',
        'chapter_uid.require'    => '章节编号不能为空',
        'library_uid.require'    => '题库编号不能为空',
        'question_uid.require'   => '试题编号不能为空',
        'action.require'         => '操作类型不能为空',
        'action.in'              => '操作类型错误',
    ];

    /**
     * 收藏试题
     * @return QuestionValidate
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function sceneCollection(): QuestionValidate
    {
        return $this->only(['library_uid', 'question_uid', 'action']);
    }

    /**
     * 错题移除
     * @return QuestionValidate
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function sceneError(): QuestionValidate
    {
        return $this->only(['library_uid', 'question_uid']);
    }

    /**
     * 题库详情等类型的验证
     * @return QuestionValidate
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:58
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function sceneDetail(): QuestionValidate
    {
        return $this->only(['uid']);
    }

    /**
     * 随机练习试题列表
     * @return QuestionValidate
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:58
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function sceneRand(): QuestionValidate
    {
        return $this->only(['uid', 'question_count']);
    }

    /**
     * 顺序练习试题列表
     * @return QuestionValidate
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:58
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function sceneOrder(): QuestionValidate
    {
        return $this->only(['uid']);
    }

    /**
     * 章节练习试题列表
     * @return QuestionValidate
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:58
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function sceneChapter(): QuestionValidate
    {
        return $this->only(['uid', 'chapter_uid']);
    }
}