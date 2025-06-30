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
namespace app\api\logic\exam;

use app\common\logic\BaseLogic;
use app\common\model\exam\TenantExamChapter;
use app\common\model\exam\TenantExamExamination;
use app\common\model\exam\TenantExamLibrary;
use app\common\model\exam\TenantExamLibraryCollection;
use app\common\model\exam\TenantExamLibraryRemove;
use app\common\model\exam\TenantExamPaper;
use app\common\model\exam\TenantExamQuestion;
use app\common\model\exam\TenantMockExamExamination;
use think\facade\Db;

class QuestionlibLogic extends BaseLogic
{
    private static function queryWhere(array $params): array
    {
        $where[] = ['is_show', '=', 1];
        if (!empty($params['uid'])) {
            $where[] = ['uid', '=', $params['uid']];
        }
        return $where;
    }

    /**
     * 题库详情
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 01:23
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function questionLibDetail(array $params): array
    {
        $questionLibrary = TenantExamLibrary::query()->where(self::queryWhere($params))
            ->append(['question_count'])
            ->field(['uid', 'title', 'create_time', 'author', 'image'])
            ->findOrEmpty();
        if ($questionLibrary->isEmpty()) return [];
        $questionLibrary = $questionLibrary->toArray();
        $questionLibrary['create_time'] = date('Y-m-d', strtotime($questionLibrary['create_time']));
        return $questionLibrary;
    }

    /**
     * 随机练习试题列表
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:27
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function randOptionList(array $params): array
    {
        $items = TenantExamQuestion::query()->where([
            ['tenant_exam_library_uid', '=', $params['uid']],
            ['is_show', '=', 1]
        ])->field(['uid', 'uid', 'title', 'answer', 'option', 'analysis', 'exam_type', 'level'])
            ->append(['exam_type_name'])
            ->orderRaw('RAND()')
            ->limit((int)$params['question_count'])
            ->order('sort desc, id desc')
            ->select()
            ->toArray();
        foreach ($items as &$item) {
            $item['status'] = 'default';
            $item['is_selected'] = false;
            foreach ($item['option'] as &$option) {
                $option['is_selected'] = false;
                $option['status'] = 'default';
            }
        }

        return $items;
    }

    /**
     * 试题搜索列表
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:27
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function searchOptionList(array $params): array
    {
        $pageNo = (int)(isset($params['page_no']) ? $params['page_no'] : 1);
        $pageSize = (int)(isset($params['page_size']) ? $params['page_size'] : 20);
        $pageSize = min($pageSize, 20);
        $items = TenantExamQuestion::query()->where([
            ['tenant_exam_library_uid', '=', $params['uid']],
            ['is_show', '=', 1]
        ])->where(function ($query) use ($params) {
            if (!empty($params['keywords'])) {
                $query->whereLike('title', '%' . $params['keywords'] . '%');
            }
        })->field(['uid', 'uid', 'title', 'answer', 'option', 'analysis', 'exam_type', 'level', 'score'])
            ->append(['exam_type_name'])
            ->paginate([
                'list_rows' => $pageSize,
                'page'      => $pageNo
            ]);
        $userCollection = TenantExamLibraryCollection::query()->where([
            ['library_uid', '=', $params['uid']],
            ['user_uid', '=', $params['user_uid']]
        ])->column('question_uid');
        foreach ($items->items() as $value) {
            $value['is_collection'] = false;
            if (in_array($value['uid'], $userCollection)) {
                $value['is_collection'] = true;
            }
        }
        return [
            'lists'     => $items->items(),
            'page_no'   => $pageNo,
            'page_size' => $pageSize,
            'count'     => $items->total(),
            'extend'    => []
        ];
    }

    /**
     * 顺序练习试题列表
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:27
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function orderOptionList(array $params): array
    {
        $items = TenantExamQuestion::query()->where([
            ['tenant_exam_library_uid', '=', $params['uid']],
            ['is_show', '=', 1]
        ])->field(['uid', 'uid', 'title', 'answer', 'option', 'analysis', 'exam_type', 'level'])
            ->append(['exam_type_name'])
            ->order('sort desc, id desc')
            ->select()
            ->toArray();
        foreach ($items as &$item) {
            $item['status'] = 'default';
            $item['is_selected'] = false;
            foreach ($item['option'] as &$option) {
                $option['is_selected'] = false;
                $option['status'] = 'default';
            }
        }

        return $items;
    }

    /**
     * 试题收藏列表
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function collectionOptionList(array $params): array
    {
        $questionUid = TenantExamLibraryCollection::query()->where([
            ['library_uid', '=', $params['uid']],
            ['user_uid', '=', $params['user_uid']]
        ])->column('question_uid');
        $items = TenantExamQuestion::query()->whereIn('uid', $questionUid)->where([
            ['is_show', '=', 1]
        ])->field(['uid', 'uid', 'title', 'answer', 'option', 'analysis', 'exam_type', 'level'])
            ->append(['exam_type_name'])
            ->order('sort desc, id desc')
            ->select()
            ->toArray();
        foreach ($items as &$item) {
            $item['status'] = 'default';
            $item['is_selected'] = false;
            foreach ($item['option'] as &$option) {
                $option['is_selected'] = false;
                $option['status'] = 'default';
            }
        }

        return $items;
    }

    /**
     * 历史错题记录
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function errorOptionList(array $params): array
    {
        $errorOptionUid = TenantMockExamExamination::query()->where([
            ['question_uid', '=', $params['uid']],
            ['user_uid', '=', $params['user_uid']]
        ])->field('error_option')->select()->toArray();
        if (count($errorOptionUid) === 0) return [];
        $optionUid = [];
        foreach ($errorOptionUid as $value) {
            if (count($value['error_option']) > 0) {
                array_push($optionUid, ... $value['error_option']);
            }
        }
        $optionUid = array_unique($optionUid);
        if (count($optionUid) === 0) return [];
        $removeOptionUid = TenantExamLibraryRemove::query()->where([
            ['library_uid', '=', $params['uid']],
            ['user_uid', '=', $params['user_uid']]
        ])->column(['question_uid']);
        $fullOptionUid = [];
        if (count($removeOptionUid)) {
            $fullOptionUid = array_diff($optionUid, $removeOptionUid);
        } else {
            $fullOptionUid = $optionUid;
        }
        if (count($fullOptionUid) === 0) return [];
        $items = TenantExamQuestion::query()->whereIn('uid', $fullOptionUid)->where([
            ['is_show', '=', 1]
        ])->field(['uid', 'uid', 'title', 'answer', 'option', 'analysis', 'exam_type', 'level'])
            ->append(['exam_type_name'])
            ->order('sort desc, id desc')
            ->select()
            ->toArray();
        foreach ($items as &$item) {
            $item['status'] = 'default';
            $item['is_selected'] = false;
            foreach ($item['option'] as &$option) {
                $option['is_selected'] = false;
                $option['status'] = 'default';
            }
        }

        return $items;
    }

    /**
     * 章节练习试题列表
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:27
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function chapterOptionList(array $params): array
    {
        $items = TenantExamQuestion::query()->where([
            ['tenant_exam_library_uid', '=', $params['uid']],
            ['chapter_uid', '=', $params['chapter_uid']],
            ['is_show', '=', 1]
        ])->field(['uid', 'uid', 'title', 'answer', 'option', 'analysis', 'exam_type', 'level'])
            ->append(['exam_type_name'])
            ->order('sort desc, id desc')
            ->select()
            ->toArray();
        foreach ($items as &$item) {
            $item['status'] = 'default';
            $item['is_selected'] = false;
            foreach ($item['option'] as &$option) {
                $option['is_selected'] = false;
                $option['status'] = 'default';
            }
        }

        return $items;
    }

    /**
     * 题型练习试题列表
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 23:27
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function typeOptionList(array $params): array
    {
        $items = TenantExamQuestion::query()->where([
            ['tenant_exam_library_uid', '=', $params['uid']],
            ['is_show', '=', 1]
        ])->where(function ($query) use ($params) {
            if (!empty($params['type'])) {
                $query->where('exam_type', '=', $params['type']);
            }
            if (!empty($params['level'])) {
                $query->where('level', '=', $params['level']);
            }
        })->field(['uid', 'title', 'answer', 'option', 'analysis', 'exam_type', 'level'])
            ->append(['exam_type_name'])
            ->order('sort desc, id desc')
            ->select()
            ->toArray();
        foreach ($items as &$item) {
            $item['status'] = 'default';
            $item['is_selected'] = false;
            foreach ($item['option'] as &$option) {
                $option['is_selected'] = false;
                $option['status'] = 'default';
            }
        }

        return $items;
    }

    /**
     * 题库类型列表
     * @param array $prams
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 02:13
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function questionTypeList(array $params): array
    {
        $examType = Db::name('dict_data')->where([
            ['type_value', '=', 'exam_level'],
            ['status', '=', 1]
        ])->order('sort desc')->column(['name', 'value']);
        $examLevel = Db::name('dict_data')->where([
            ['type_value', '=', 'level'],
            ['status', '=', 1]
        ])->order('sort desc')->column(['name', 'value']);
        foreach ($examType as &$value) {
            $value['exam_count'] = TenantExamQuestion::query()->where([
                ['tenant_exam_library_uid', '=', $params['uid']],
                ['is_show', '=', 1],
                ['exam_type', '=', $value['value']]
            ])->count();
        }
        foreach ($examLevel as &$value) {
            $value['exam_count'] = TenantExamQuestion::query()->where([
                ['tenant_exam_library_uid', '=', $params['uid']],
                ['is_show', '=', 1],
                ['level', '=', $value['value']]
            ])->count();
        }
        return [
            'exam_type_list'  => $examType,
            'exam_level_list' => $examLevel
        ];
    }

    /**
     * 试题章节
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/10 03:19
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function chapterList(array $params): array
    {
        $items = TenantExamChapter::query()->where([
            ['tenant_exam_library_uid', '=', $params['uid']],
            ['is_show', '=', 1]
        ])->append(['children_chapter'])
            ->field(['uid', 'title', 'parent_uid'])
            ->select()
            ->toArray();
        foreach ($items as $key => $value) {
            $count = 0;
            foreach ($value['children_chapter'] as $k => $v) {
                $childrenCount = Db::name('tenant_exam_question')->where([
                    ['chapter_uid', '=', $v['uid']],
                    ['tenant_exam_library_uid', '=', $params['uid']]
                ])->count('id');
                $count += $childrenCount;
                $items[$key]['children_chapter'][$k]['exam_count'] = $childrenCount;
            }
            $items[$key]['exam_count'] = $count;
            $items[$key]['expanded'] = false;
        }
        return $items;
    }

    /**
     * 题库试题收藏
     * @param array $params
     * @return bool
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function questionCollection(array $params): bool
    {
        $action = (int)$params['action'];
        $where = [
            ['library_uid', '=', $params['library_uid']],
            ['user_uid', '=', $params['user_uid']],
            ['question_uid', '=', $params['question_uid']]
        ];
        $row = 0;
        try {
            switch ($action) {
                case 2:
                    $row = TenantExamLibraryCollection::query()->where($where)->update(['delete_time' => time()]);
                    break;
                case 1:
                    $model = TenantExamLibraryCollection::create([
                        'library_uid'  => $params['library_uid'],
                        'user_uid'     => $params['user_uid'],
                        'question_uid' => $params['question_uid'],
                    ]);
                    if (!empty($model->getKey())) {
                        $row = $model->getKey();
                    }
            }
        } catch (\Exception $exception) {
            self::setError($exception->getMessage());
        }
        return $row > 0;
    }

    /**
     * 移除模拟考试错题
     * @param array $params
     * @return bool
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function questionRemoveError(array $params): bool
    {
        $row = 0;
        try {
            $model = TenantExamLibraryRemove::create([
                'library_uid'  => $params['library_uid'],
                'user_uid'     => $params['user_uid'],
                'question_uid' => $params['question_uid'],
            ]);
            if (!empty($model->getKey())) {
                $row = $model->getKey();
            }
        } catch (\Exception $exception) {
            self::setError($exception->getMessage());
        }
        return $row > 0;
    }

    /**
     * 试卷试题列表
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function examinationQuestionList(array $params): array
    {
        $paperUid = TenantExamExamination::query()->where([['uid', '=', $params['uid']], ['is_show', '=', 1]])->value('paper_uid');
        if (empty($paperUid)) return [];
        $questionList = TenantExamPaper::query()->where([
            ['uid', '=', $paperUid],
            ['is_show', '=', 1]
        ])->field(['option_content'])->findOrEmpty();
        if ($questionList->isEmpty()) return [];
        $option = json_decode($questionList->toArray()['option_content'], true);
        foreach ($option as &$value) {
            $value['status'] = 'default';
            $value['exam_type_name'] = $value['exam_type_text'];
            $value['is_selected'] = false;
            unset($value['analysis'], $value['exam_type_text']);
            foreach ($value['option'] as &$v) {
                $v['is_selected'] = false;
                $v['status'] = 'default';
                $v['is_check'] = false;
            }
        }
        return $option;
    }

    /**
     * 题库菜单
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/5/3 01:49
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function questionMenu(array $params): array
    {
        $menuList = [
            [
                'title'     => '顺序练习',
                'desc'      => '1/' . TenantExamQuestion::query()->where([['tenant_exam_library_uid', '=', $params['uid']], ['is_show', '=', 1]])->count(),
                'icon'      => 'edit-form',
                'iconColor' => '#4a90e2',
                'url'       => '/subpages/exam/questionOrder?uid=' . $params['uid']
            ],
            [
                'title'     => '随机练习',
                'desc'      => '自定义设置练习量',
                'icon'      => 'calendar',
                'iconColor' => '#f5a623',
                'url'       => '',
                'type'      => 1
            ],
            [
                'title'     => '模拟考试',
                'desc'      => '仿真模拟',
                'icon'      => 'platform',
                'iconColor' => '#e94e77',
                'url'       => '/subpages/exam/questionMnSetting?uid=' . $params['uid']
            ],
            [
                'title'     => '章节练习',
                'desc'      => '按章节定项练习',
                'icon'      => 'level',
                'iconColor' => '#7ed321',
                'url'       => '/subpages/exam/questionChapter?uid=' . $params['uid']
            ],
            [
                'title'     => '题型练习',
                'desc'      => '按题型分类练习',
                'icon'      => 'order',
                'iconColor' => '#bd10e0',
                'url'       => '/subpages/exam/questionType?uid=' . $params['uid']
            ],
            [
                'title'     => '试题搜索',
                'desc'      => '精准检索题库试题',
                'icon'      => 'search',
                'iconColor' => '#f5a623',
                'url'       => '/subpages/exam/questionSearch?uid=' . $params['uid']
            ],
            [
                'title'     => '模拟记录',
                'desc'      => '查看模拟记录',
                'icon'      => 'task',
                'iconColor' => '#E72F8C',
                'url'       => '/subpages/exam/questionMockHistory?uid=' . $params['uid'],
            ],
            [
                'title'     => '答题排行',
                'desc'      => '实时查看当前排名',
                'icon'      => 'vip',
                'iconColor' => '#31C9E8',
                'url'       => '/subpages/exam/questionRank'
            ]
        ];
        return $menuList;
    }
}