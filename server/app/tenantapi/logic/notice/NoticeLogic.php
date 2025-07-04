<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\logic\notice;

use app\common\enum\notice\NoticeEnum;
use app\common\logic\BaseLogic;
use app\common\model\notice\TenantNoticeSetting;

/**
 * 通知逻辑层
 * Class NoticeLogic
 * @package app\tenantapi\logic\notice
 */
class NoticeLogic extends BaseLogic
{
    /**
     * @notes 初始化通知场景配置
     * @param mixed $tenant_id
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author JXDN
     * @date 2024/10/22 11:51
     */
    public static function initialization(mixed $tenant_id): void
    {
        // 支付方式配置
        $field = "tenant_id,scene_id,scene_name,scene_desc,recipient,type,system_notice,sms_notice,oa_notice,mnp_notice,support";
        // 查询支付方式配置 此处默认为租户号为0的模板数据
        $NoticeSettingRecord = TenantNoticeSetting::where(['tenant_id' => 0])->field($field)->select()->toArray();
        foreach ($NoticeSettingRecord as $item) {
            $item['tenant_id']     = $tenant_id;
            $item['system_notice'] = json_encode($item['system_notice'], JSON_UNESCAPED_UNICODE);
            $item['sms_notice']    = json_encode($item['sms_notice'], JSON_UNESCAPED_UNICODE);
            $item['oa_notice']     = json_encode($item['oa_notice'], JSON_UNESCAPED_UNICODE);
            $item['mnp_notice']    = json_encode($item['mnp_notice'], JSON_UNESCAPED_UNICODE);
            TenantNoticeSetting::create($item);
        }
    }

    /**
     * @notes 查看通知设置详情
     * @param $params
     * @return array
     * @author 兔兔答题
     * @date 2022/3/29 11:34
     */
    public static function detail($params)
    {
        $field         = 'id,type,scene_id,scene_name,scene_desc,system_notice,sms_notice,oa_notice,mnp_notice,support';
        $noticeSetting = TenantNoticeSetting::field($field)->findOrEmpty($params['id'])->toArray();
        if (empty($noticeSetting)) {
            return [];
        }
        if (empty($noticeSetting['system_notice'])) {
            $noticeSetting['system_notice'] = [
                'title'   => '',
                'content' => '',
                'status'  => 0,
            ];
        }
        $noticeSetting['system_notice']['tips'] = NoticeEnum::getOperationTips(NoticeEnum::SYSTEM, $noticeSetting['scene_id']);
        if (empty($noticeSetting['sms_notice'])) {
            $noticeSetting['sms_notice'] = [
                'template_id' => '',
                'content'     => '',
                'status'      => 0,
            ];
        }
        $noticeSetting['sms_notice']['tips'] = NoticeEnum::getOperationTips(NoticeEnum::SMS, $noticeSetting['scene_id']);
        if (empty($noticeSetting['oa_notice'])) {
            $noticeSetting['oa_notice'] = [
                'template_id' => '',
                'template_sn' => '',
                'name'        => '',
                'first'       => '',
                'remark'      => '',
                'tpl'         => [],
                'status'      => 0,
            ];
        }
        $noticeSetting['oa_notice']['tips'] = NoticeEnum::getOperationTips(NoticeEnum::MNP, $noticeSetting['scene_id']);
        if (empty($noticeSetting['mnp_notice'])) {
            $noticeSetting['mnp_notice'] = [
                'template_id' => '',
                'template_sn' => '',
                'name'        => '',
                'tpl'         => [],
                'status'      => 0,
            ];
        }
        $noticeSetting['mnp_notice']['tips']       = NoticeEnum::getOperationTips(NoticeEnum::MNP, $noticeSetting['scene_id']);
        $noticeSetting['system_notice']['is_show'] = in_array(NoticeEnum::SYSTEM, explode(',', $noticeSetting['support']));
        $noticeSetting['sms_notice']['is_show']    = in_array(NoticeEnum::SMS, explode(',', $noticeSetting['support']));
        $noticeSetting['oa_notice']['is_show']     = in_array(NoticeEnum::OA, explode(',', $noticeSetting['support']));
        $noticeSetting['mnp_notice']['is_show']    = in_array(NoticeEnum::MNP, explode(',', $noticeSetting['support']));
        $noticeSetting['default']                  = '';
        $noticeSetting['type']                     = NoticeEnum::getTypeDesc($noticeSetting['type']);
        return $noticeSetting;
    }


    /**
     * @notes 通知设置
     * @param $params
     * @return bool
     * @author 兔兔答题
     * @date 2022/3/29 11:34
     */
    public static function set($params)
    {
        try {
            // 校验参数
            self::checkSet($params);
            // 拼装更新数据
            $updateData = [];
            foreach ($params['template'] as $item) {
                $updateData[$item['type'] . '_notice'] = json_encode($item, JSON_UNESCAPED_UNICODE);
            }
            // 更新通知设置
            TenantNoticeSetting::where('id', $params['id'])->update($updateData);
            return true;
        } catch (\Exception $e) {
            self::setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 校验参数
     * @param $params
     * @throws \Exception
     * @author 兔兔答题
     * @date 2022/3/29 11:35
     */
    public static function checkSet($params)
    {
        $noticeSetting = TenantNoticeSetting::findOrEmpty($params['id'] ?? 0);

        if ($noticeSetting->isEmpty()) {
            throw new \Exception('通知配置不存在');
        }

        if (!isset($params['template']) || !is_array($params['template']) || count($params['template']) == 0) {
            throw new \Exception('模板配置不存在或格式错误');
        }

        // 通知类型
        $noticeType = ['system', 'sms', 'oa', 'mnp'];

        foreach ($params['template'] as $item) {
            if (!is_array($item)) {
                throw new \Exception('模板项格式错误');
            }

            if (!isset($item['type']) || !in_array($item['type'], $noticeType)) {
                throw new \Exception('模板项缺少模板类型或模板类型有误');
            }

            switch ($item['type']) {
                case "system";
                    self::checkSystem($item);
                    break;
                case "sms";
                    self::checkSms($item);
                    break;
                case "oa";
                    self::checkOa($item);
                    break;
                case "mnp";
                    self::checkMnp($item);
                    break;
            }
        }
    }


    /**
     * @notes 校验系统通知参数
     * @param $item
     * @throws \Exception
     * @author 兔兔答题
     * @date 2022/3/29 11:35
     */
    public static function checkSystem($item)
    {
        if (!isset($item['title']) || !isset($item['content']) || !isset($item['status'])) {
            throw new \Exception('系统通知必填参数：title、content、status');
        }
    }


    /**
     * @notes 校验短信通知必填参数
     * @param $item
     * @throws \Exception
     * @author 兔兔答题
     * @date 2022/3/29 11:35
     */
    public static function checkSms($item)
    {
        if (!isset($item['template_id']) || !isset($item['content']) || !isset($item['status'])) {
            throw new \Exception('短信通知必填参数：template_id、content、status');
        }
    }


    /**
     * @notes 校验微信模板消息参数
     * @param $item
     * @throws \Exception
     * @author 兔兔答题
     * @date 2022/3/29 11:35
     */
    public static function checkOa($item)
    {
        if (!isset($item['template_id']) || !isset($item['template_sn']) || !isset($item['name']) || !isset($item['first']) || !isset($item['remark']) || !isset($item['tpl']) || !isset($item['status'])) {
            throw new \Exception('微信模板消息必填参数：template_id、template_sn、name、first、remark、tpl、status');
        }
    }


    /**
     * @notes 校验微信小程序提醒必填参数
     * @param $item
     * @throws \Exception
     * @author 兔兔答题
     * @date 2022/3/29 11:35
     */
    public static function checkMnp($item)
    {
        if (!isset($item['template_id']) || !isset($item['template_sn']) || !isset($item['name']) || !isset($item['tpl']) || !isset($item['status'])) {
            throw new \Exception('微信模板消息必填参数：template_id、template_sn、name、tpl、status');
        }
    }
}