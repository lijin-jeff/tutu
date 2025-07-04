<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\logic\dept;

use app\common\enum\YesNoEnum;
use app\common\logic\BaseLogic;
use app\common\model\dept\Dept;
use app\common\model\dept\TenantDept;


/**
 * 部门管理逻辑
 * Class DeptLogic
 * @package app\platformapi\logic\dept
 */
class DeptLogic extends BaseLogic
{

    /**
     * @notes 部门列表
     * @param $params
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/5/30 15:44
     */
    public static function lists($params)
    {
        $where = [];
        if (!empty($params['name'])) {
            $where[] = ['name', 'like', '%' . $params['name'] . '%'];
        }
        if (isset($params['status']) && $params['status'] != '') {
            $where[] = ['status', '=', $params['status']];
        }
        $lists = Dept::where($where)
            ->append(['status_desc'])
            ->order(['sort' => 'desc', 'id' => 'desc'])
            ->select()
            ->toArray();

        $pid = 0;
        if (!empty($lists)) {
            $pid = min(array_column($lists, 'pid'));
        }
        return self::getTree($lists, $pid);
    }


    /**
     * @notes 列表树状结构
     * @param $array
     * @param int $pid
     * @param int $level
     * @return array
     * @author 兔兔答题
     * @date 2022/5/30 15:44
     */
    public static function getTree($array, $pid = 0, $level = 0)
    {
        $list = [];
        foreach ($array as $key => $item) {
            if ($item['pid'] == $pid) {
                $item['level'] = $level;
                $item['children'] = self::getTree($array, $item['id'], $level + 1);
                $list[] = $item;
            }
        }
        return $list;
    }


    /**
     * @notes 上级部门
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/5/26 18:36
     */
    public static function leaderDept()
    {
        $lists = Dept::field(['id', 'name'])->where(['status' => 1])
            ->order(['sort' => 'desc', 'id' => 'desc'])
            ->select()
            ->toArray();
        return $lists;
    }


    /**
     * @notes 添加部门
     * @param array $params
     * @author 兔兔答题
     * @date 2022/5/25 18:20
     */
    public static function add(array $params)
    {
        Dept::create([
            'pid'    => $params['pid'],
            'name'   => $params['name'],
            'leader' => $params['leader'] ?? '',
            'mobile' => $params['mobile'] ?? '',
            'status' => $params['status'],
            'sort'   => $params['sort'] ?? 0
        ]);
    }


    /**
     * @notes 编辑部门
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/5/25 18:39
     */
    public static function edit(array $params): bool
    {
        try {
            $pid = $params['pid'];
            $oldDeptData = Dept::findOrEmpty($params['id']);
            if ($oldDeptData['pid'] == 0) {
                $pid = 0;
            }

            Dept::update([
                'pid'    => $pid,
                'name'   => $params['name'],
                'leader' => $params['leader'] ?? '',
                'mobile' => $params['mobile'] ?? '',
                'status' => $params['status'],
                'sort'   => $params['sort'] ?? 0
            ], ['id'     => $params['id']]);
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 删除部门
     * @param array $params
     * @author 兔兔答题
     * @date 2022/5/25 18:40
     */
    public static function delete(array $params)
    {
        Dept::destroy($params['id']);
    }


    /**
     * @notes 获取部门详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2022/5/25 18:40
     */
    public static function detail($params): array
    {
        return Dept::findOrEmpty($params['id'])->toArray();
    }


    /**
     * @notes 部门数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 10:19
     */
    public static function getAllData()
    {
        $tenant_id = request()->param('tenant_id');
        $isTenant = $tenant_id !== null;
        $deptModel = $isTenant ? new TenantDept() : new Dept();
        $sql = $deptModel->where(['status' => YesNoEnum::YES])->order(['sort' => 'desc', 'id' => 'desc']);
        if($isTenant) {
            $data = $sql->where('tenant_id', '=', $tenant_id)->select()->toArray();
        } else {
            $data = $sql->select()->toArray();
        }

        if(empty($data)) {
            return [];
        }

        $pid = min(array_column($data, 'pid'));
        return self::getTree($data, $pid);
    }

}