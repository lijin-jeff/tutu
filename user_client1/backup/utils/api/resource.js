import request from "@/utils/request"

export default {
	apiResourceList(params) {
		return request.get('index/resource.resource/resourceList', {params: params}).then(res => {
			return res
		})
	},
	apiResourceContent(params) {
		return request.get('index/resource.resource/sourceContent', {params: params}).then(res => {
			return res
		})
	},
	apiResourceShareLink(params) {
		return request.get('index/resource.resource/shareUrl', {params: params}).then(res => {
			return res
		})
	},
	apiResourceScene(params) {
		return request.get('index/resource.resource/homeResource', {params: params}).then(res => {
			return res
		})
	}
}