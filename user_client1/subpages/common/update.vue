<template>
	<view class="components-time-line">
		<tn-nav-bar fixed customBack  :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">更新历史</text>
			</view>
		</tn-nav-bar>

		<!-- 页面内容 -->
		<view :style="{paddingTop: vuex_custom_bar_height + 'px'}">

			<view class="time-line__wrap">
				<tn-time-line>
					<block v-for="(item, index) in expressData" :key="index">
						<tn-time-line-item v-if="item.status !== 0" :top="2">
							<template slot="node">
								<view class="time-line-item__node">
									<view v-if="item.status === 1" class="time-line-item__node--icon tn-icon-success"></view>
								</view>
							</template>
							<template slot="content">
								<view>
									<view class="time-line-item__content__title">{{ item.version }}</view>
									<view class="time-line-item__content__desc">{{ item.info }}</view>
									<view class="time-line-item__content__time">{{ item.time }}</view>
								</view>
							</template>
						</tn-time-line-item>
					</block>
				</tn-time-line>
			</view>
			
			<view class="tn-margin">
				<tn-button :backgroundColor="mainColor" @click="subscribe" fontSize="30rpx" fontColor="#fff" width="100%" height="80rpx">订阅更新</tn-button>
			</view>

		</view>

	</view>

</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'componentsTimeline',
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				expressData: [{
					info: '增加模拟考试、答题记录、题库兑换等功能',
					status: 1,
					time: '2024-05-05',
					version: 'v0.0.2',
				},{
					info: '发布beta版本',
					status: 1,
					time: '2024-05-05',
					version: 'v0.0.1',
				},]
			}
		},
		onLoad() {
			this.$t.mpShare = {
				share: false,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
		},
		methods: {
			// 微信订阅消息
			async subscribe() {
				let subscribeResult = await this.$func.templateSubscribe('app_version_update')
				let code = subscribeResult.code || 0
				if (code == 100) {
					this.$func.showToast("订阅成功")
					return
				}
				this.$func.showToast("订阅失败")
			},
		}

	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";
	.tn-time-line-class {
		.tn-time-line-item-class {
			&:first-child {
				.tn-time-line-item__node {
					.time-line-item__node {
						background-color: '#05CA8D' !important;
					}
				}
			}
		}
	}
	.time-line {
		&__wrap {
			padding: 60rpx 30rpx 30rpx 60rpx;
		}
		&-item {
			&__node {
				width: 44rpx;
				height: 44rpx;
				border-radius: 100rpx;
				display: flex;
				align-items: center;
				justify-content: center;
				background-color: #AAAAAA;

				&--active {
					background-color: '#05CA8D';
				}
				&--icon {
					color: #FFFFFF;
					font-size: 24rpx;
				}
			}
			&__content {
				&__title {
					font-weight: bold;
					font-size: 32rpx;
				}

				&__desc {
					color: $tn-font-sub-color;
					font-size: 28rpx;
					margin-bottom: 6rpx;
				}
				&__time {
					color: $tn-font-holder-color;
					font-size: 26rpx;
				}
			}
		}
	}
</style>