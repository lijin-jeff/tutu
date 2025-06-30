<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\article;

use app\common\enum\YesNoEnum;
use app\common\logic\BaseLogic;
use app\common\model\article\ArticleCate;

/**
 * 资讯分类管理逻辑
 * Class ArticleCateLogic
 * @package app\tenantapi\logic\article
 */
class ArticleCateLogic extends BaseLogic
{


    /**
     * @notes  添加资讯分类
     * @param array $params
     * @author 兔兔答题
     * @date 2022/2/18 10:17
     */
    public static function add(array $params)
    {
        ArticleCate::create([
            'name' => $params['name'],
            'is_show' => $params['is_show'],
            'sort' => $params['sort'] ?? 0
        ]);
    }


    /**
     * @notes  编辑资讯分类
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/2/21 17:50
     */
    public static function edit(array $params) : bool
    {
        try {
            ArticleCate::update([
                'name' => $params['name'],
                'is_show' => $params['is_show'],
                'sort' => $params['sort'] ?? 0
            ], ['id' => $params['id']]);
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes  删除资讯分类
     * @param array $params
     * @author 兔兔答题
     * @date 2022/2/21 17:52
     */
    public static function delete(array $params)
    {
        ArticleCate::destroy($params['id']);
    }

    /**
     * @notes  查看资讯分类详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2022/2/21 17:54
     */
    public static function detail($params) : array
    {
        return ArticleCate::findOrEmpty($params['id'])->toArray();
    }

    /**
     * @notes  更改资讯分类状态
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/2/21 18:04
     */
    public static function updateStatus(array $params)
    {
        ArticleCate::update([
            'is_show' => $params['is_show']
        ], ['id' => $params['id']]);
        return true;
    }


    /**
     * @notes 文章分类数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/10/13 10:53
     */
    public static function getAllData()
    {
        return ArticleCate::where(['is_show' => YesNoEnum::YES])
            ->order(['sort' => 'desc', 'id' => 'desc'])
            ->select()
            ->toArray();
    }

}