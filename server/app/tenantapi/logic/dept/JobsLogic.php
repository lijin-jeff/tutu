<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\dept;

use app\common\enum\YesNoEnum;
use app\common\logic\BaseLogic;
use app\common\model\dept\TenantJobs;


/**
 * 岗位管理逻辑
 * Class JobsLogic
 * @package app\tenantapi\logic\dept
 */
class JobsLogic extends BaseLogic
{


    /**
     * @notes 新增岗位
     * @param array $params
     * @author 兔兔答题
     * @date 2022/5/26 9:58
     */
    public static function add(array $params)
    {
        TenantJobs::create([
            'name' => $params['name'],
            'code' => $params['code'],
            'sort' => $params['sort'] ?? 0,
            'status' => $params['status'],
            'remark' => $params['remark'] ?? '',
        ]);
    }


    /**
     * @notes 编辑岗位
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/5/26 9:58
     */
    public static function edit(array $params) : bool
    {
        try {
            TenantJobs::update([
                'name' => $params['name'],
                'code' => $params['code'],
                'sort' => $params['sort'] ?? 0,
                'status' => $params['status'],
                'remark' => $params['remark'] ?? '',
            ], ['id' => $params['id']]);
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 删除岗位
     * @param array $params
     * @author 兔兔答题
     * @date 2022/5/26 9:59
     */
    public static function delete(array $params)
    {
        TenantJobs::destroy($params['id']);
    }


    /**
     * @notes 获取岗位详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2022/5/26 9:59
     */
    public static function detail($params) : array
    {
        return TenantJobs::findOrEmpty($params['id'])->toArray();
    }


    /**
     * @notes 岗位数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 10:30
     */
    public static function getAllData()
    {
        return TenantJobs::where(['status' => YesNoEnum::YES])
            ->order(['sort' => 'desc', 'id' => 'desc'])
            ->select()
            ->toArray();
    }

}