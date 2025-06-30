<template>
	<view class="page-template tn-safe-area-inset-bottom">
		<!-- 顶部自定义导航开始 -->
		<view class="tn-navbg" :style="{height: vuex_custom_bar_height + 'px'}">
			<!-- 顶部自定义导航 -->
			<tn-nav-bar fixed customBack :backgroundColor="mainColor">
				<view slot="back" class='tn-custom-nav-bar__back'>
					<text class='icon tn-icon-left'  @click="goBack"></text>
					<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
				</view>
				<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
					<text class="tn-text-bold tn-text-xl tn-color-white">资源详情</text>
				</view>
			</tn-nav-bar>
		</view>

		<!-- 内容区域开始 -->
		<view class="tn-margin-top-xs">
			<view class="nav_title--wrap">
				<view class="nav_title tn-padding-sm">
					{{resourceContent.title}}
				</view>
			</view>
			<view class="tn-flex tn-flex-wrap tn-margin-left-sm tn-margin-right-sm tn-color-grey tn-margin-top-sm">
				<view class="tn-padding-right-lg">
					<text class="tn-icon-eye"></text>
					<text class="tn-padding-left-sm">{{resourceContent.view_count}}</text>
				</view>
				<view class="tn-padding-right-lg">
					<text class="tn-icon-my-simple"></text>
					<text class="tn-padding-left-sm">{{resourceContent.author}}</text>
				</view>
				<view>
					<text class="tn-icon-calendar"></text>
					<text class="tn-padding-left-sm">{{resourceContent.year + `年`}}</text>
				</view>
			</view>

			<view class="tn-padding-right-sm tn-padding-left-sm tn-margin-top-sm" style="padding-bottom: 110rpx;">
				<mp-html :content="resourceContent.remark" />
			</view>

		</view>
		<!-- 内容区域结束 -->

		<!-- 底部菜单开始 -->
		<view class="tn-flex"
			style="height: 100rpx; width: 100%; line-height: 100rpx; position: fixed; bottom: 0rpx;background-color: #fff;">
			<view class="tn-flex tn-flex-col-center" style="width: 50%;font-size: 30rpx;" @click="previewQRCodeImage">
				<view class="tn-flex tn-flex-direction-row tn-padding-left-lg">
					<!-- <image src="/static/customer.png" style="width: 60rpx; height:60rpx;"></image> -->
					<text class="tn-icon-my-add tn-text-bold"></text>
				</view>
				<view class="tn-padding-left-sm"><text>联系客服</text></view>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-right" style="width: 45%; line-height: 40rpx; text-align: center;">
				<!-- <view class="bottom-menu" @click="submitCollection(1)">
					<view class="bottom-menu--icon">
						<text v-if="resourceContent.is_click" class="tn-icon-praise-fill tt-text-main-color"></text>
						<text v-else class="tn-icon-praise"></text>
					</view>
					<view class="bottom-menu--text">
						<text>{{resourceContent.click_count}}</text>
					</view>
				</view> -->
				<view class="bottom-menu" @click="subscribleMessage">
					<view class="bottom-menu--icon">
						<text class="tn-icon-notice"></text>
					</view>
					<view class="bottom-menu--text">
						<text>订阅</text>
					</view>
				</view>
				<view class="bottom-menu" @click="submitCollection()">
					<view class="bottom-menu--icon">
						<text v-if="resourceContent.collection_state" class="tn-icon-star-fill tt-text-main-color"></text>
						<text v-else class="tn-icon-star"></text>
					</view>
					<view class="bottom-menu--text">
						<text>收藏</text>
					</view>
				</view>
				<view class="bottom-menu" @click="downloadClick">
					<view class="bottom-menu--icon">
						<text class="tn-icon-download"></text>
					</view>
					<view class="bottom-menu--text">
						<text>下载</text>
					</view>
				</view>
			</view>
		</view>
		<!-- 底部菜单结束 -->
		
		<!-- 激励视频广告 -->
		<RewardedVideoAd v-if="showAd" adUnitId="adunit-f42d23471e903ed9" buttonText="观看广告获取奖励" @ad-loaded="handleAdLoaded"
			@ad-error="handleAdError" @ad-close="handleAdClose" @ad-complete="handleAdComplete" />
			<!-- 激励视频广告 -->
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	import RewardedVideoAd from "@/components/ad/RewardedVideoAd.vue"
	export default {
		mixins: [template_page_mixin],
		components: {
			RewardedVideoAd
		},
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				uid: '',
				showAd: false,
				resourceContent: {}
			}
		},
		onLoad(params) {
			this.uid = params.uid
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: true,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
			this.fetchResourceContent()
		},
		methods: {
			// create ad start
			getRandomAdId() {
				let myArray = ['adunit-f42d23471e903ed9', 'adunit-c636f2e4424bda17', 'adunit-7f532db033f8fc1f']
				let randomIndex = Math.floor(Math.random() * myArray.length)
				return myArray[randomIndex]
			},
			// 广告加载成功
			handleAdLoaded() {
				uni.hideLoading()
				console.log("激励视频广告加载成功");
			},
			// 广告加载失败
			handleAdError(error) {
				this.$func.showToast('广告记载视频 请刷新重试')
				console.error("激励视频广告加载失败", error);
			},
			// 广告关闭（用户未完整观看）
			handleAdClose() {
				this.$func.showToast('下载资源需要观看完广告')
				console.log("用户未完整观看激励视频广告");
			},
			// 广告播放完成（用户完整观看）
			handleAdComplete() {
				console.log("用户完整观看了激励视频广告，发放奖励");
				this.fetchResourceUrl()
				// 这里可以添加发放奖励的逻辑
			},
			// 预览作者图片
			previewQRCodeImage() {
				this.$func.showServiceImage()
			},
			subscribleMessage() {
				this.$func.showToast('暂未开放')
				return
				this.$func.templateSubscribe('resource_update')
			},
			submitCollection(type) {
				if (this.resourceContent.collection_state) {
					this.$func.showToast("你已收藏")
					return
				}
				this.$api.apiResourceCollection({
					uid: this.uid,
				}).then(res => {
					this.$func.showToast(res.msg)
					if (res.code === 1) {
						this.resourceContent.collection_state = true
					}
				})
			},
			downloadClick() {
				uni.showLoading({
					title: '广告加载中',
					mask: true
				})
				this.showAd = true
			},
			fetchResourceUrl() {
				let _that = this
				this.$api.apiResourceDownload({
					uid: this.uid
				}).then(result => {
					if (result.code == 1) {
						uni.showModal({
							title: '下载提示',
							content: '链接复制成功之后，需要使用浏览器打开下载。',
							confirmText: '复制链接',
							cancelText: '暂不复制',
							confirmColor: '#FFA62D',
							cancelColor: '#42B476',
							success(res) {
								if (res.confirm) {
									_that.$func.setClipboardData(result.data.file_url, '链接复制成功')
								}
							},
							fail(res) {
								_that.$func.showToast(res.errMsg)
							}
						})
					} else {
						this.$func.showToast(result.msg)
					}
				})
			},
			fetchResourceContent() {
				uni.showLoading({
					title: '努力加载中',
					mask: true
				})
				this.$api.apiResourceContent({
					uid: this.uid
				}).then(res => {
					uni.hideLoading()
					this.resourceContent = res.data
				})
			}
		},
		onShareAppMessage() {
			return {
				title: this.resourceContent.title,
				imageUrl: this.resourceContent.cover,
				desc: this.resourceContent.title,
				path: '/subpackage/resource/content?uid=' + this.resourceContent.uid,
				bgImgUrl: this.cover,
			}
		},
		onShareTimeline() {
			return {
				title: this.resourceContent.title,
				imageUrl: this.resourceContent.cover,
				desc: this.resourceContent.title,
				path: '/subpackage/resource/content?uid=' + this.resourceContent.uid,
				bgImgUrl: this.resourceContent.cover,
			}
		}
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";

	// 底部操作按钮开始
	.bottom-menu {
		width: 25%;

		&--icon {
			font-size: 34rpx;
		}

		&--text {
			font-size: 20rpx;
		}
	}
	.nav_title {
		-webkit-background-clip: text;

		&--wrap {
			position: relative;
			display: flex;
			// height: 120rpx;
			font-size: 30rpx;
			align-items: center;
			// justify-content: center;
			// font-weight: bold;
			background-image: url('/static/image/title00.png');
			background-size: cover;
		}
	}
	.page-template {
		min-height: 100vh;
		// background-color: #E6FBFB;
	}
</style>