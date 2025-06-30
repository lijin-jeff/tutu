import Request from "luch-request"
// let baseUrl = 'https://yuanshuati.tutudati.com/'
let baseUrl = "http://localhost.tutudati003.api.com/"

const http = new Request({
	baseURL: baseUrl,
	timeout: 30000,
})
http.interceptors.request.use((config) => {
	let sysInfo = {}
	uni.getSystemInfo({
		success(res) {
			sysInfo = res
		}
	})
	config.header = {
		Authorization: 'Bearer ' + uni.getStorageSync("login"),
		PlatformInfo: encodeURI(JSON.stringify(sysInfo)),
		Platform: "wechat_mini",
		'User-Code': 'Mg==',
	}
	return config
})
http.interceptors.response.use((response) => {
	return response.data
}, (response) => {
	if (response.statusCode === 200 && response.code === 101) {
		uni.showToast({
			title: response.data.msg || '请求失败',
			icon: "none",
			duration: 3000,
		})
	}
	if (response.statusCode === 500) {
		uni.showToast({
			title: response.data.msg || '服务器错误',
			icon: "none",
			duration: 3000,
		})
	} else if (response.statusCode === 400) {
		uni.showToast({
			title: response.data.msg,
			icon: "none",
			duration: 3000,
		})
	} else if (response.statusCode === 404) {
		uni.showToast({
			title: response.data.msg,
			icon: "none",
			duration: 3000,
		})
	} else if (response.statusCode === 422) {
		uni.showToast({
			title: response.data.msg,
			icon: "none",
			duration: 3000,
		})
	} else if (response.statusCode === 401) {
		uni.navigateTo({
			url: '/subpages/user/login'
		})
	} else if (response.statusCode === 302) {
		uni.navigateTo({
			url: response.data.data.url,
			success() {
				uni.showToast({
					title: response.data.msg,
					icon: "none",
					duration: 5000,
					mask: true
				})
			}
		})
	} else if (response.statusCode === 403) {
		uni.showToast({
			title: response.data.msg,
			icon: "none",
			duration: 3000,
		})

	} else if (response.errMsg === "request:fail timeout") {
		uni.showToast({
			title: "网络请求超时",
			icon: "none",
			duration: 3000,
		})
	} else {
		uni.showToast({
			title: response.errMsg,
			icon: "none",
			duration: 3000,
		})
	}
})
export default http