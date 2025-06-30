<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\platformapi\lists\tenant;

use app\common\model\auth\TenantAdmin;
use app\tenantapi\lists\BaseAdminDataLists;
use app\common\enum\user\UserTerminalEnum;
use app\common\lists\ListsExcelInterface;
use app\common\model\tenant\Tenant;


/**
 * 用户列表
 * Class TenantLists
 * @package app\tenantapi\lists\user
 */
class TenantAdminLists extends BaseAdminDataLists implements ListsExcelInterface
{

    /**
     * @notes 搜索条件
     * @return array
     * @author 兔兔答题
     * @date 2022/9/22 15:50
     */
    public function setSearch(): array
    {
        $allowSearch = ['keyword', 'create_time_start', 'create_time_end','tenant_id'];
        return array_intersect(array_keys($this->params), $allowSearch);
    }


    /**
     * @notes 获取用户列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/22 15:50
     */
    public function lists(): array
    {
        //进行参数校验 租户标识必填
        if(!isset($this->params['tenant_id'])){
            return [];
        }

        $field = "id,root,name,avatar,account,multipoint_login,disable,create_time";

        $lists = TenantAdmin::withSearch($this->setSearch(), $this->params)
            ->limit($this->limitOffset, $this->limitLength)
            ->field($field)
            ->order('create_time desc')
            ->select()->toArray();


        return $lists;
    }


    /**
     * @notes 获取数量
     * @return int
     * @author 兔兔答题
     * @date 2022/9/22 15:51
     */
    public function count(): int
    {
        return TenantAdmin::withSearch($this->setSearch(), $this->params)->count();
    }


    /**
     * @notes 导出文件名
     * @return string
     * @author 兔兔答题
     * @date 2022/11/24 16:17
     */
    public function setFileName(): string
    {
        return '租户用户列表';
    }


    /**
     * @notes 导出字段
     * @return string[]
     * @author 兔兔答题
     * @date 2022/11/24 16:17
     */
    public function setExcelFields(): array
    {
        return [
            'root' => '是否超级管理员',
            'name' => '租户账户昵称',
            'avatar' => '头像',
            'account' => '账号',
            'multipoint_login' => '是否允许多处登录',
            'disable' => '是否禁用',
            'create_time' => '注册时间',
        ];
    }

}