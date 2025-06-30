<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\setting;

use app\common\logic\BaseLogic;
use app\common\model\HotSearch;
use app\common\service\ConfigService;
use app\common\service\FileService;


/**
 * 热门搜素逻辑
 * Class HotSearchLogic
 * @package app\tenantapi\logic\setting
 */
class HotSearchLogic extends BaseLogic
{

    /**
     * @notes 获取配置
     * @return array
     * @author 兔兔答题
     * @date 2022/9/5 18:48
     */
    public static function getConfig()
    {
        return [
            // 功能状态 0-关闭 1-开启
            'status' => ConfigService::get('hot_search', 'status', 0),
            // 热门搜索数据
            'data' => HotSearch::field(['name', 'sort'])->order(['sort' => 'desc', 'id' =>'desc'])->select()->toArray(),
        ];
    }


    /**
     * @notes 设置热门搜搜
     * @param $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/9/5 18:58
     */
    public static function setConfig($params)
    {
        try {
            if (!empty($params['data'])) {
                $model = (new HotSearch());
                $model->where('id', '>', 0)->delete();
                $model->saveAll($params['data']);
            }

            $status = empty($params['status']) ? 0 : $params['status'];
            ConfigService::set('hot_search', 'status', $status);

            return true;
        } catch (\Exception $e) {
            self::$error = $e->getMessage();
            return false;
        }
    }


}