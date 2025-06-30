<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\common\cache;


use app\common\cache\BaseCache;

class WebScanLoginCache extends BaseCache
{

    private $prefix = 'web_scan_';


    /**
     * @notes 获取扫码登录状态标记
     * @param $state
     * @return false|mixed
     * @author 兔兔答题
     * @date 2022/10/20 18:39
     */
    public function getScanLoginState($state)
    {
        return $this->get($this->prefix . $state);
    }


    /**
     * @notes 设置扫码登录状态
     * @param $state
     * @return false|mixed
     * @author 兔兔答题
     * @date 2022/10/20 18:31
     */
    public function setScanLoginState($state)
    {
        $this->set($this->prefix . $state, $state, 600);
        return $this->getScanLoginState($state);
    }


    /**
     * @notes 删除缓存
     * @param $token
     * @return bool
     * @author 兔兔答题
     * @date 2022/9/16 10:13
     */
    public function deleteLoginState($state)
    {
        return $this->delete($this->prefix . $state);
    }


}