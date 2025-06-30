<?php
declare(strict_types=1);
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
use app\common\model\config\TenantBanner;
use think\facade\Db;

class ConfigLogic extends BaseLogic
{
    /**
     * 获取图片配置
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/2 18:13
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function imageList(array $params): array
    {
        return TenantBanner::query()->where([
            ['image_type', '=', $params['type']],
            ['client', '=', $params['client']],
            ['position', '=', $params['position']],
            ['is_show', '=', 1]
        ])->order("sort desc")->field(['title', 'url', 'icon', 'image'])->select()->toArray();
    }

    /**
     * 字典类型列表
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 02:04
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function dictType(): array
    {
        return Db::name('dict_type')->where([
            ['status', '=', 1]
        ])->column(['name', 'type', 'remark']);
    }

    /**
     * 字典数据列表
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 02:05
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function dictData(array $params): array
    {
        if (empty($params['type'])) return [];
        $typeArray = explode(',', $params['type']);
        return Db::name('dict_data')->where([
            ['status', '=', 1]
        ])->whereIn('type_value', $typeArray)->order('sort desc')->column(['name', 'value']);
    }
}