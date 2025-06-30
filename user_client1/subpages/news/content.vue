<template>
	<view class="template-news tn-safe-area-inset-bottom">
		<!-- 顶部自定义导航 -->
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">图文详情</text>
			</view>
		</tn-nav-bar>

		<!-- 内容区域开始 -->
		<view class="tn-margin-top-xs" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<view class="nav_title--wrap">
				<view class="nav_title tn-padding-sm">
					{{articleContent.title}}
				</view>
			</view>

			<view class="tn-flex tn-flex-wrap tn-margin-left-sm tn-margin-right-sm tn-color-grey">
				<view class="tn-padding-right-lg">
					<text class="tn-icon-eye"></text>
					<text class="">{{articleContent.click}}</text>
				</view>
				<view class="tn-padding-right-lg">
					<text class="tn-icon-my-simple"></text>
					<text class="">{{articleContent.author}}</text>
				</view>
				<view>
					<text class="tn-icon-calendar"></text>
					<text class="">{{articleContent.create_time}}</text>
				</view>
			</view>

			<view class="tn-padding-right-sm tn-padding-left-sm tn-margin-top-sm" style="padding-bottom: 110rpx;min-height: 100vh;">
				<mp-html :content="articleContent.content" />
			</view>

		</view>
		<!-- 内容区域结束 -->

		<!-- 底部菜单开始 -->
		<view class="tn-flex"
			style="height: 100rpx; width: 100%; line-height: 100rpx; position: fixed; bottom: 0rpx;background-color: #fff;">
			<view class="tn-flex tn-flex-col-center" style="width: 50%;font-size: 30rpx;">
				<view class="tn-flex tn-flex-direction-row tn-padding-left-lg">
					<!-- <image src="https://imgcdn.tutudati.com/office-logo.png" style="width: 60rpx; height:60rpx;"></image> -->
					<text class="tn-icon-my-add tn-text-bold"></text>
				</view>
				<view class="tn-padding-left-sm"><text>{{articleContent.author}}</text></view>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-right" style="width: 45%; line-height: 40rpx; text-align: center;">
<!-- 				<view class="bottom-menu" @click="submitCollection(1)">
					<view class="bottom-menu--icon">
						<text v-if="articleContent.is_share" class="tn-icon-praise-fill tt-text-main-color"></text>
						<text v-else class="tn-icon-share"></text>
					</view>
					<view class="bottom-menu--text">
						<text>{{articleContent.share_count}}</text>
					</view>
				</view> -->
				<view class="bottom-menu" @click="subscribe">
					<view class="bottom-menu--icon">
						<text class="tn-icon-notice"></text>
					</view>
					<view class="bottom-menu--text">
						<text>订阅</text>
					</view>
				</view>
				<view class="bottom-menu" @click="submitCollection()">
					<view class="bottom-menu--icon">
						<text v-if="articleContent.collect" class="tn-icon-star-fill tt-text-main-color"></text>
						<text v-else class="tn-icon-star"></text>
					</view>
					<view class="bottom-menu--text">
						<text>在看</text>
					</view>
				</view>
				<view class="bottom-menu" @click="feekback">
					<view class="bottom-menu--icon">
						<text class="tn-icon-message"></text>
					</view>
					<view class="bottom-menu--text">
						<text>写留言</text>
					</view>
				</view>
			</view>
			<view class="tn-margin-bottom-xl"></view>
		</view>
		<!-- 底部菜单结束 -->
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'TemplateNews',
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				groupAvatarList: [],
				groupList: [],
				searchWhere: { // 文章查询条件
					id: '',
				},
				relArticleContent: [], // 相关文章列表
				articleContent: {},
			}
		},
		onLoad(params) {
			this.searchWhere.id = params.uid || ''
			this.fetContent()
		},
		methods: {
			fetContent() {
				uni.showLoading({
					title: "努力加载中",
					icon: "none"
				})
				this.$api.apiArticleContent(this.searchWhere).then(res => {
					uni.hideLoading()
					if (res.code === 1) {
						this.articleContent = res.data
						return
					}
					this.$func.showToast(res.msg)
				})
			},
			feekback() {
				this.$func.showToast('暂未开放')
			},
			// 文章订阅
			subscribe() {
				if (this.$func.currentPlatform() !== 'wechat_mini') {
					this.$func.showToast('订阅支持微信小程序')
					return
				}
				this.$func.templateSubscribe('article_update')
			},
			submitCollection() {
				if (this.articleContent.collect === false) {
					this.$api.apiArticleAddCollect({
						id: this.searchWhere.id,
					}).then(res => {
						this.$func.showToast(res.msg)
						if (res.code === 1) {
							this.articleContent.collect = true
						}
					})
				} else if (this.articleContent.collect === true) {
					this.$api.apiArticleCancelCollect({
						id: this.searchWhere.id,
					}).then(res => {
						this.$func.showToast(res.msg)
						if (res.code === 1) {
							this.articleContent.collect = false
						}
					})
				}
			}
		},
		onShareAppMessage() {
			return {
				title: this.articleContent.title,
				desc: this.articleContent.abstract,
				path: "/subpackage/news/content?uid=" + this.searchWhere.id,
				imageUrl: this.articleContent.image
			}
		},
		onShareTimeline() {
			return {
				title: this.articleContent.title,
				desc: this.articleContent.abstract,
				path: "/subpackage/news/content?uid=" + this.searchWhere.id,
				imageUrl: this.articleContent.image
			}
		}
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";

	.template-news {
		background-color: #fff;
	}

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

	// 底部操作按钮结束
	/* 标题 start */
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

	/* 标题 end */
</style>