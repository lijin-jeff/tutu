<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。


namespace app\common\lists;


trait ListsSearchTrait
{

    protected array $params;
    protected $searchWhere = [];


    /**
     * @notes 搜索条件生成
     * @param $search
     * @return array
     * @author 令狐冲
     * @date 2021/7/7 19:36
     */
    private function createWhere($search)
    {
        if (empty($search)) {
            return [];
        }
        $where = [];
        foreach ($search as $whereType => $whereFields) {
            switch ($whereType) {
                case '=':
                case '<>':
                case '>':
                case '>=':
                case '<':
                case '<=':
                case 'in':
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || $this->params[$paramsName] == '') {
                            continue;
                        }
                        $where[] = [$whereField, $whereType, $this->params[$paramsName]];
                    }
                    break;
                case '%like%':
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || empty($this->params[$paramsName])) {
                            continue;
                        }
                        $where[] = [$whereField, 'like', '%' . $this->params[$paramsName] . '%'];
                    }
                    break;
                case '%like':
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || empty($this->params[$paramsName])) {
                            continue;
                        }
                        $where[] = [$whereField, 'like', '%' . $this->params[$paramsName]];
                    }
                    break;
                case 'like%':
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || empty($this->params[$paramsName])) {
                            continue;
                        }
                        $where[] = [$whereField, 'like', $this->params[$paramsName] . '%'];
                    }
                    break;
                case 'between_time':
                    if (!is_numeric($this->startTime) || !is_numeric($this->endTime)) {
                        break;
                    }
                    $where[] = [$whereFields, 'between', [$this->startTime, $this->endTime]];
                    break;
                case 'between':
                    if (empty($this->start) || empty($this->end)) {
                        break;
                    }
                    $where[] = [$whereFields, 'between', [$this->start, $this->end]];
                    break;
                case 'find_in_set': // find_in_set查询
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || $this->params[$paramsName] == '') {
                            continue;
                        }
                        $where[] = [$whereField, 'find in set', $this->params[$paramsName]];
                    }
                    break;
            }
        }
        return $where;
    }
}
