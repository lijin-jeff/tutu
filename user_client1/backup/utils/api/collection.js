import request from "@/utils/request"

export default {
	apiHotCollectionList(params) {
		return request.get('index/collection/hotCollectionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiRecommendCollectionList(params) {
		return request.get('index/collection/recommendCollectionList', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiCollectionInfo(params) {
		return request.get('index/collection/collectionInfo', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiCollectionCheck(params) {
		return request.post("index/collection/collectionCheck", params).then(res => {
			return res
		})
	},
	apiHomeCollectionInfo(params) {
		return request.get('index/collection/homeCollectionInfo', {
			params: params
		}).then(res => {
			return res
		})
	},
	apiExamCollectionCollect(params) {
		return request.post('index/exam/examCollect', params).then(res => {
			return res
		})
	},
	apiExamCollectionError(params) {
		return request.post('index/exam/examError', params).then(res => {
			return res
		})
	},
	apiRandExamList(params) {
		return request.get("index/exam/randExamList", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiExamRemoveError(params) {
		return request.post('index/exam/removeError', params).then(res => {
			return res
		})
	},
	apiGetSimulateDetail(params) {
		return request.get("index/submit/simulateDetail", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiGetSubmitCollectionInfo(params) {
		return request.get("index/submit/submitDetail", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiSimulateExamList(params) {
		return request.get("index/exam/simulateExamList", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiErrorExamList(params) {
		return request.get("index/exam/errorExamList", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiCollectionExamList(params) {
		return request.get("index/exam/collectionExamList", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiExamSubmit(params) {
		return request.post("index/exam/submitExam", params).then(res => {
			return res
		})
	},
	apiGetSubmitHisotyList(params) {
		return request.get("index/submit/historyList", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiGetSubmitInfo(params) {
		return request.get("auth/getSubmitInfo", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiRechargeList(params) {
		return request.get("index/recharge/rechargeList", {
			params: params
		}).then(res => {
			return res
		})
	},
	apiRechargeCode(params) {
		return request.post("index/collection/rechargeCode", params).then(res => {
			return res
		})
	},
	apiScoreRankList(params) {
		return request.get("index/collection/rankList", {
			params: params
		}).then(res => {
			return res
		})
	}
}