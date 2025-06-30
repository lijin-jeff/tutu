import request from "@/utils/request"

export default {
	apiMiniCodeLogin(params) {
		return request.post("index/login/wxLogin", params).then(res => {
			return res
		})
	},
	apiNumberLogin(params) {
		return request.post("index/login/numberLogin", params).then(res => {
			return res
		})
	},
	apiPhoneLogin(params) {
		return request.post('index/login/phoneLogin', params).then(res => {
			return res
		})
	},
	apiGetAvatarUserInfo() {
		return request.get("user/avatar/info", {}).then(res => {
			return res
		})
	},
	apiGetUserQrCode() {
		return request.get('index/user/userQrCode', {}). then(res => {
			return res
		})
	},
	apiBindWxMobile(params) {
		return request.post('index/user/bindWxMobile', params).then(res => {
			return res
		})
	},
	apiGetUserBasicInfo() {
		return request.get("index/user/userBasicInfo", {}).then(res => {
			return res
		})
	},
	apiUpdateUserBasicInfo(params) {
		return request.post("index/user/updateInfo", params).then(res => {
			return res
		})
	},
	apiCheckUserLoginState() {
		return request.options("user/check/login").then(res => {
			return res
		})
	},
	apiGetMemberConfigList() {
		return request.get("user/member/config/getList").then(res => {
			return res
		})
	},
	apiGetMemberConfigContent(params) {
		return request.get("user/member/config/getContent", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiBindMobileCode(params) {
		return request.post('index/user/bindMobileCode', params).then(res => {
			return res
		})
	}
}