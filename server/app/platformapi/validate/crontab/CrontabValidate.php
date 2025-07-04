<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\platformapi\validate\crontab;

use app\common\validate\BaseValidate;
use Cron\CronExpression;

/**
 * 定时任务验证器
 * Class CrontabValidate
 * @package app\platformapi\validate\crontab
 */
class CrontabValidate extends BaseValidate
{
    protected $rule = [
        'name' => 'require',
        'type' => 'require|in:1',
        'command' => 'require',
        'status' => 'require|in:1,2,3',
        'expression' => 'require|checkExpression',
        'id' => 'require',
        'operate' => 'require'
    ];

    protected $message = [
        'name.require' => '请输入定时任务名称',
        'type.require' => '请选择类型',
        'type.in' => '类型值错误',
        'command.require' => '请输入命令',
        'status.require' => '请选择状态',
        'status.in' => '状态值错误',
        'expression.require' => '请输入运行规则',
        'id.require' => '参数缺失',
        'operate.require' => '请选择操作',
    ];


    /**
     * @notes 添加定时任务场景
     * @return CrontabValidate
     * @author 兔兔答题
     * @date 2022/3/29 14:39
     */
    public function sceneAdd()
    {
        return $this->remove('id', 'require')->remove('operate', 'require');
    }


    /**
     * @notes 查看定时任务详情场景
     * @return CrontabValidate
     * @author 兔兔答题
     * @date 2022/3/29 14:39
     */
    public function sceneDetail()
    {
        return $this->only(['id']);
    }


    /**
     * @notes 编辑定时任务
     * @return CrontabValidate
     * @author 兔兔答题
     * @date 2022/3/29 14:39
     */
    public function sceneEdit()
    {
        return $this->remove('operate', 'require');
    }


    /**
     * @notes 删除定时任务场景
     * @return CrontabValidate
     * @author 兔兔答题
     * @date 2022/3/29 14:40
     */
    public function sceneDelete()
    {
        return $this->only(['id']);
    }


    /**
     * @notes CrontabValidate
     * @return CrontabValidate
     * @author 兔兔答题
     * @date 2022/3/29 14:40
     */
    public function sceneOperate()
    {
        return $this->only(['id', 'operate']);
    }


    /**
     * @notes 获取规则执行时间场景
     * @return CrontabValidate
     * @author 兔兔答题
     * @date 2022/3/29 14:40
     */
    public function sceneExpression()
    {
        return $this->only(['expression']);
    }


    /**
     * @notes 校验运行规则
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 兔兔答题
     * @date 2022/3/29 14:40
     */
    public function checkExpression($value, $rule, $data)
    {
        if (CronExpression::isValidExpression($value) === false) {
            return '定时任务运行规则错误';
        }
        return true;
    }
}