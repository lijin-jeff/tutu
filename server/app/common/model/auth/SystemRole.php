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
use app\common\model\auth\SystemRoleMenu;
use think\model\concern\SoftDelete;

/**
 * 角色模型
 * Class Role
 * @package app\common\model
 */
class SystemRole extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    /**
     * @notes 角色与菜单关联关系
     * @return \think\model\relation\HasMany
     * @author 兔兔答题
     * @date 2022/7/6 11:16
     */
    public function roleMenuIndex()
    {
        return $this->hasMany(SystemRoleMenu::class, 'role_id');
    }
}