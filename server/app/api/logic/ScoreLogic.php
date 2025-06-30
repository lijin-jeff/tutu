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
namespace app\api\logic;

use app\common\enum\ScoreEnum;
use app\common\logic\BaseLogic;
use app\common\model\user\User;
use app\common\model\user\UserScoreLog;
use think\facade\Db;

class ScoreLogic extends BaseLogic
{
    /**
     * 增加用户积分
     * @param int $tenantId 租户 id
     * @param int $userId 用户 id
     * @param float $score 用户积分
     * @param int $scoreType 积分类型
     * @param string $remark 积分备注
     * @param array $extra 积分扩展
     * @return bool
     */
    public static function addScore(int $tenantId, int $userId, float $score, int $scoreType, string $remark = '', array $extra = []): bool
    {
        Db::startTrans();
        try {
            $userScoreModel = UserScoreLog::create([
                'tenant_id'     => $tenantId,
                'user_id'       => $userId,
                'action'        => 1,
                'change_amount' => $score,
                'change_type'   => $scoreType,
                'title'         => ScoreEnum::ScoreTitle($scoreType),
                'remark'        => $remark,
                'extra'         => json_encode($extra, JSON_UNESCAPED_UNICODE),
            ]);
            $user = User::where('id', $userId)->lock(true)->findOrFail();
            $user->score = $user->score + $score;
            if (!empty($userScoreModel->getKey()) && $user->save()) {
                Db::commit();
                return true;
            }
            Db::rollback();
        } catch (\Exception $exception) {
            Db::rollback();
        }
        return false;
    }

    /**
     * 积分明细
     * @param array $params
     * @return array
     */
    public static function scoreList(array $params): array
    {
        $actionType = (int)(!empty($params['action']) ? $params['action'] : 0);
        $userScore = UserScoreLog::query()->where([['user_id', '=', $params['user_id']]])
            ->where(function ($query) use ($actionType) {
                if ($actionType > 0) $query->where('action', '=', $actionType);
            })
            ->field(['title', 'action_type', 'action', 'change_amount', 'change_type', 'remark', 'create_time'])
            ->limit(($params['page_no'] - 1) * $params['page_size'], (int)$params['page_size'])->paginate((int)$params['page_size']);

        return [
            'lists'     => $userScore->items(),
            'page_no'   => $userScore->currentPage(),
            'page_size' => $params['page_size'],
            'count'     => $userScore->total(),
            'extend'    => [
                'user_score' => self::userScore((int)$params['user_id'])]
        ];
    }

    /**
     * 查询用户总结积分
     * @param int $userId
     * @return string
     */
    public static function userScore(int $userId): string
    {
        $userScore = User::query()->where('id', '=', $userId)->value('score');
        return number_format((float)$userScore, 2);
    }
}