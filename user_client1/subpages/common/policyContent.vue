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
					title: '',
					content: '',
				},
				type: 'privacy',
			}
		},
		onLoad(params) {
			this.type = params.type || 'privacy'
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: false,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
			this.fetchPrivacyContent()
		},
		methods: {
			fetchPrivacyContent() {
				this.$api.apiPolicyContent({type: this.type}).then(res => {
					if (res.code === 1) {
						this.content = res.data
						return
					}
					this.$func.showToast(res.msg)
				})
			}
		}
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";
</style>