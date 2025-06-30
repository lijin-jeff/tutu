import request from "@/utils/request"


/**
 * 积分明细列表
 * @param {Object} params
 */
export function scoreHistoryList(params) {
	return request.get('index/score.score/scoreHistoryList', {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 获取用户积分
 */
export function userScore(params) {
	return request.get('index/score.score/userScore', {
		params: params
	}).then(res => {
		return res
	})
}

/**
 * 签到日期列表
 */
export function signDate() {
	return request.get('index/score.task/signDate').then(res => {
		return res
	})
}

/**
 * 签到任务列表
 */
export function signTask() {
	return request.get('index/score.task/signTask').then(res => {
		return res
	})
}

/**
 * 签到任务规则
 */
export function signRule() {
	return request.get('index/score.task/signRule').then(res => {
		return res
	})
}

/**
 * 签到状态
 */
export function signState() {
	return request.get('index/score.task/signState').then(res => {
		return res
	})
}

/**
 * 今日签到
 */
export function currentDaySign() {
	return request.post('index/score.task/currentDaySign').then(res => {
		return res
	})
}