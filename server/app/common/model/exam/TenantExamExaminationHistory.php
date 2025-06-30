<?php
// +----------------------------------------------------------------------
// | 兔兔答题开发团队介绍
// +----------------------------------------------------------------------
// | 欢迎你使用本套系统，本套系统由兔兔答题开发团队全力开发。
// | 如果本套系统是商业系统，请严格遵守系统使用相关协议，出现违背协议的法律行为，所有违法行为均与兔兔答题无关。
// | 官网地址：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题团队 版权所有 拥有最终解释权
// +----------------------------------------------------------------------
// | 作者: 兔兔答题开发团队
// +----------------------------------------------------------------------
namespace app\common\model\exam;

use app\common\model\BaseModel;
use think\model\concern\SoftDelete;

class TenantExamExaminationHistory extends BaseModel
{
    use SoftDelete;

    protected $name = 'tenant_exam_examination_history';

    protected $deleteTime = 'delete_time';

    public function examination(): \think\model\relation\BelongsTo
    {
        return $this->belongsTo(TenantExamExamination::class, 'examination_uid', 'uid');
    }
}