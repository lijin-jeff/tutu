<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\common\logic;


/**
 * 逻辑基类
 * Class BaseLogic
 * @package app\common\logic
 */
class BaseLogic
{
    /**
     * 错误信息
     * @var string
     */
    protected static $error;

    /**
     * 返回状态码
     * @var int
     */
    protected static $returnCode = 0;


    protected static $returnData;

    /**
     * @notes 获取错误信息
     * @return string
     * @author 兔兔答题
     * @date 2021/7/21 18:23
     */
    public static function getError() : string
    {
        if (false === self::hasError()) {
            return '系统错误';
        }
        return self::$error;
    }


    /**
     * @notes 设置错误信息
     * @param $error
     * @author 兔兔答题
     * @date 2021/7/21 18:20
     */
    public static function setError($error) : void
    {
        !empty($error) && self::$error = $error;
    }


    /**
     * @notes 是否存在错误
     * @return bool
     * @author 兔兔答题
     * @date 2021/7/21 18:32
     */
    public static function hasError() : bool
    {
        return !empty(self::$error);
    }


    /**
     * @notes 设置状态码
     * @param $code
     * @author 兔兔答题
     * @date 2021/7/28 17:05
     */
    public static function setReturnCode($code) : void
    {
        self::$returnCode = $code;
    }


    /**
     * @notes 特殊场景返回指定状态码,默认为0
     * @return int
     * @author 兔兔答题
     * @date 2021/7/28 15:14
     */
    public static function getReturnCode() : int
    {
        return self::$returnCode;
    }

    /**
     * @notes 获取内容
     * @return mixed
     * @author cjhao
     * @date 2021/9/11 17:29
     */
    public static function getReturnData()
    {
        return self::$returnData;
    }

}