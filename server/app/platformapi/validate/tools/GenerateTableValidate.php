<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\validate\tools;


use app\common\model\tools\GenerateTable;
use app\common\validate\BaseValidate;
use think\facade\Db;


/**
 * 代码生成选择表验证
 * Class SelectTableValidate
 * @package app\platformapi\validate\tools
 */
class GenerateTableValidate extends BaseValidate
{

    protected $rule = [
        'id' => 'require|checkTableData',
        'table' => 'require|array|checkTable',
        'file' => 'require'
    ];

    protected $message = [
        'id.require' => '参数缺失',
        'table.require' => '参数缺失',
        'table.array' => '参数类型错误',
        'file.require' => '下载失败',
    ];


    /**
     * @notes 选择数据表场景
     * @return GenerateTableValidate
     * @author 兔兔答题
     * @date 2022/6/15 18:58
     */
    public function sceneSelect()
    {
        return $this->only(['table']);
    }


    /**
     * @notes 需要校验id的场景
     * @return GenerateTableValidate
     * @author 兔兔答题
     * @date 2022/6/15 18:58
     */
    public function sceneId()
    {
        return $this->only(['id']);
    }


    /**
     * @notes 下载场景
     * @return GenerateTableValidate
     * @author 兔兔答题
     * @date 2022/6/24 10:02
     */
    public function sceneDownload()
    {
        return $this->only(['file']);
    }


    /**
     * @notes 校验选择的数据表信息
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/6/15 18:58
     */
    protected function checkTable($value, $rule, $data)
    {
        foreach ($value as $item) {
            if (!isset($item['name']) || !isset($item['comment'])) {
                return '参数缺失';
            }
            $exist = Db::query("SHOW TABLES LIKE'" . $item['name'] . "'");
            if (empty($exist)) {
                return '当前数据库不存在' . $item['name'] . '表';
            }
        }
        return true;
    }


    /**
     * @notes 校验当前数据表是否存在
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/6/15 18:58
     */
    protected function checkTableData($value, $rule, $data)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        foreach ($value as $item) {
            $table = GenerateTable::findOrEmpty($item);
            if ($table->isEmpty()) {
                return '信息不存在';
            }
        }

        return true;
    }


}