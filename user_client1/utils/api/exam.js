import request from "@/utils/request"

export default {
	apiQuestionCategoryTree() { // 试题分类
		return request.get('api/exam.category/category').then(res => {
			return res
		})
	},
	apiRecommendQuestionLib(params) { // 推荐题库
		return request.get('api/exam.questionlib/recommendList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiHotQuestionLib(params) { // 热门题库
		return request.get('api/exam.questionlib/hotList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionLib(params) { // 题库列表
		return request.get('api/exam.questionlib/questionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionDetail(params) { // 题库详情
		return request.get('api/exam.questionlib/questionDetail', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionMenu(params) { // 题库菜单配置
		return request.get('api/exam.questionlib/questionMenu', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionRandList(params) { // 随机练习试题列表
		return request.get('api/exam.questionlib/randOptionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionOrderList(params) { // 顺序练习试题列表
		return request.get('api/exam.questionlib/orderOptionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionChapterExamList(params) { // 章节练习试题列表
		return request.get('api/exam.questionlib/chapterOptionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionTypeExamList(params) { // 题型练习试题列表
		return request.get('api/exam.questionlib/typeOptionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionSearchList(params) { // 题库试题搜索列表
		return request.get('api/exam.questionlib/searchOptionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionChapterList(params) { // 题库章节列表
		return request.get('api/exam.questionlib/chapterList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionTypeList(params) { // 题库题型列表
		return request.get('api/exam.questionlib/questionTypeList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiMockExaminationConfig(params) { // 提交模拟考试配置
		return request.post('api/exam.examination/mockExaminationConfig', params).then(res => {
			return res
		})
	},
	apiMockExaminationList(params) { // 模拟考试拉取
		return request.get('api/exam.examination/mockQuestionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiMockExaminationSave(params) { // 模拟考试拉取
		return request.post('api/exam.examination/saveMockExamination', params).then(res => {
			return res
		})
	},
	apiMockExaminationHistoryList(params) { // 模拟考试历史列表
		return request.get('api/exam.examination/mockExaminationList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionCollection(params) { // 试题收藏
		return request.post('api/exam.questionlib/questionCollection', params).then(res => {
			return res
		})
	},
	apiQuestionCollectionList(params) { // 试题收藏列表
		return request.get('api/exam.questionlib/collectionOptionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionErrorList(params) { // 试题错题列表
		return request.get('api/exam.questionlib/errorOptionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiQuestionErrorRemove(params) { // 错题移除
		return request.post('api/exam.questionlib/questionErrorRemove', params).then(res => {
			return res
		})
	},
	apiExaminationList(params) { // 考试列表
		return request.get('api/exam.examination/examinationList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiExaminationContent(params) { // 考试详情
		return request.get('api/exam.examination/examinationContent', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiExaminationQuestionList(params) { // 考试试题列表
		return request.get('api/exam.questionlib/examinationQuestionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiSubmitExamination(params) { // 提交考试
		return request.post('api/exam.examination/submitExamination', params).then(res => {
			return res
		})
	},
	apiExaminationHistory(params) { // 考试历史记录
		return request.get('api/exam.examination/examinationHistory', {
			params: params
		}).then(res => {
			return res
		})
	},
}