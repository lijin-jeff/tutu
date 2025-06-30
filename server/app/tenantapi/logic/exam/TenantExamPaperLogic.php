<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。
declare (strict_types=1);

namespace app\tenantapi\logic\exam;


use app\common\model\exam\TenantExamPaper;
use app\common\logic\BaseLogic;
use think\facade\Db;


/**
 * 试卷管理逻辑
 * Class TenantExamPaperLogic
 * @package app\platform\logic\exam
 */
class TenantExamPaperLogic extends BaseLogic
{


    /**
     * @notes 添加试卷管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/06/10 13:57
     */
    public static function add(array $params): bool
    {
        Db::startTrans();
        try {
            TenantExamPaper::create([
                'uid'     => uid(),
                'title'   => $params['title'],
                'is_show' => $params['is_show'],
                'sort'    => $params['sort'],
                'is_rand' => $params['is_rand'],
                'image'   => $params['image'],
                'remark'  => $params['remark']
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
     * @notes 编辑试卷管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/06/10 13:57
     */
    public static function edit(array $params): bool
    {
        Db::startTrans();
        try {
            TenantExamPaper::where('id', $params['id'])->update([
                'title'   => $params['title'],
                'is_show' => $params['is_show'],
                'sort'    => $params['sort'],
                'is_rand' => $params['is_rand'],
                'image'   => $params['image'],
                'remark'  => $params['remark']
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
     * @notes 删除试卷管理
     * @param array $params
     * @return bool
     * @author 兔兔答题
     * @date 2025/06/10 13:57
     */
    public static function delete(array $params): bool
    {
        return TenantExamPaper::destroy($params['id']);
    }

    /**
     * 试卷试题详情
     * @param array $prams
     * @return array
     */
    public static function paperDetail(array $params): array
    {
        $paperDetail = TenantExamPaper::query()->where([
            ['id', '=', $params['id']],
            ['tenant_id', '=', $params['tenant_id']]
        ])->field(['option_count', 'option_score', 'option_config', 'option_content'])->findOrEmpty();
        if ($paperDetail->isEmpty() || empty($paperDetail['option_config'])) {
            return [];
        }
        return [
            'total'     => [
                'exam_count' => $paperDetail['option_count'],
                'exam_score' => $paperDetail['option_score'],
            ],
            'data'      => json_decode($paperDetail['option_config'], true),
            'exam_list' => json_decode($paperDetail['option_content'], true)
        ];
    }

    /**
     * @notes 获取试卷管理详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2025/06/10 13:57
     */
    public static function detail($params): array
    {
        return TenantExamPaper::findOrEmpty($params['id'])->toArray();
    }

    /**
     * 保存试卷组卷数据
     * @return bool
     */
    public static function savePaper(array $params): bool
    {
        try {
            return TenantExamPaper::query()->where([
                    ['id', '=', $params['id']],
                    ['tenant_id', '=', $params['tenant_id']]
                ])->update([
                    'option_count'   => $params['total']['exam_count'],
                    'option_score'   => $params['total']['exam_score'],
                    'option_config'  => json_encode($params['data'], JSON_UNESCAPED_UNICODE),
                    'option_content' => json_encode($params['exam_list'], JSON_UNESCAPED_UNICODE),
                ]) > 0;
        } catch (\Exception $exception) {
            self::setError($exception->getMessage());
            return false;
        }
    }
}