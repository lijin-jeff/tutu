<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\common\enum\notice;

/**
 * 短信枚举
 * Class SmsEnum
 * @package app\common\enum
 */
class SmsEnum
{
    /**
     * 发送状态
     */
    const SEND_ING = 0;
    const SEND_SUCCESS = 1;
    const SEND_FAIL = 2;

    /**
     * 短信平台
     */
    const ALI = 1;
    const TENCENT = 2;


    /**
     * @notes 获取短信平台名称
     * @param $value
     * @return string
     * @author 兔兔答题
     * @date 2022/8/5 11:10
     */
    public static function getNameDesc($value)
    {
        $desc = [
            'ALI' => '阿里云短信',
            'TENCENT' => '腾讯云短信',
        ];
        return $desc[$value] ?? '';
    }

}