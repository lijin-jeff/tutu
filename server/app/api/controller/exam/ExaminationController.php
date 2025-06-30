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
namespace app\api\controller\exam;

use app\api\controller\BaseApiController;
use app\api\logic\exam\ExaminationLogic;
use app\api\validate\CommonValidate;
use app\api\validate\exam\ExaminationValidate;
use app\api\validate\exam\QuestionValidate;

class ExaminationController extends BaseApiController
{
    /**
     * 提交模拟考试配置
     * @return \think\response\Json
     */
    public function mockExaminationConfig(): \think\response\Json
    {
        (new ExaminationValidate())->post()->goCheck('mock');
        $configResult = ExaminationLogic::mockExaminationConfig($this->requestParams);
        if (!empty($configResult)) {
            return $this->success('提交成功', ['history_uid' => $configResult]);
        }
        return $this->fail(ExaminationLogic::getError());
    }

    /**
     * 模拟考试试题查询
     * @return \think\response\Json
     */
    public function mockQuestionList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        return $this->success('试题获取成功', ExaminationLogic::mockExamList($this->requestParams));
    }

    /**
     * 保存模拟考试数据
     * @return \think\response\Json
     */
    public function saveMockExamination(): \think\response\Json
    {
        $result = ExaminationLogic::saveMockExamination($this->requestParams);
        if (count($result)) {
            return $this->success('计算成功', $result);
        }
        return $this->fail(ExaminationLogic::getError());
    }

    /**
     * 模拟考试历史记录
     * @return \think\response\Json
     */
    public function mockExaminationList(): \think\response\Json
    {
        (new QuestionValidate())->get()->goCheck('detail');
        (new CommonValidate())->get()->goCheck('page');
        return $this->success('获取成功', ExaminationLogic::mockExaminationList($this->requestParams));
    }

    /**
     * 考试列表
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function examinationList(): \think\response\Json
    {
        (new CommonValidate())->get()->goCheck('page');
        return $this->success('考试查询成功', ExaminationLogic::examinationList($this->requestParams));
    }

    /**
     * 考试详情
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function examinationContent(): \think\response\Json
    {
        (new CommonValidate())->get()->goCheck('uid');
        return $this->success('考试查询成功', ExaminationLogic::examinationContent($this->requestParams));
    }

    /**
     * 提交在线考试数据
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function submitExamination(): \think\response\Json
    {
        (new CommonValidate())->post()->goCheck('uid');
        $result = ExaminationLogic::submitExamination($this->requestParams);
        if (count($result)) {
            return $this->success('提交成功', $result);
        }
        return $this->fail(ExaminationLogic::getError());
    }

    /**
     * 考试历史
     * @return \think\response\Json
     * @link https://www.tutudati.com
     * @email tutudati@outlook.com
     * @author 兔兔答题
     */
    public function examinationHistory(): \think\response\Json
    {
        (new CommonValidate())->get()->goCheck('page');
        return $this->success('查询成功', ExaminationLogic::examinationHistory($this->requestParams));
    }
}