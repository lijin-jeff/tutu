import request from "@/utils/request"

export function templateSubscribe(params) {
	return request.post("index/Message/templateSubscribe", params).then(res => {
		return res
	})
}

export function fetchTemplateId(params) {
	return request.get("index/Message/getTemplateId", {params: params}).then(res => {
			return res
		})
}