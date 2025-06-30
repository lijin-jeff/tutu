<template>
	<view class="template-content">
		<!-- 顶部自定义导航 -->
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">{{content.title}}</text>
			</view>
		</tn-nav-bar>

		<view class="tn-margin" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<mp-html :content="content.content" />
		</view>
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'TemplateContent',
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				content: {
					uid: '',
					title: '文章标题',
					content: '<p>文章内容</p>',
				},
				searchWhere: {},
				sence: "", // service_content:用户服务协议，privacy_content:用户隐私协议
			}
		},
		onLoad(params) {
			this.searchWhere.uid = params.uid || ""
			this.sence = params.sence || ""
			// if (this.sence !== '') {
			// 	this.getPrivacyContent()
			// } else {
			// 	this.getDocumentContent()
			// }
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: true,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
		},
		methods: {
			getDocumentContent() {
				this.$api.apiDocumentContent(this.searchWhere).then(res => {
					if (res.code == 100) {
						this.content = res.data
						return
					}
					this.$func.showToast(res.msg)
				})
			},
			getPrivacyContent() {
				this.$api.apiPrivacyContent({
					type: this.sence
				}).then(res => {
					if (res.code == 100) {
						this.content = {
							content: res.data.content,
							title: this.sence == 'privacy_content' ? '用户隐私协议' : '用户服务协议'
						}
						return
					}
					this.$func.showToast(res.msg)
				})
			},
			getServiceContent() {
				getServiceContent().then(res => {
					if (res.code == 100) {
						this.content = {
							content: res.data,
							title: "用户服务协议"
						}
						return
					}
					this.$func.showToast(res.msg)
				})
			},
		},
		onShareAppMessage() {
			return {
				title: '兔兔答题向你分享了' + this.content.title + '快去阅读吧',
				desc: '兔兔答题向你分享了' + this.content.title + '快去阅读吧',
				path: '/subpages/help/content?uid=' + this.searchWhere.uid,
			}
		},
		onShareTimeline() {
			return {
				title: '兔兔答题向你分享了' + this.content.title + '快去阅读吧',
				desc: '兔兔答题向你分享了' + this.content.title + '快去阅读吧',
				path: '/subpages/help/content?uid=' + this.searchWhere.uid
			}
		}
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";
</style>