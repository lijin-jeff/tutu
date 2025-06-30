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
 * 题库章节模型
 * Class TenantExamChapter
 * @package app\common\model\exam
 */
class TenantExamChapter extends BaseModel
{
    use SoftDelete;

    protected $name = 'tenant_exam_chapter';

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

    /**
     * 子级章节
     * @param $value
     * @param $data
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题 <tutudati@outlook.com>
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 03:24
     */
    public function getChildrenChapterAttr($value, $data): array
    {
        return self::query()->where([
            ['parent_uid', '=', $data['uid']],
            ['is_show', '=', 1]
        ])->append(['exam_count'])->field(['uid', 'title', 'parent_uid'])->select()->toArray();
    }

    /**
     * 查询章节下的试题总数
     * @param $value
     * @param $data
     * @return int
     * @throws \think\db\exception\DbException
     * @author 兔兔答题 <tutudati@outlook.com>
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 03:27
     */
    public function getExamCountAttr($value, $data): int
    {
        return TenantExamQuestion::query()->where([
            ['chapter_uid', '=', $data['uid']],
            ['is_show', '=', 1]
        ])->count();
    }
}