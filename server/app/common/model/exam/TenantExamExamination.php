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
 * 考试管理模型
 * Class TenantExamExamination
 * @package app\common\model\exam
 */
class TenantExamExamination extends BaseModel
{
    use SoftDelete;

    protected $name = 'tenant_exam_examination';

    protected $deleteTime = 'delete_time';

    public function paper(): \think\model\relation\BelongsTo
    {
        return $this->belongsTo(TenantExamPaper::class, 'paper_uid', 'uid');
    }

    /**
     * 处理考试时间状态
     * @param $value
     * @param $data
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function getStatusAttr($value, $data): array
    {
        $examinationInfo = self::query()->where('uid', '=', $data['uid'])->field(['start_time', 'end_time'])->findOrEmpty();
        if (empty($examinationInfo)) {
            return [
                'status' => false,
                'text'   => '考试不存在',
            ];
        }
        $startTime = strtotime($examinationInfo['start_time']);
        $endTime = strtotime($examinationInfo['end_time']);
        if (time() < $startTime) {
            return [
                'status' => false,
                'text'   => '考试未开始',
            ];
        } else if (time() > $endTime) {
            return [
                'status' => false,
                'text'   => '考试已结束',
            ];
        } else {
            return [
                'status' => true,
                'text'   => '考试进行中',
            ];
        }
    }
}