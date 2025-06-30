<template>
	<view class="container">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">题型练习</text>
			</view>
		</tn-nav-bar>

		<!-- 列表区域 -->
		<view class="list-container" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<!-- 题型练习 Section -->
			<view class="list-section">
				<text class="section-header">题型练习</text>
				<view class="list-item" @click="handleItemClick('单选题')">
					<text class="item-title">单选题</text>
					<view class="item-right">
						<text class="item-count">1148道</text>
						<text class="tn-icon-right fs-18"></text>
					</view>
				</view>
				<view class="list-item" @click="handleItemClick('多选题')">
					<text class="item-title">多选题</text>
					<view class="item-right">
						<text class="item-count">493道</text>
						<text class="tn-icon-right fs-18"></text>
					</view>
				</view>
				<view class="list-item" @click="handleItemClick('多选题')">
					<text class="item-title">判断题</text>
					<view class="item-right">
						<text class="item-count">493道</text>
						<text class="tn-icon-right fs-18"></text>
					</view>
				</view>
				<view class="list-item" @click="handleItemClick('多选题')">
					<text class="item-title">填空题</text>
					<view class="item-right">
						<text class="item-count">493道</text>
						<text class="tn-icon-right fs-18"></text>
					</view>
				</view>
			</view>

			<!-- 试题分难易练习 Section -->
			<view class="list-section">
				<text class="section-header">试题分难易练习</text>
				<view class="list-item" @click="handleItemClick('适中')">
					<text class="item-title">简单</text>
					<view class="item-right">
						<text class="item-count">1641道</text>
						<text class="tn-icon-right fs-18"></text>
					</view>
				</view>
				<view class="list-item" @click="handleItemClick('适中')">
					<text class="item-title">适中</text>
					<view class="item-right">
						<text class="item-count">1641道</text>
						<text class="tn-icon-right fs-18"></text>
					</view>
				</view>
				<view class="list-item" @click="handleItemClick('适中')">
					<text class="item-title">困难</text>
					<view class="item-right">
						<text class="item-count">1641道</text>
						<text class="tn-icon-right fs-18"></text>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'questionType',
		mixins: [template_page_mixin],
		data() {
			return {
				// 数据可以从API获取
				mainColor: getApp().globalData.mainColor
			};
		},
		methods: {
			goBack() {
				uni.navigateBack();
			},
			handleItemClick(itemTitle) {
				console.log('Clicked:', itemTitle);
				uni.showToast({
					title: `点击了 ${itemTitle}`,
					icon: 'none'
				});
				// 在这里添加跳转到对应练习页面的逻辑
				// uni.navigateTo({ url: '/pages/practice/practice?type=' + itemTitle });
			}
		}
	}
</script>

<style lang="scss">
	@import "@/scss/custom_nav_bar.scss";

	// 页面整体背景色
	page {
		background-color: #f8f8f8;
	}

	.container {
		display: flex;
		flex-direction: column;
		height: 100vh;
	}

	.status-bar {
		height: var(--status-bar-height);
		width: 100%;
		background-color: #fff;
	}

	.nav-bar {
		display: flex;
		align-items: center;
		justify-content: space-between;
		height: 88rpx; // 44px * 2 = 88rpx
		padding: 0 30rpx; // 15px * 2 = 30rpx
		background-color: #fff;
		border-bottom: 1rpx solid #eee;

		.nav-title {
			font-size: 36rpx; // 18px * 2 = 36rpx
			font-weight: bold;
		}

		.nav-right {
			display: flex;
			align-items: center;
		}
	}

	.list-container {
		flex: 1;
		overflow-y: auto;
	}

	.list-section {
		margin-top: 20rpx; // 10px * 2 = 20rpx
		background-color: #fff;
	}

	.section-header {
		font-size: 28rpx; // 14px * 2 = 28rpx
		color: #666;
		padding: 20rpx 30rpx; // 10px * 2 = 20rpx, 15px * 2 = 30rpx
		display: block; // 独占一行
	}

	.list-item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 24rpx 30rpx; // 12px * 2 = 24rpx, 15px * 2 = 30rpx
		background-color: #fff;
		border-bottom: 1rpx solid #f0f0f0; // 分隔线
		position: relative; // 为了伪元素点击效果

		&:last-child {
			border-bottom: none; // 最后一个item没有下边框
		}

		// 模拟点击效果
		&:active::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: rgba(0, 0, 0, 0.05);
			pointer-events: none; // 不影响点击事件
		}

		.item-title {
			font-size: 32rpx; // 16px * 2 = 32rpx
			color: #333;
		}

		.item-right {
			display: flex;
			align-items: center;
			color: #999;
		}

		.item-count {
			font-size: 28rpx; // 14px * 2 = 28rpx
			margin-right: 10rpx; // 5px * 2 = 10rpx
		}
	}
</style>