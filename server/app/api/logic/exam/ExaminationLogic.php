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
use app\common\model\exam\TenantExamExamination;
use app\common\model\exam\TenantExamExaminationHistory;
use app\common\model\exam\TenantExamPaper;
use app\common\model\exam\TenantExamQuestion;
use app\common\model\exam\TenantMockExamExamination;

class ExaminationLogic extends BaseLogic
{
    /**
     * 保存模拟考试配置信息，并返回试题数据
     * @param array $params
     * @return string
     */
    public static function mockExaminationConfig(array $params): string
    {
        try {
            $uid = uid();
            $paperScore = 0;
            foreach (json_decode($params['option_type_config'], true) as $value) {
                $paperScore += $value['score'] * $value['count'];
            }
            $model = TenantMockExamExamination::create([
                'tenant_id'          => $params['tenant_id'],
                'uid'                => $uid,
                'user_uid'           => $params['user_uid'],
                'score'              => $params['score'],
                'paper_score'        => $paperScore,
                'option_type_config' => $params['option_type_config'],
                'exam_time'          => minutesToHMS((int)$params['exam_time']),
                'checkbox_type'      => $params['checkbox_type'],
                'option_type'        => $params['option_type'],
                'question_uid'       => $params['question_uid'],
            ]);
            if (!empty($model->getKey())) return $uid;

            return '';
        } catch (\Exception $exception) {
            self::setError($exception->getMessage());
            return "";
        }
    }

    /**
     * 模拟考试试题查询
     * @param array $params
     * @return array
     */
    public static function mockExamList(array $params): array
    {
        $configModel = TenantMockExamExamination::query()->where([
            ['uid', '=', $params['uid']],
            ['user_uid', '=', $params['user_uid']],
        ])->field(['option_type_config', 'exam_time', 'option_type', 'question_uid'])->findOrEmpty();
        if ($configModel->isEmpty()) return [];
        $optionTypeConfig = json_decode($configModel['option_type_config'], true);
        // 单选试题配置
        $optionConfig = ['count' => 0, 'score' => 1];
        // 多选试题配置
        $checkboxConfig = ['count' => 0, 'score' => 1];
        // 判断试题配置
        $judeConfig = ['count' => 0, 'score' => 1];
        foreach ($optionTypeConfig as $value) {
            if ((int)$value['value'] === 1) {
                $optionConfig['count'] = $value['count'];
                $optionConfig['score'] = $value['score'];
            } else if ((int)$value['value'] === 2) {
                $checkboxConfig['count'] = $value['count'];
                $checkboxConfig['score'] = $value['score'];
            } else if ((int)$value['value'] === 3) {
                $judeConfig['count'] = $value['count'];
                $judeConfig['score'] = $value['score'];
            }
        }
        $optionItems = [];
        if ($optionConfig['count'] > 0) {
            $optionItems = TenantExamQuestion::query()->where([
                ['tenant_exam_library_uid', '=', $configModel['question_uid']],
                ['is_show', '=', 1],
                ['exam_type', '=', 1]
            ])->field(['uid', 'uid', 'title', 'answer', 'option', 'exam_type', 'level'])
                ->append(['exam_type_name'])
                ->limit(0, (int)$optionConfig['count'])
                ->orderRaw('RAND()')
                ->order('sort desc, id desc')
                ->select()
                ->toArray();
            foreach ($optionItems as &$item) {
                $item['status'] = 'default';
                $item['score'] = $optionConfig['score'];
                $item['is_selected'] = false;
                foreach ($item['option'] as &$option) {
                    $option['is_selected'] = false;
                    $option['status'] = 'default';
                }
            }
        }
        $checkboxItems = [];
        if ($checkboxConfig['count'] > 0) {
            $checkboxItems = TenantExamQuestion::query()->where([
                ['tenant_exam_library_uid', '=', $configModel['question_uid']],
                ['is_show', '=', 1],
                ['exam_type', '=', 2]
            ])->field(['uid', 'uid', 'title', 'answer', 'option', 'exam_type', 'level'])
                ->append(['exam_type_name'])
                ->orderRaw('RAND()')
                ->limit(0, (int)$checkboxConfig['count'])
                ->order('sort desc, id desc')
                ->select()
                ->toArray();
            foreach ($checkboxItems as &$item) {
                $item['status'] = 'default';
                $item['score'] = $checkboxConfig['score'];
                $item['is_selected'] = false;
                foreach ($item['option'] as &$option) {
                    $option['is_selected'] = false;
                    $option['status'] = 'default';
                }
            }
        }
        $judeItems = [];
        if ($judeConfig['count'] > 0) {
            $judeItems = TenantExamQuestion::query()->where([
                ['tenant_exam_library_uid', '=', $configModel['question_uid']],
                ['is_show', '=', 1],
                ['exam_type', '=', 3]
            ])->field(['uid', 'uid', 'title', 'answer', 'option', 'exam_type', 'level'])
                ->append(['exam_type_name'])
                ->orderRaw('RAND()')
                ->limit(0, (int)$judeConfig['count'])
                ->order('sort desc, id desc')
                ->select()
                ->toArray();
            foreach ($judeItems as &$item) {
                $item['status'] = 'default';
                $item['score'] = $judeConfig['score'];
                $item['is_selected'] = false;
                foreach ($item['option'] as &$option) {
                    $option['is_selected'] = false;
                    $option['status'] = 'default';
                }
            }
        }
        $fullItems = array_merge($optionItems, $checkboxItems, $judeItems);
        if ((int)$configModel['option_type'] === 1) {
            shuffle($fullItems);
        }
        return [
            'exam_list' => $fullItems,
            'config'    => ['exam_time' => $configModel['exam_time'], 'question_uid' => $configModel['question_uid']],
        ];
    }

    /**
     * 保存模拟考试
     * @param array $params
     * @return array
     */
    public static function saveMockExamination(array $params): array
    {
        try {
            $mockConfig = TenantMockExamExamination::query()->where([
                ['uid', '=', $params['history_uid']]
            ])->field(['uid', 'question_uid', 'option_type_config', 'id'])->findOrEmpty();
            if (empty($mockConfig)) {
                self::setError('配置不存在');
                return [];
            }
            // 处理试题分数规则
            $optionTypeConfig = json_decode($mockConfig['option_type_config'], true);
            // 单选试题配置
            $optionConfig = ['count' => 0, 'score' => 1];
            // 多选试题配置
            $checkboxConfig = ['count' => 0, 'score' => 1];
            // 判断试题配置
            $judeConfig = ['count' => 0, 'score' => 1];
            foreach ($optionTypeConfig as $value) {
                if ((int)$value['value'] === 1) {
                    $optionConfig['count'] = $value['count'];
                    $optionConfig['score'] = $value['score'];
                } else if ((int)$value['value'] === 2) {
                    $checkboxConfig['count'] = $value['count'];
                    $checkboxConfig['score'] = $value['score'];
                } else if ($value['value'] === 3) {
                    $judeConfig['count'] = $value['count'];
                    $judeConfig['score'] = $value['score'];
                }
            }
            // 处理试题
            $option = json_decode($params['option'], true);
            $optionUid = array_column($option, 'uid');
            $questionList = TenantExamQuestion::query()->where([
                ['tenant_exam_library_uid', '=', $mockConfig['question_uid']]
            ])->whereIn('uid', $optionUid)->field(['answer', 'exam_type', 'uid'])->select()->toArray();
            // 统计答题结果统计
            $errorOption = $correctOption = [];
            $correctCount = $errorCount = 0;
            $userScore = 0;
            foreach ($questionList as $key => $value) {
                foreach ($option as $k => $v) {
                    if ($v['uid'] === $value['uid']) {
                        if ($value['exam_type'] == 1 || $value['exam_type'] == 3) {
                            sort($value['answer']);
                            sort($v['user_answer']);
                            $examAnswer = implode(',', $value['answer']);
                            $userAnswer = implode(',', $v['user_answer']);
                            if ($userAnswer == $examAnswer) {
                                $correctOption[] = $value['uid'];
                                $correctCount++;
                                if ($value['exam_type'] == 1) {
                                    $userScore += $optionConfig['score'];
                                } else if ($value['exam_type'] == 2) {
                                    $userScore += $judeConfig['score'];
                                }
                            } else {
                                $errorCount++;
                                $errorOption[] = $value['uid'];
                            }
                        } else if ($value['exam_type'] == 2) {
                            sort($value['answer']);
                            sort($v['user_answer']);
                            $examAnswer = implode(',', $value['answer']);
                            $userAnswer = implode(',', $v['user_answer']);
                            if ($userAnswer == $examAnswer) {
                                $correctOption[] = $value['uid'];
                                $correctCount++;
                                if ($value['exam_type'] == 1) {
                                    $userScore += $optionConfig['score'];
                                } else if ($value['exam_type'] == 2) {
                                    $userScore += $checkboxConfig['score'];
                                }
                            } else {
                                $errorCount++;
                                $errorOption[] = $value['uid'];
                            }
                        }
                    }
                }
            }
            $updateRow = TenantMockExamExamination::query()->where('id', '=', $mockConfig['id'])->update([
                'user_score'       => $userScore,
                'submit_option'    => json_encode($option, JSON_UNESCAPED_UNICODE),
                'error_option'     => json_encode($errorOption, JSON_UNESCAPED_UNICODE),
                'correct_option'   => json_encode($correctOption, JSON_UNESCAPED_UNICODE),
                'correct_count'    => $correctCount,
                'error_count'      => $errorCount,
                'exam_submit_time' => secondsToHMS((int)$params['time'])
            ]);
            return [
                'correct_count' => $correctCount,
                'error_count'   => $errorCount,
                'user_score'    => $userScore,
                'msg'           => '答对' . $correctCount . '题，答错' . $errorCount . '题，' . '最后得分' . number_format($userScore, 2),
            ];
        } catch (\Exception $exception) {
            self::setError($exception->getMessage() . $exception->getLine());
            return [];
        }
    }

    /**
     * 模拟考试历史记录
     * @param array $params
     * @return array
     */
    public static function mockExaminationList(array $params): array
    {
        $pageNo = (int)(isset($params['page_no']) ? $params['page_no'] : 1);
        $pageSize = (int)(isset($params['page_size']) ? $params['page_size'] : 20);
        $pageSize = min($pageSize, 20);
        $items = TenantMockExamExamination::query()->where([
            ['user_uid', '=', $params['user_uid']],
            ['tenant_id', '=', $params['tenant_id']],
            ['question_uid', '=', $params['uid']]
        ])->with(['question' => function ($query) {
            $query->field(['title', 'image', 'uid']);
        }])->field(['question_uid', 'correct_count', 'error_count', 'user_score', 'paper_score', 'score', 'exam_submit_time'])
            ->paginate([
                'list_rows' => $pageSize,
                'page'      => $pageNo
            ]);
        return [
            'lists'     => $items->items(),
            'page_no'   => $items->currentPage(),
            'page_size' => $pageSize,
            'count'     => $items->total(),
            'extend'    => []
        ];
    }

    /**
     * 考试列表
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function examinationList(array $params): array
    {
        $pageNo = (int)(isset($params['page_no']) ? $params['page_no'] : 1);
        $pageSize = (int)(isset($params['page_size']) ? $params['page_size'] : 20);
        $pageSize = min($pageSize, 20);
        $items = TenantExamExamination::query()->where(function ($query) use ($params) {
            $query->where('is_show', '=', 1);
            if (!empty($params['title'])) {
                $query->whereLike('title', '%' . $params['title'] . '%');
            }
        })->append(['status'])
            ->with(['paper' => function ($query) {
                $query->field(['uid', 'option_count', 'option_score']);
            }])
            ->field(['start_time', 'end_time', 'exam_time', 'title', 'score', 'exam_time', 'image', 'uid'])
            ->paginate([
                'list_rows' => $pageSize,
                'page'      => $pageNo
            ]);
        return [
            'lists'     => $items->items(),
            'page_no'   => $items->currentPage(),
            'page_size' => $pageSize,
            'count'     => $items->total(),
            'extend'    => []
        ];
    }

    /**
     * 考试详情
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function examinationContent(array $params): array
    {
        $examination = TenantExamExamination::query()->where([
            ['uid', '=', $params['uid']],
            ['is_show', '=', 1]
        ])->field(['start_time', 'end_time', 'exam_time', 'title', 'score', 'exam_time', 'image', 'content', 'uid', 'paper_uid'])
            ->with(['paper' => function ($query) {
                $query->field(['uid', 'option_count', 'option_score']);
            }])
            ->append(['status'])
            ->findOrEmpty();
        if ($examination->isEmpty()) return [];
        $examination->hidden(['paper_uid']);
        return $examination->toArray();
    }

    /**
     * 考试历史
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function examinationHistory(array $params): array
    {
        $pageNo = (int)(isset($params['page_no']) ? $params['page_no'] : 1);
        $pageSize = (int)(isset($params['page_size']) ? $params['page_size'] : 20);
        $pageSize = min($pageSize, 20);
        $items = TenantExamExaminationHistory::query()->where([
            ['user_uid', '=', $params['user_uid']],
            ['tenant_id', '=', $params['tenant_id']],
        ])->with(['examination' => function ($query) {
            $query->field(['uid', 'title', 'image']);
        }])->field(['examination_uid', 'paper_score', 'user_score', 'basic_score', 'paper_score', 'paper_uid', 'submit_time', 'paper_time', 'error_count', 'correct_count'])
            ->paginate([
                'list_rows' => $pageSize,
                'page'      => $pageNo
            ]);
        return [
            'lists'     => $items->items(),
            'page_no'   => $items->currentPage(),
            'page_size' => $pageSize,
            'count'     => $items->total(),
            'extend'    => []
        ];
    }

    /**
     * 考试提交
     * @param array $params
     * @return array
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public static function submitExamination(array $params): array
    {
        $optionItems = $params['option'];
        $uid = uid();
        $examinationHistory = [
            'uid'                => $uid,
            'user_score'         => 0,
            'tenant_id'          => $params['tenant_id'],
            'paper_uid'          => '',
            'examination_uid'    => $params['uid'],
            'user_uid'           => $params['user_uid'],
            'paper_score'        => 0,
            'submit_time'        => $params['submit_time'],
            'paper_time'         => '',
            'options'            => json_encode($optionItems, JSON_UNESCAPED_UNICODE),
            'error_count'        => 0,
            'correct_count'      => 0,
            'error_option_uid'   => json_encode([], JSON_UNESCAPED_UNICODE),
            'correct_option_uid' => json_encode([], JSON_UNESCAPED_UNICODE),
            'basic_score'        => 0,
            'start_time'         => '',
            'end_time'           => 0,
            'is_rand'            => 0,
        ];
        try {
            $optionUidArray = array_column($optionItems, 'uid');
            $questionItems = TenantExamQuestion::query()->whereIn('uid', $optionUidArray)->field(['answer', 'uid'])->select()->toArray();
            $examinationConfig = TenantExamExamination::query()->where('uid', '=', $params['uid'])->field(["*"])->findOrEmpty();
            $paperConfig = TenantExamPaper::query()->where('uid', '=', $examinationConfig['paper_uid'])->field(['*'])->findOrEmpty();
            $examinationHistory['start_time'] = $examinationConfig['start_time'];
            $examinationHistory['end_time'] = $examinationConfig['end_time'];
            $examinationHistory['is_rand'] = $paperConfig['is_rand'];
            $examinationHistory['basic_score'] = $examinationConfig['score'];
            $examinationHistory['paper_time'] = $examinationConfig['exam_time'];
            $examinationHistory['paper_score'] = $paperConfig['option_score'];
            $examinationHistory['paper_uid'] = $examinationConfig['paper_uid'];

            $questionAnswerConfig = [];
            foreach ($questionItems as $value) {
                sort($value['answer']);
                $questionAnswerConfig[$value['uid']] = implode(',', $value['answer']);
            }

            $errorOptionUid = [];
            $correctOptionUid = [];
            // 处理试题分数规则
            $optionTypeConfig = json_decode($paperConfig['option_config'], true);
            // 单选试题配置
            $optionConfig = ['score' => 1];
            // 多选试题配置
            $checkboxConfig = ['score' => 1];
            // 判断试题配置
            $judeConfig = ['score' => 1];
            foreach ($optionTypeConfig as $value) {
                if ((int)$value['value'] === 1) {
                    $optionConfig['score'] = $value['score'];
                } else if ((int)$value['value'] === 2) {
                    $checkboxConfig['score'] = $value['score'];
                } else if ($value['value'] === 3) {
                    $judeConfig['score'] = $value['score'];
                }
            }

            foreach ($optionItems as $value) {
                $userSelectedAnswer = [];
                foreach ($value['option'] as $v) {
                    if ($v['is_selected']) {
                        $userSelectedAnswer[] = $v['check'];
                    }
                }
                sort($userSelectedAnswer);
                $userSelectedAnswer = implode(',', $userSelectedAnswer);
                if (isset($questionAnswerConfig[$value['uid']])) {
                    if ($userSelectedAnswer == $questionAnswerConfig[$value['uid']]) {// 正确
                        $examinationHistory['correct_count'] += 1;
                        $correctOptionUid[] = $value['uid'];
                        if ($value['exam_type'] == 1) {
                            $examinationHistory['user_score'] += $optionConfig['score'];
                        } else if ($value['exam_type'] == 2) {
                            $examinationHistory['user_score'] += $checkboxConfig['score'];
                        } else if ($value['exam_type'] == 3) {
                            $examinationHistory['user_score'] += $judeConfig['score'];
                        }
                    } else {// 错误
                        $examinationHistory['error_count'] += 1;
                        $errorOptionUid[] = $value['uid'];
                    }
                }
            }
            $examinationHistory['error_option_uid'] = json_encode($errorOptionUid, JSON_UNESCAPED_UNICODE);
            $examinationHistory['correct_option_uid'] = json_encode($correctOptionUid, JSON_UNESCAPED_UNICODE);

            $historyModel = TenantExamExaminationHistory::create($examinationHistory);
            if (!empty($historyModel->getKey())) {
                return [
                    'history_uid'   => $uid,
                    'user_score'    => $examinationHistory['user_score'],
                    'error_count'   => count($errorOptionUid),
                    'correct_count' => count($correctOptionUid),
                    'paper_score'   => $examinationHistory['paper_score'],
                    'alter_msg'     => '答对题数' . count($correctOptionUid) . '，答错题数' . count($errorOptionUid) . '，最终得分' . $examinationHistory['user_score'],
                ];
            }
        } catch (\Exception $exception) {
            self::setError($exception->getMessage() . $exception->getLine() . $exception->getFile());
        }
        return [];
    }
}