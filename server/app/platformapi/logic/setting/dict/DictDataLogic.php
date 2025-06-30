<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\logic\setting\dict;

use app\common\logic\BaseLogic;
use app\common\model\dict\DictData;
use app\common\model\dict\DictType;


/**
 * 字典数据逻辑
 * Class DictDataLogic
 * @package app\platformapi\logic\DictData
 */
class DictDataLogic extends BaseLogic
{

    /**
     * @notes 添加编辑
     * @param array $params
     * @return DictData|\think\Model
     * @author 兔兔答题
     * @date 2022/6/20 17:13
     */
    public static function save(array $params)
    {
        $data = [
            'name' => $params['name'],
            'value' => $params['value'],
            'sort' => $params['sort'] ?? 0,
            'status' => $params['status'],
            'remark' => $params['remark'] ?? '',
        ];

        if (!empty($params['id'])) {
            return DictData::where(['id' => $params['id']])->update($data);
        } else {
            $dictType = DictType::findOrEmpty($params['type_id']);
            $data['type_id'] = $params['type_id'];
            $data['type_value'] = $dictType['type'];
            return DictData::create($data);
        }
    }


    /**
     * @notes 删除字典数据
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/6/20 17:01
     */
    public static function delete(array $params)
    {
        return DictData::destroy($params['id']);
    }


    /**
     * @notes 获取字典数据详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2022/6/20 17:01
     */
    public static function detail($params): array
    {
        return DictData::findOrEmpty($params['id'])->toArray();
    }


}