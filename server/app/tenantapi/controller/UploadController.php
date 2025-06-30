<?php
// +----------------------------------------------------------------------
// | 兔兔答题考试系统
// +----------------------------------------------------------------------
// | 感谢使用兔兔答题系统
// | 本系统经过商业授权，不能转售、开源等其他不符合兔兔答题系统版权协议外的商业行为，违者必追究其侵犯版权行为。
// | 访问官网：https://www.tutudati.com
// | 官方邮箱：tutudati@outlook.com
// | 兔兔答题系统开发者版权所有，拥有最终解释权。

namespace app\tenantapi\controller;


use app\common\service\UploadService;
use Exception;
use think\response\Json;

/**
 * 上传文件
 * Class UploadController
 * @package app\tenantapi\controller
 */
class UploadController extends BaseAdminController
{
    /**
     * @notes 上传图片
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 16:27
     */
    public function image(): Json
    {
        try {
            $cid = $this->request->post('cid', 0);
            $result = UploadService::image($cid);
            return $this->success('上传成功', $result);
        } catch (Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    /**
     * @notes 上传视频
     * @return Json
     * @author 兔兔答题
     * @date 2021/12/29 16:27
     */
    public function video()
    {
        try {
            $cid = $this->request->post('cid', 0);
            $result = UploadService::video($cid);
            return $this->success('上传成功', $result);
        } catch (Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    /**
     * @notes 上传文件
     * @return Json
     * @author dw
     * @date 2023/06/26
     */
    public function file()
    {
        try {
            $cid = $this->request->post('cid', 0);
            $result = UploadService::file($cid);
            return $this->success('上传成功', $result);
        } catch (Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

}
