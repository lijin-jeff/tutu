import request from "@/utils/request"

/**
 * 获取首页导航菜单
 * @param {Object} params
 */
export function getHomeMenuList(params) {
	return request.get("index/index/homeMenu", {
		params: params,
	}).then(res => {
		return res
	})
}

/**
 * 获取主页航菜单
 * @param {Object} params
 */
export function getMainMenuList(params) {
	return request.get("index/index/homeMainMenu", {
		params: params,
	}).then(res => {
		return res
	})
}


/**
 * 获取主页商业航菜单
 * @param {Object} params
 */
export function homeBusinessMenu(params) {
	return request.get("index/index/homeBusinessMenu", {
		params: params,
	}).then(res => {
		return res
	})
}

/**
 * 获取主页项目案例展示
 * @param {Object} params
 */
export function homeProjectMenu(params) {
	return request.get("index/index/homeProjectMenu", {
		params: params,
	}).then(res => {
		return res
	})
}

/**
 * 首页历史数据
 * @param {Object} params
 */
export function getMainData(params) {
	return request.get("index/index/homeMainData", {
		params: params,
	}).then(res => {
		return res
	})
}

/**
 * 获取页面图片配置
 */
export function getImageConfig() {
	return request.get('index/index/imageConfig').then(res => {
		return res
	})
}

/**
 * 获取首页顶部banner
 * @param {Object} params
 */
// export function getBannerList(params) {
// 	return request.get("getBannerList", {
// 		params: params,
// 	}).then(res => {
// 		return res
// 	})
// }

/**
 * 获取用户专业配置列表
 */
export function getUserProfessionList() {
	return request.get("config/profession/getList", {}).then(res => {
		return res
	})
}

/**
 * 获取首页公告列表
 * @param {Object} params
 */
export function getNoticeList(params) {
	return request.get("getNoticeList", {
		params: params,
	}).then(res => {
		return res
	})
}

/**
 * 获取开发状态配置
 */
export function getDevState() {
	return request.get("getDevState").then(res => {
		return res
	})
}

/**
 * 获取首页顶部banner
 * @param {Object} params
 */
export function getBannerList(params) {
	return request.get("index/index/banner", {
		params: params,
	}).then(res => {
		return res
	})
}


/**
 * 获取配置信息
 */
export function getSysConfig() {
	return request.get('index/index/getSysEnv').then(res => {
		return res
	})
}

/**
 * 发送手机验证码
 * @param {Object} params
 */
export function sendSmsCodeAuth(params) {
	return request.post('index/message/sendSmsCode', params).then(res => {
		return res
	})
}