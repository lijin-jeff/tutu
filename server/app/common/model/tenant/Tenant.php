<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\common\model\tenant;


use app\common\enum\YesNoEnum;
use app\common\model\BaseModel;
use app\common\model\user\User;
use app\common\service\FileService;
use think\model\concern\SoftDelete;
use think\facade\Request;

/**
 * 用户模型
 * Class User
 * @package app\common\model\user
 */
class Tenant extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    /**
     * @notes 关联用户模型
     * @author 兔兔答题
     * @date 2022/9/22 16:03
     */
    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id', 'id');
    }

    /**
     * @notes 搜索器-用户信息
     * @param $query
     * @param $value
     * @param $data
     * @author 兔兔答题
     * @date 2022/9/22 16:12
     */
    public function searchKeywordAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('sn|name|tel|domain_alias', 'like', '%' . $value . '%');
        }
    }

    /**
     * @notes 搜索器-注册时间
     * @param $query
     * @param $value
     * @param $data
     * @author 兔兔答题
     * @date 2022/9/22 16:13
     */
    public function searchCreateTimeStartAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('create_time', '>=', strtotime($value));
        }
    }


    /**
     * @notes 搜索器-注册时间
     * @param $query
     * @param $value
     * @param $data
     * @author 兔兔答题
     * @date 2022/9/22 16:13
     */
    public function searchCreateTimeEndAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('create_time', '<=', strtotime($value));
        }
    }

    /**
     * @notes 头像获取器 - 用于头像地址拼接域名
     * @param $value
     * @return string
     * @author Tab
     * @date 2021/7/17 14:28
     */
    public function getAvatarAttr($value)
    {
        return empty($value) ? FileService::getFileUrl(config('project.tenant.admin_avatar')) : FileService::getFileUrl(trim($value, '/'));
    }

    /**
     * @notes 生成用户编码
     * @param $prefix
     * @param $length
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author JXDN
     * @date 2024/09/03 14:32
     */
    public static function createUserSn($prefix = '', $length = 8)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; // 字母和数字的字符集
        $rand_str = '';
        for ($i = 0; $i < $length; $i++) {
            $rand_str .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        $sn = $prefix . $rand_str;

        // 检查是否存在相同的sn
        if (Tenant::where(['sn' => $sn])->find()) {
            return self::createUserSn($prefix, $length); // 递归重新生成
        }

        return $sn;
    }

}