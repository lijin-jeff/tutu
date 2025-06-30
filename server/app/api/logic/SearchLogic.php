<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\logic;


use app\common\logic\BaseLogic;
use app\common\model\HotSearch;
use app\common\service\ConfigService;

/**
 * 搜索逻辑
 * Class SearchLogic
 * @package app\api\logic
 */
class SearchLogic extends BaseLogic
{

    /**
     * @notes 热搜列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/23 14:34
     */
    public static function hotLists()
    {
        $data = HotSearch::field(['name', 'sort'])
            ->order(['sort' => 'desc', 'id' => 'desc'])
            ->select()->toArray();

        return [
            // 功能状态 0-关闭 1-开启
            'status' => ConfigService::get('hot_search', 'status', 0),
            // 热门搜索数据
            'data' => $data,
        ];
    }

}