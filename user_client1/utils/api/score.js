import request from "@/utils/request"


export default {
	apiUserScoreList(params) {// 用户积分明细
		return request.get('api/score/scoreList', {params: params}).then(res => {
			return res
		})
	},
}