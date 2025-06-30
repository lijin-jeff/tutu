<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\validate\auth;


use app\common\validate\BaseValidate;
use app\common\model\auth\{
    app\platformapi\config\common\model\auth\AdminRole, app\platformapi\config\common\model\auth\SystemRole, app\platformapi\config\common\model\auth\Admin};

/**
 * 角色验证器
 * Class RoleValidate
 * @package app\platformapi\validate\auth
 */
class RoleValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|checkRole',
        'name' => 'require|max:64|unique:' . \app\common\model\auth\SystemRole::class . ',name',
        'menu_id' => 'array',
    ];

    protected $message = [
        'id.require' => '请选择角色',
        'name.require' => '请输入角色名称',
        'name.max' => '角色名称最长为16个字符',
        'name.unique' => '角色名称已存在',
        'menu_id.array' => '权限格式错误'
    ];

    /**
     * @notes 添加场景
     * @return RoleValidate
     * @author 兔兔答题
     * @date 2021/12/29 15:47
     */
    public function sceneAdd()
    {
        return $this->only(['name', 'menu_id']);
    }

    /**
     * @notes 详情场景
     * @return RoleValidate
     * @author 兔兔答题
     * @date 2021/12/29 15:47
     */
    public function sceneDetail()
    {
        return $this->only(['id']);
    }

    /**
     * @notes 删除场景
     * @return RoleValidate
     * @author 兔兔答题
     * @date 2021/12/29 15:48
     */
    public function sceneDel()
    {
        return $this->only(['id'])
            ->append('id', 'checkAdmin');
    }


    /**
     * @notes 验证角色是否存在
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2021/12/29 15:48
     */
    public function checkRole($value, $rule, $data)
    {
        if (!\app\common\model\auth\SystemRole::find($value)) {
            return '角色不存在';
        }
        return true;
    }



    /**
     * @notes 验证角色是否被使用
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2021/12/29 15:49
     */
    public function checkAdmin($value, $rule, $data)
    {
        if (\app\common\model\auth\AdminRole::where(['role_id' => $value])->find()) {
            return '有管理员在使用该角色，不允许删除';
        }
        return true;
    }

}