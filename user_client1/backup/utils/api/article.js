import request from "@/utils/request"

export default {
	apiArtcileList(params) {
		return request.get("index/article/articleList", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiArticleContent(params) {
		return request.get("index/article/articleDetail", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiArticleCateList() {
		return request.get("index/article/categoryList").then(res => {
			return res
		})
	},
	apiArticleCollect(params) {
		return request.post("index/article/articleClickOrCollect", params).then(res => {
			return res
		})
	}
}