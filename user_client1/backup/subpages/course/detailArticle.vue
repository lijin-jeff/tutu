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

			<view class="tn-padding-right-sm tn-padding-left-sm" style="padding-bottom: 110rpx;">
				<mp-html :content="articleContent.content" />
			</view>

		</view>
		<!-- 内容区域结束 -->
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
				searchWhere: { // 文章查询条件
					uid: "",
				},
				articleContent: {
					title: 'PHP是世界上最好的编程语言',
					content: '<p>这是图文内容</p>',
				},
			}
		},
		onLoad(params) {
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: false,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
			this.searchWhere.uid = params.uid || ""
			// this.getArticleContent()
		},
		methods: {
			// 获取文章内容
			getArticleContent() {
				uni.showLoading({
					title: "努力加载中",
					icon: "none"
				})
				this.$api.apiArticleContent(this.searchWhere).then(res => {
					if (res.code == 100) {
						this.articleContent = res.data
						return
					}
					this.$func.showToast(res.msg)
				}).finally(() => {
					uni.hideLoading()
				})
			},
			feekback() {
				this.$func.showToast('暂未开放')
			},
			// 文章订阅
			subscribe() {
				this.$func.templateSubscribe('article_update')
			},
			// 文章收藏或者点赞
			submitCollection(type) {
				if (this.articleContent.is_collect === 1 && type === 2) {
					this.$func.showToast("你已点在看")
					return
				} else if (this.articleContent.is_click === 1 && type === 1) {
					this.$func.showToast("你已点赞")
					return
				}
				this.$api.apiArticleCollect({
					uid: this.searchWhere.uid,
					type: type
				}).then(res => {
					if (res.code == 100) {
						this.articleContent.collect_count = this.articleContent.collect_count + 1
						if (type === 1) {
							this.articleContent.is_click = 1
							this.articleContent.like_count += 1
						} else if (type === 2) {
							this.articleContent.is_collect = 1
							this.articleContent.collect_count += 1
						}
					}
					if (res.code === 101 && res.data.code === 1) {
						if (type === 1) {
							this.articleContent.is_click = 1
						} else if (type === 2) {
							this.articleContent.is_collect = 1
						}
					}
					this.$func.showToast(res.msg)
				})
			},
			// 跳转
			tn(e) {
				uni.navigateTo({
					url: e,
				});
			},
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