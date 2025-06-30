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

use app\common\enum\YesNoEnum;
use app\common\model\auth\AdminJobs;
use app\common\model\BaseModel;
use app\common\model\dept\Dept;
use app\common\model\auth\AdminDept;
use app\common\model\auth\AdminRole;
use think\model\concern\SoftDelete;
use app\common\service\FileService;

class Admin extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    protected $append = [
        'role_id',
        'dept_id',
        'jobs_id',
    ];


    /**
     * @notes 关联角色id
     * @param $value
     * @param $data
     * @return array
     * @author 兔兔答题
     * @date 2022/11/25 15:00
     */
    public function getRoleIdAttr($value, $data)
    {
        return AdminRole::where('admin_id', $data['id'])->column('role_id');
    }


    /**
     * @notes 关联部门id
     * @param $value
     * @param $data
     * @return array
     * @author 兔兔答题
     * @date 2022/11/25 15:00
     */
    public function getDeptIdAttr($value, $data)
    {
        return AdminDept::where('admin_id', $data['id'])->column('dept_id');
    }


    /**
     * @notes 关联岗位id
     * @param $value
     * @param $data
     * @return array
     * @author 兔兔答题
     * @date 2022/11/25 15:01\
     */
    public function getJobsIdAttr($value, $data)
    {
        return AdminJobs::where('admin_id', $data['id'])->column('jobs_id');
    }



    /**
     * @notes 获取禁用状态
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 令狐冲
     * @date 2021/7/7 01:25
     */
    public function getDisableDescAttr($value, $data)
    {
        return YesNoEnum::getDisableDesc($data['disable']);
    }

    /**
     * @notes 最后登录时间获取器 - 格式化：年-月-日 时:分:秒
     * @param $value
     * @return string
     * @author Tab
     * @date 2021/7/13 11:35
     */
    public function getLoginTimeAttr($value)
    {
        return empty($value) ? '' : date('Y-m-d H:i:s', $value);
    }

    /**
     * @notes 头像获取器 - 头像路径添加域名
     * @param $value
     * @return string
     * @author Tab
     * @date 2021/7/13 11:35
     */
    public function getAvatarAttr($value)
    {
        return empty($value) ? FileService::getFileUrl(config('project.platform.admin_avatar')) : FileService::getFileUrl(trim($value, '/'));
    }

}