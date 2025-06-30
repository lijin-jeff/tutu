import request from "@/utils/request"

/**
 * 获取试卷分类
 * @param {Object} params
 */
export function getExamCategList(params) {
	return request.get("exam/cate/list", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 试卷状态验证
 * @param {Object} params 试卷uid
 */
export function collectionCheck(params) {
	return request.post("index/collection/collectionCheck", params).then(res => {
		return res
	})
}

/**
 * 首页试卷信息统计
 * @param {Object} params
 */
export function homeCollectionInfo(params) {
	return request.get('index/collection/homeCollectionInfo', {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 随机试题列表
 * @param {Object} params
 */
export function randExamList(params) {
	return request.get("index/exam/randExamList", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 模拟考试列表
 * @param {Object} collection_uid 试卷uid
 */

/**
 * 试卷激活码激活
 * @param {Object} params
 */


/**
 * 激活码列表
 * @param {Object} params
 */


/**
 * 试卷搜索条件
 */
export function searchWhere() {
	return request.get('index/collection/searchWhere').then(res => {
		return res
	})
}

/**
 * 获取试卷详情
 * @param {Object} params
 */
export function getCollectionContent(params) {
	return request.get("index/collection/collectionInfo", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取试卷问答试题列表
 * @param {Object} params
 */
export function getReadingList(params) {
	return request.get("getReadingListByCollection", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 根据阅读题，获取到相关的试卷
 * @param {Object} params
 */
export function getReadingRelList(params) {
	return request.get("exam/collection/rel/list", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取到问答试题的详情内容
 * @param {Object} params
 */
export function getReadingContent(params) {
	return request.get("getReadingContent", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 查询试卷答题用户组列表
 * @param {Object} params
 */
export function getCollectionGroupList(params) {
	return request.get("exam/collection/groupList", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 提交试卷收藏
 * @param {Object} params
 */
export function submitCollection(params) {
	return request.post("auth/submitCollectionCollect", params).then(res => {
		return res
	})
}

/**
 * 查询问答答题用户组列表
 * @param {Object} params
 */
export function getReadingGroupList(params) {
	return request.get("exam/reading/groupList", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 提交问答试题收藏记录
 * @param {Object} params
 */
export function submitReadingCollection(params) {
	return request.post("exam/user/collection/reading", params).then(res => {
		return res
	})
}

/**
 * 获取选择试题
 * @param {Object} params
 */
export function getOptionList(params) {
	return request.get("auth/getOptionListByCollection", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取当判断题
 * @param {Object} params
 */
export function getJudeList(params) {
	return request.get("auth/getJudeListByCollection", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取试卷完整试题
 * @param {Object} params
 */
export function getCollectionExamList(params) {
	return request.get("auth/getExamListByCollection", {
		params: params
	}).then(res => {
		return res
	})
}
/**
 * 获取提交试卷结果信息
 * @param {Object} params
 */





/**
 * 获取答题总排行
 * @param {Object} params
 */


/**
 * 试卷章节
 * @param {Object} params
 */
export function getCollectionChapterList(params) {
	return request.get("index/collection/chapterList", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取试卷错题记录
 * @param {Object} params
 */
export function getUserCollectionWrong(params) {
	return request.get("auth/getCollectionWrongList", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取试题解析
 * @param {Object} params
 */
export function getOptionAnalysis(params) {
	return request.get("auth/getOptionAnalysis", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 提交答题表单
 * @param {Object} params
 */
export function submitFormInfo(params) {
	return request.post("auth/submitForm", params).then(res => {
		return res
	})
}

/****************************************** 新版 ******************************************/
/**
 * 获取推荐试卷列表
 */
export function getRecommendList(params) {
	return request.get("index/collection/recommendCollectionList", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取首热门卷列表
 */
export function getHotList(params) {
	return request.get("index/collection/hotCollectionList", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取试卷分类
 */
export function getCategoryTree() {
	return request.get("index/collection/categoryTree").then(res => {
		return res
	})
}

/**
 * 试卷检索列表
 * @param {Object} params
 */
export function getCollectionList(params) {
	return request.get("index/collection/collectionList", {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取推荐分类
 */
export function getRecommendCategory() {
	return request.get('index/collection/recommendCategory').then(res => {
		return res
	})
}

/**
 * 试题收藏
 * @param {Object} params
 */
export function examCollectionCollect(params) {
	return request.post('index/exam/examCollect', params).then(res => {
		return res
	})
}

/**
 * 试题收藏
 * @param {Object} params
 */
export function examCollectionError(params) {
	return request.post('index/exam/examError', params).then(res => {
		return res
	})
}

/**
 * 移除错题
 * @param {Object} params
 */
export function examRemoveError(params) {
	return request.post('index/exam/removeError', params).then(res => {
		return res
	})
}