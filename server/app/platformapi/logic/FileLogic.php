<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\logic;


use app\common\logic\BaseLogic;
use app\common\model\file\File;
use app\common\model\file\FileCate;
use app\common\service\ConfigService;
use app\common\service\storage\Driver as StorageDriver;

/**
 * 文件逻辑层
 * Class FileLogic
 * @package app\platformapi\logic
 */
class FileLogic extends BaseLogic
{
    /**
     * @notes 移动文件
     * @param $params
     * @author 张无忌
     * @date 2021/7/28 15:29
     */
    public static function move($params)
    {
        (new File())->whereIn('id', $params['ids'])
            ->update([
                'cid' => $params['cid'],
                'update_time' => time()
            ]);
    }

    /**
     * @notes 重命名文件
     * @param $params
     * @author 张无忌
     * @date 2021/7/29 17:16
     */
    public static function rename($params)
    {
        (new File())->where('id', $params['id'])
            ->update([
                'name' => $params['name'],
                'update_time' => time()
            ]);
    }

    /**
     * @notes 批量删除文件
     * @param $params
     * @author 张无忌
     * @date 2021/7/28 15:41
     */
    public static function delete($params)
    {
        $result = File::whereIn('id', $params['ids'])->select();
        $StorageDriver = new StorageDriver([
            'default' => ConfigService::get('storage', 'default', 'local'),
            'engine'  => ConfigService::get('storage') ?? ['local'=>[]],
        ]);
        foreach ($result as $item) {
            $StorageDriver->delete($item['uri']);
        }
        File::destroy($params['ids']);
    }

    /**
     * @notes 添加文件分类
     * @param $params
     * @author 张无忌
     * @date 2021/7/28 11:32
     */
    public static function addCate($params)
    {
        FileCate::create([
            'type' => $params['type'],
            'pid' => $params['pid'],
            'name' => $params['name']
        ]);
    }

    /**
     * @notes 编辑文件分类
     * @param $params
     * @author 张无忌
     * @date 2021/7/28 14:03
     */
    public static function editCate($params)
    {
        FileCate::update([
            'name' => $params['name'],
            'update_time' => time()
        ], ['id' => $params['id']]);
    }

    /**
     * @notes 删除文件分类
     * @param $params
     * @author 张无忌
     * @date 2021/7/28 14:21
     */
    public static function delCate($params)
    {
        $fileModel = new File();
        $cateModel = new FileCate();

        $cateIds = self::getCateIds($params['id']);
        array_push($cateIds, $params['id']);

        // 删除分类及子分类
        $cateModel->whereIn('id', $cateIds)->update(['delete_time' => time()]);

        // 删除文件
        $fileIds = $fileModel->whereIn('cid', $cateIds)->column('id');

        if (!empty($fileIds)) {
            self::delete(['ids' => $fileIds]);
        }
    }


    /**
     * @notes 获取所有分类id
     * @param $parentId
     * @param array $cateArr
     * @return array
     * @author 兔兔答题
     * @date 2024/2/7 15:03
     */
    public static function getCateIds($parentId, array $cateArr = []): array
    {
        $childIds = FileCate::where(['pid' => $parentId])->column('id');

        if (empty($childIds)) {
            return $childIds;
        } else {
            $allChildIds = $childIds;
            foreach ($childIds as $childId) {
                $allChildIds = array_merge($allChildIds, static::getCateIds($childId, $cateArr));
            }
            return $allChildIds;
        }
    }

}