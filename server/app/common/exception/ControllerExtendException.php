<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

declare (strict_types=1);

namespace app\common\exception;

use think\Exception;

/**
 * 控制器继承异常
 * Class ControllerExtendException
 * @package app\common\exception
 */
class ControllerExtendException extends Exception
{
    /**
     * 构造方法
     * @access public
     * @param string $message
     * @param string $model
     * @param array $config
     */
    public function __construct(string $message, string $model = '', array $config = [])
    {
        $this->message = '控制器需要继承模块的基础控制器：' . $message;
        $this->model = $model;
    }
}