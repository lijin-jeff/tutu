<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\common\model\auth;

use app\common\model\BaseModel;

class TenantAdminSession extends BaseModel
{
    /**
     * @notes 关联管理员表
     * @return \think\model\relation\HasOne
     * @author 令狐冲
     * @date 2021/7/5 14:39
     */
    public function admin()
    {
        return $this->hasOne(TenantAdmin::class, 'id', 'admin_id')
            ->field('id,multipoint_login');
    }
}