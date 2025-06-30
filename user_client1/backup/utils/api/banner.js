import request from "@/utils/request"

export default {
	apiBannerList(params) {
		return request.get('index/index/menuList', {
			params: params
		}).then(res => {
			return res
		})
	}
}