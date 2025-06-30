<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
namespace app\api\lists\exam;

use app\api\lists\BaseApiDataLists;
use app\common\model\exam\TenantExamLibrary;

class QuestionlibLists extends BaseApiDataLists
{

    public function setSearch(): array
    {
        return [
        ];
    }

    public function queryWhere(): array
    {
        $where[] = ['is_show', '=', 1];
        $params = request()->all();
        if (!empty($params['recommend_state'])) {
            $where[] = ['recommend_state', '=', $params['recommend_state']];
        }
        if (!empty($params['hot_state'])) {
            $where[] = ['hot_state', '=', $params['hot_state']];
        }
        if (!empty($params['cate_uid'])) {
            $where[] = ['category_uid', '=', $params['cate_uid']];
        }
        if (!empty($params['title'])) {
            $where[] = ['title', 'like', '%' . $params['title'] . '%'];
        }
        return $where;
    }

    /**
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 00:01
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function lists(): array
    {
        $lists = TenantExamLibrary::query()
            ->where($this->queryWhere())
            ->field(['uid', 'image', 'title', 'category_uid', 'create_time'])
            ->append(['cate_name', 'submit_count'])
            ->limit($this->limitOffset, $this->limitLength)
            ->order('sort desc,id desc')
            ->select()
            ->toArray();
        foreach ($lists as &$item) {
            $item['create_time'] = date('Y-m-d', strtotime($item['create_time']));
        }

        return $lists;
    }

    /**
     * @return int
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 00:01
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public function count(): int
    {
        return TenantExamLibrary::query()->where($this->queryWhere())->count();
    }
}