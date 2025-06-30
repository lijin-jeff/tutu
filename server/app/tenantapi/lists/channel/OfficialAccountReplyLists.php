<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\lists\channel;

use app\tenantapi\lists\BaseAdminDataLists;
use app\common\lists\ListsSearchInterface;
use app\common\model\channel\OfficialAccountReply;

/**
 * 微信公众号回复列表
 * Class OfficialAccountLists
 * @package app\tenantapi\lists
 */
class OfficialAccountReplyLists extends BaseAdminDataLists implements ListsSearchInterface
{

    /**
     * @notes 设置搜索
     * @return \string[][]
     * @author 兔兔答题
     * @date 2022/3/30 15:02
     */
    public function setSearch(): array
    {
        return [
            '=' => ['reply_type']
        ];
    }


    /**
     * @notes 回复列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author 兔兔答题
     * @date 2022/3/30 15:02
     */
    public function lists(): array
    {
        $field = 'id,name,keyword,matching_type,content,content_type,status,sort';
        $field .= ',matching_type as matching_type_desc,content_type as content_type_desc,status as status_desc';

        $lists = OfficialAccountReply::field($field)
            ->where($this->searchWhere)
            ->order(['sort' => 'desc', 'id' => 'desc'])
            ->limit($this->limitOffset, $this->limitLength)
            ->select()
            ->toArray();

        return $lists;
    }


    /**
     * @notes 回复记录数
     * @return int
     * @author 兔兔答题
     * @date 2022/3/30 15:02
     */
    public function count(): int
    {
        $count = OfficialAccountReply::where($this->searchWhere)->count();

        return $count;
    }
}