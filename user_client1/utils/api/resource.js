import request from "@/utils/request"

export default {
	apiResourceList(params) {// 资源列表
		return request.get('api/resource.resource/resourceList', {params: params}).then(res => {
			return res
		})
	},
	apiResourceCategory(params) {// 资源分类
		return request.get('api/resource.resource/categoryList', {params: params}).then(res => {
			return res
		})
	},
	apiResourceContent(params) {
		return request.get('api/resource.resource/resourceContent', {params: params}).then(res => {
			return res
		})
	},
	apiResourceDownload(params) {// 资源下载
		return request.get('api/resource.resource/resourceDownload', {params: params}).then(res => {
			return res
		})
	},
	apiResourceCollection(params) {// 资源收藏
		return request.post('api/resource.resource/resourceCollection', params).then(res => {
			return res
		})
	}
}