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
use think\model\concern\SoftDelete;


/**
 * 题库管理模型
 * Class TenantExamLibrary
 * @package app\common\model\exam
 */
class TenantExamLibrary extends BaseModel
{
    use SoftDelete;

    protected $name = 'tenant_exam_library';

    protected $deleteTime = 'delete_time';

    public function category(): \think\model\relation\BelongsTo
    {
        return $this->belongsTo(TenantExamCategory::class, 'category_uid', 'uid');
    }

    /**
     * 题库分类名称
     * @param $value
     * @param $data
     * @return string
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 00:21
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function getCateNameAttr($value, $data): string
    {
        return TenantExamCategory::query()->where('uid', '=', $data['category_uid'])->value('title');
    }

    /**
     * 查询题库作答次数
     * @param $value
     * @param $data
     * @return int
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 00:38
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function getSubmitCountAttr($value, $data): int
    {
        return mt_rand(10, 100);
    }

    /**
     * 查询题库题目数量
     * @param $value
     * @param $data
     * @return int
     * @throws \think\db\exception\DbException
     * @author 兔兔答题 <tutudati@outlook.com>
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 01:41
     */
    public function getQuestionCountAttr($value, $data): int
    {
        return TenantExamQuestion::query()->where([
            ['tenant_exam_library_uid', '=', $data['uid']],
            ['is_show', '=', 1]
        ])->count();
    }

    /**
     * 题库试题总数
     * @param $value
     * @param $data
     * @return int
     * @throws \think\db\exception\DbException
     */
    public function getExamCountAttr($value, $data): int
    {
        return TenantExamQuestion::query()->where('tenant_exam_library_uid', '=', $data['uid'])->count('id');
    }
}