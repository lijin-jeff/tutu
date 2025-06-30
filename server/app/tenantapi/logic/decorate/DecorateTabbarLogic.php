<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\tenantapi\logic\decorate;

use app\common\logic\BaseLogic;
use app\common\model\decorate\DecorateTabbar;
use app\common\service\ConfigService;
use app\common\service\FileService;


/**
 * 装修配置-底部导航
 * Class DecorateTabbarLogic
 * @package app\tenantapi\logic\decorate
 */
class DecorateTabbarLogic extends BaseLogic
{

    /**
     * @notes 获取底部导航详情
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/7 16:58
     */
    public static function detail(): array
    {
        $list = DecorateTabbar::getTabbarLists();
        $style = ConfigService::get('tabbar', 'style', config('project.decorate.tabbar_style'));
        return ['style' => $style, 'list' => $list];
    }


    /**
     * @notes 底部导航保存
     * @param $params
     * @return bool
     * @throws \Exception
     * @author 兔兔答题
     * @date 2022/9/7 17:19
     */
    public static function save($params): bool
    {
        $model = new DecorateTabbar();
        // 删除旧配置数据
        $model->where('id', '>', 0)->delete();

        // 保存数据
        $tabbars = $params['list'] ?? [];
        $data = [];
        foreach ($tabbars as $item) {
            $data[] = [
                'name' => $item['name'],
                'selected' => FileService::setFileUrl($item['selected']),
                'unselected' => FileService::setFileUrl($item['unselected']),
                'link' => $item['link'],
                'is_show' => $item['is_show'] ?? 0,
            ];
        }
        $model->saveAll($data);

        if (!empty($params['style'])) {
            ConfigService::set('tabbar', 'style', $params['style']);
        }
        return true;
    }

}