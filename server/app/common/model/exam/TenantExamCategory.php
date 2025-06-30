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
use think\model\relation\HasMany;


/**
 * 题库分类模型
 * Class ExamCategory
 * @package app\common\model\exam
 */
class TenantExamCategory extends BaseModel
{
    use SoftDelete;

    protected $name = 'tenant_exam_category';

    protected $deleteTime = 'delete_time';

    /**
     * 获取子类
     * @return HasMany
     * @author 兔兔答题
     * @link https://www.tutudati.com
     * @date 2024/4/21 00:51
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, "parent_uid", "uid");
    }
}