import {
	templateSubscribe,
	fetchTemplateId
} from "@/utils/api/message.js"

export default {
	showToast(title, time = 3000, mask = false) {
		uni.showToast({
			title: title,
			duration: time,
			icon: "none",
			mask: mask,
		})
	},
	navigatorTo(url) {
		uni.navigateTo({
			url: url,
			fail(res) {
				console.log(res, url)
				uni.showToast({
					title: "地址不存在",
					icon: "none",
					mask: true,
				})
			}
		})
	},
	redirectTo(url) {
		uni.redirectTo({
			url: url,
			fail(res) {
				console.log(res, url)
				uni.showToast({
					title: "地址不存在",
					icon: "none",
					mask: true,
				})
			}
		})
	},
	navigatorMini(appid, path = '') {
		uni.navigateToMiniProgram({
			appId: appid,
			path: path
		})
	},
	setClipboardData(content, msg = '复制成功', showTotast = true) {
		uni.setClipboardData({
			data: content,
			showToast: showTotast,
			success() {
				uni.showToast({
					title: msg,
					icon: 'none'
				})
			},
			fail(res) {
				uni.showToast({
					title: res.errMsg,
					icon: 'none'
				})
			}
		})
	},
	previewImage(url) {
		wx.previewImage({
			urls: [url]
		})
	},
	showServiceImage() {
		wx.previewImage({
			urls: ['https://cdn.image.tutudati.com/service.png']
		})
	},
	saveImageToAlbum(image) {
		uni.downloadFile({
			url: image,
			success(res) {
				if (res.statusCode === 200) {
					uni.saveImageToPhotosAlbum({
						filePath: res.tempFilePath,
						success() {
							uni.showToast({
								title: '保存成功'
							})
						},
						fail(res) {
							uni.showToast({
								title: res.errMsg,
								icon: "none"
							})
						}
					})
				}
			},
			fail(res) {
				uni.showToast({
					title: res.errMsg,
					icon: "none"
				})
			}
		})
	},
	tnHome() {
		uni.reLaunch({
			url: '/pages/index/index'
		})
	},
	tnRelunch(url) {
		uni.reLaunch({
			url: url
		})
	},
	templateSubscribe(templateCode) {
		return new Promise((resolve, reject) => {
			fetchTemplateId({
				code: templateCode
			}).then(resConfig => {
				let template = ''
				if (resConfig.code === 100) {
					template = resConfig.data.template
				} else {
					uni.showToast({
						title: '暂无订阅配置',
						icon: "none",
						duration: 3000,
					})
					reject(resConfig)
					return
				}
				uni.requestSubscribeMessage({
					tmplIds: [template],
					success(res) {
						if (res.errMsg == 'requestSubscribeMessage:ok' && res[template] == 'accept') {
							templateSubscribe({
								code: templateCode
							}).then(res1 => {
								resolve(res1)
								let msg = "订阅失败"
								if (res1.code == 100) {
									msg = "订阅成功"
								}
								uni.showToast({
									title: msg,
									icon: "none",
								})
							}).catch((error) => {
								uni.showToast({
									title: error,
									icon: 'none',
									duration: 3000
								})
							})
						} else if (res.errMsg == 'requestSubscribeMessage:ok' && res[template] == 'reject') {
							uni.showModal({
								title: '订阅提示',
								content: '你已拒绝接收该消息，请打开右上角，设置按钮，在订阅消息中开启接收该消息，接收订阅有助你于实时接收试题最新更新状态。',
								success: function(res) {
									if (res.confirm) {
										console.log('用户点击确定');
									} else if (res.cancel) {
										console.log('用户点击取消');
									}
								}
							});
						} else {
							uni.showToast({
								title: res.errMsg,
								icon: 'none',
								duration: 3000
							})
						}
					},
					fail(res) {
						console.log("订阅失败", res)
						uni.showToast({
							title: res.errMsg,
							icon: 'none',
							duration: 3000
						})
					}
				})
			})
		})
	},
	verifyPhone(phoneNumber) {
		const regex = /^(\+?86)?[1][3-9][0-9]{9}$/
		return regex.test(phoneNumber)
	},
	currentPlatform() {
		// #ifdef MP-WEIXIN
		return 'wechat_mini'
		// #endif
		// #ifdef MP-TOUTIAO
		return 'dy_mini'
		// #endif
		// #ifdef H5
		return 'network_h5'
		// #endif
	}
}