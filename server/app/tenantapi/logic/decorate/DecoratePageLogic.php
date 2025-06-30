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
use app\common\model\decorate\DecoratePage;


/**
 * 装修页面
 * Class DecoratePageLogic
 * @package app\tenantapi\logic\theme
 */
class DecoratePageLogic extends BaseLogic
{


    /**
     * @notes 获取详情
     * @param array $params
     * @return array
     * @author 兔兔答题
     * @date 2022/9/14 18:41
     */
    public static function getDetail(array $params): array
    {
        return DecoratePage::where($params)->findOrEmpty()->toArray();
    }


    /**
     * @notes 保存装修配置
     * @param $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/9/15 9:37
     */
    public static function save($params): bool
    {
        $pageData = DecoratePage::where(['id' => $params['id']])->findOrEmpty();
        if ($pageData->isEmpty()) {
            self::$error = '信息不存在';
            return false;
        }
        DecoratePage::update([
            'type' => $params['type'],
            'data' => $params['data'],
            'meta' => $params['meta'] ?? '',
        ], ['id' => $params['id']]);
        return true;
    }


}