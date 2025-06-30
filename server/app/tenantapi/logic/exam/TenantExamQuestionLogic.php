<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\exam;


use app\common\logic\BaseLogic;
use app\common\model\exam\TenantExamLibrary;
use app\common\model\exam\TenantExamQuestion;
use think\facade\Cache;
use think\facade\Db;


/**
 * 试题管理逻辑
 * Class TenantExamQuestionLogic
 * @package app\platform\logic\exam
 */
class TenantExamQuestionLogic extends BaseLogic
{
    /**
     * @notes 添加试题管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public static function add(array $params): bool
    {
        try {
            $model = TenantExamQuestion::create([
                'uid'                     => uid(),
                'tenant_exam_library_uid' => $params['tenant_exam_library_uid'],
                'title'                   => $params['title'],
                'option'                  => json_encode($params['option'], JSON_UNESCAPED_UNICODE),
                'score'                   => $params['score'],
                'answer'                  => json_encode($params['answer'], JSON_UNESCAPED_UNICODE),
                'analysis'                => $params['analysis'],
                'exam_type'               => $params['exam_type'],
                'sort'                    => $params['sort'],
                'is_show'                 => $params['is_show'],
                'level'                   => $params['level'],
                'admin_id'                => $params['admin_id'],
                'tenant_id'               => $params['tenant_id'],
                'chapter_uid'             => $params['chapter_uid']
            ]);
            if (!empty($model->getKey())) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 编辑试题管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public static function edit(array $params): bool
    {
        Db::startTrans();
        try {
            TenantExamQuestion::where([
                ['id', '=', $params['id']],
                ['tenant_id', '=', $params['tenant_id']]
            ])->update([
                'tenant_exam_library_uid' => $params['tenant_exam_library_uid'],
                'title'                   => $params['title'],
                'option'                  => json_encode($params['option'], JSON_UNESCAPED_UNICODE),
                'score'                   => $params['score'],
                'answer'                  => json_encode($params['answer'], JSON_UNESCAPED_UNICODE),
                'analysis'                => $params['analysis'],
                'exam_type'               => $params['exam_type'],
                'sort'                    => $params['sort'],
                'is_show'                 => $params['is_show'],
                'level'                   => $params['level'],
                'admin_id'                => $params['admin_id'],
                'chapter_uid'             => $params['chapter_uid']
            ]);

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 删除试题管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public static function delete(array $params): bool
    {
        $buildModel = TenantExamQuestion::where([
            ["tenant_id", "=", $params["tenant_id"]]
        ]);
        if (is_array($params["id"])) {
            $buildModel->whereIn("id", $params["id"]);
        } else {
            $buildModel->where("id", $params["id"]);
        }
        return $buildModel->update(['delete_time' => time()]) > 0;
    }


    /**
     * @notes 获取试题管理详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2025/04/10 19:22
     */
    public static function detail($params): array
    {
        $question = TenantExamQuestion::findOrEmpty($params['id'])->toArray();
        foreach ($question["option"] as &$value) {
            if (in_array($question["exam_type"], [1, 2, 3]) && in_array($value["check"], $question["answer"])) {
                $value["is_check"] = true;
            } else {
                $value["is_check"] = false;
            }
        }
        return $question;
    }

    /**
     * @param array $params
     * @return bool
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @date 2025/4/13 04:08
     * @author 兔兔答题 <tutudati@outlook.com>
     */
    public static function textAdd(array $params): bool
    {
        $key = "text_input" . $params["tenant_id"] . $params["admin_id"];
        if (Cache::get($key)) {
            self::setError("请求处理中，请稍后再试。");
            return false;
        }
        Cache::set($key, 1, 20);
        try {
            $content = self::examContentHandle($params["content"]);
            $examType = array_column($content, "exam_type");
            if (count($examType) === 0) {
                self::setError("试题类型项存在错误，请确认。");
                return false;
            }
            $examType = array_unique($examType);
            if (in_array(0, $examType)) {
                self::setError("试题中存在不支持的类型，请确认。");
                return false;
            }
            $examList = [];
            Db::startTrans();
            foreach ($content as $item) {
                $examList[] = [
                    'uid'                     => uid(),
                    'tenant_exam_library_uid' => $params['tenant_exam_library_uid'],
                    'title'                   => "<p>" . $item["title"] . "</p>",
                    'option'                  => json_encode($item["option"], JSON_UNESCAPED_UNICODE),
                    'score'                   => 1,
                    'answer'                  => json_encode($item["answer"], JSON_UNESCAPED_UNICODE),
                    'exam_type'               => $item['exam_type'],
                    'analysis'                => "<p>" . $item['analysis'] . "</p>",
                    'sort'                    => 1,
                    'is_show'                 => 1,
                    'level'                   => 1,
                    'admin_id'                => $params['admin_id'],
                    'chapter_uid'             => $params['chapter_uid'],
                    'tenant_id'               => $params['tenant_id'],
                    'create_time'             => time(),
                    'update_time'             => time(),
                ];
            }
            $row = Db::name(TenantExamQuestion::query()->getName())->insertAll($examList);
            if ($row) {
                Db::commit();
                Cache::delete($key);
                return true;
            }
            Db::rollback();
            Cache::delete($key);
            return false;
        } catch (\Exception $exception) {
            self::setError($exception->getMessage());
            Cache::delete($key);
            return false;
        }
    }

    private static function examContentHandle(string $content): array
    {
        $blocks = preg_split('/\n\s*\n/', $content, -1, PREG_SPLIT_NO_EMPTY);
        $result = [];
        foreach ($blocks as $block) {
            $lines = explode("\n", trim($block));
            $data = [
                'title'     => '',
                'option'    => [],
                'answer'    => [],
                'analysis'  => '',
                'exam_type' => 0,
            ];
            foreach ($lines as $line) {
                $line = trim($line);
                if (strpos($line, '题目：') === 0) {
                    $data['title'] = trim(substr($line, 6), " ：");
                } elseif (preg_match('/^[A-D]\.\s*(.+)/', $line, $matches)) {
                    $check = $matches[0][0];
                    $data['option'][] = [
                        'check'    => $check,
                        'title'    => substr($line, 3),
                        'is_check' => 0
                    ];
                } elseif (strpos($line, '答案：') === 0) {
                    $answer = explode("、", trim(substr($line, 6), " ：",));
                    $data['answer'] = $answer;
                } elseif (strpos($line, '题型：') === 0) {
                    $type = trim(substr($line, 6), " ：");
                    $data['exam_type'] = match ($type) {
                        '单选题' => 1,
                        '多选题' => 2,
                        '判断题' => 3,
                        default => 0,
                    };
                } elseif (strpos($line, '解释：') === 0) {
                    $data['analysis'] = trim(substr($line, 6), " ：");
                }
            }

            // 标记正确选项
            foreach ($data["option"] as &$v) {
                if (in_array($v['check'], $data['answer'])) {
                    $v['is_check'] = true;
                } else {
                    $v['is_check'] = false;
                }
            }
            $result[] = $data;
        }
        return $result;
    }

    /**
     * 根据题库 id 查询试题
     * @param array $params
     * @return array
     */
    public static function questionListByLibrary(array $params): array
    {
        $id = $params['id'];
        $tenantId = $params['tenant_id'];
        $uid = TenantExamLibrary::query()->whereIn('id', $id)->column(['uid']);
        $questionItems = TenantExamQuestion::query()->whereIn('tenant_exam_library_uid', $uid)->where([
            ['tenant_id', '=', $tenantId],
            ['is_show', '=', 1]
        ])->field(['title', 'option', 'score', 'analysis', 'uid', 'exam_type'])->select()->toArray();
        $data = [
            [
                'total_score'  => 0,
                'total_number' => 0,
                'score'        => 0,
                'value'        => 1,
                'exam_type'    => '单选试题'
            ],
            [
                'total_score'  => 0,
                'total_number' => 0,
                'score'        => 0,
                'value'        => 2,
                'exam_type'    => '多选试题'
            ],
            [
                'total_score'  => 0,
                'total_number' => 0,
                'score'        => 0,
                'value'        => 3,
                'exam_type'    => '判断试题'
            ],
        ];
        $total = [
            'exam_count' => 0,
            'exam_score' => 0,
        ];
        foreach ($questionItems as $key => $value) {
            $total['exam_count'] += 1;
            $total['exam_score'] += $value['score'];
            switch ($value['exam_type']) {
                case 1:
                    $questionItems[$key]['exam_type_text'] = '单选题';
                    $data[0]['total_number'] += 1;
                    $data[0]['total_score'] += $value['score'];
                    $data[0]['score'] = 1.0;
                    break;
                case 2:
                    $questionItems[$key]['exam_type_text'] = '多选题';
                    $data[1]['total_number'] += 1;
                    $data[1]['total_score'] += $value['score'];
                    $data[1]['score'] = 1.0;
                    break;
                case 3:
                    $questionItems[$key]['exam_type_text'] = '判断题';
                    $data[2]['total_number'] += 1;
                    $data[2]['total_score'] += $value['score'];
                    $data[2]['score'] = 1.0;
                    break;
            }
        }
        return [
            'total'     => $total,
            'data'      => $data,
            'exam_list' => $questionItems
        ];
    }
}