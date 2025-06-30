<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\common\model\decorate;


use app\common\model\BaseModel;
use app\common\service\FileService;


/**
 * 装修配置-底部导航
 * Class DecorateTabbar
 * @package app\common\model\decorate
 */
class DecorateTabbar extends BaseModel
{
    // 设置json类型字段
    protected $json = ['link'];

    // 设置JSON数据返回数组
    protected $jsonAssoc = true;


    /**
     * @notes 获取底部导航列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/9/23 12:07
     */
    public static function getTabbarLists()
    {
        $tabbar = self::select()->toArray();

        if (empty($tabbar)) {
           return $tabbar;
        }

        foreach ($tabbar as &$item) {
            if (!empty($item['selected'])) {
                $item['selected'] = FileService::getFileUrl($item['selected']);
            }
            if (!empty($item['unselected'])) {
                $item['unselected'] = FileService::getFileUrl($item['unselected']);
            }
        }

        return $tabbar;
    }
}