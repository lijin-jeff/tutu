<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\api\controller;


use app\api\logic\SearchLogic;

/**
 * 搜索
 * Class HotSearchController
 * @package app\api\controller
 */
class SearchController extends BaseApiController
{

    public array $notNeedLogin = ['hotLists'];

    /**
     * @notes 热门搜素
     * @return \think\response\Json
     * @author 兔兔答题
     * @date 2022/9/22 10:14
     */
    public function hotLists()
    {
        return $this->data(SearchLogic::hotLists());
    }

}