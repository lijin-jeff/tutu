import request from "@/utils/request"

export default {
	apiBannerList(params) {
		return request.get('index/index/banner', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiMenuList(params) {
		return request.get('index/index/menuList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiPrivacyContent(params) {
		return request.get("index/article/serviceContent?", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiUploadImage(fileUrl) {
		return request.upload('index/upload/imageUpload', {
			fileType: "image",
			name: "file",
			filePath: fileUrl,
		}).then(res => {
			return res
		})
	},
	apiSendSmsCodeAuth(params) {
		return request.post('index/message/sendSmsCode', params).then(res => {
			return res
		})
	},
	apiLoginWay() {
		return request.post('index/index/loginWay').then(res => {
			return res
		})
	},
}