<template>
	<view class="container">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">刷题排行榜</text>
			</view>
		</tn-nav-bar>

		<!-- 顶部 Banner -->
		<view class="banner" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<view class="banner-title tn-margin-top">刷题排行榜</view>
			<view class="tag" style="width: 300rpx;">#每周一零点结算积分#</view>
			<view class="tag gift-tag" style="width: 400rpx;">
				<text class="gift-icon">🎁</text> #每周排名前3名可获得积分#
			</view>
		</view>
		<!-- Tabs -->
		<view class="tn-flex tn-flex-row-center tn-margin">
			<view class="tabs">
				<view :class="currentTab === 0 ? ' tab active' : 'tab'" @click="scoreTab(0)">本周榜单</view>
				<view :class="currentTab === 1 ? ' tab active  tn-margin-left' : 'tab tn-margin-left'" @click="scoreTab(1)">上周榜单</view>
			</view>
		</view>

		<!-- 我的成绩 -->
		<view class="my-score-card">
			<text class="my-score-label">我的成绩</text>
			<image class="avatar" :src="myInfo.avatar" mode="aspectFill"></image>
			<text class="name">{{ myInfo.name }}</text>
			<text class="rank-status">{{ myInfo.rankStatus }}</text>
			<text class="score">{{ myInfo.score }}</text>
		</view>

		<!-- 排行榜列表 -->
		<view class="leaderboard">
			<!-- 列表头部 -->
			<view class="list-header">
				<text class="header-rank">排名</text>
				<text class="header-name">姓名</text>
				<text class="header-score">答对题数</text>
			</view>
			<!-- 列表项 -->
			<view class="list-item" v-for="(item, index) in leaderboardData" :key="index">
				<view class="rank-cell">
					<image v-if="index < 3" :src="getMedalIcon(index)" class="medal-icon" mode="widthFix"></image>
					<text v-else class="rank-number">{{ index + 1 }}</text>
				</view>
				<view class="name-cell">
					<image class="avatar item-avatar" :src="item.avatar" mode="aspectFill"></image>
					<text class="name">{{ item.name }}</text>
				</view>
				<view class="points-cell" :class="{ 'highlight-points': index < 3 }">
					{{ item.points > 0 ? '+' + item.points + '积分' : '+0积分' }}
				</view>
				<text class="score-cell">{{ item.score }}</text>
			</view>
			<view class="tn-padding-bottom-xl"></view>
		</view>

	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'questionRank',
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				currentTab: 0,
				myInfo: {
					name: '沐',
					avatar: '/static/image/defalut_logo.png', // 替换为用户头像
					rankStatus: '暂未排名',
					score: 0
				},
				leaderboardData: [{
						name: '刘国华',
						avatar: '/static/image/defalut_logo.png',
						points: 3,
						score: 254
					}, // 替换为实际头像
					{
						name: '小生',
						avatar: '/static/image/defalut_logo.png',
						points: 2,
						score: 124
					},
					{
						name: '王乐',
						avatar: '/static/image/defalut_logo.png',
						points: 1,
						score: 115
					},
					{
						name: '< dm align...',
						avatar: '/static/image/defalut_logo.png',
						points: 0,
						score: 34
					},
					{
						name: 'wx-10636',
						avatar: '/static/image/defalut_logo.png',
						points: 0,
						score: 26
					},
					{
						name: 'A探伤大王',
						avatar: '/static/image/defalut_logo.png',
						points: 0,
						score: 24
					},
					{
						name: '陌川',
						avatar: '/static/image/defalut_logo.png',
						points: 0,
						score: 22
					},
				]
			};
		},
		methods: {
			getMedalIcon(index) {
				const icons = [
					'/static/image/gold_gift.png',
					'/static/image/silver_gift.png',
					'/static/image/copper_gift.png'
				];
				return icons[index];
			},
			scoreTab(index) {
				this.currentTab = index
			}
		}
	}
</script>

<style scoped lang="scss">
	@import "@/scss/custom_nav_bar.scss";

	.container {
		background-color: #f8f8f8;
		min-height: 100vh;
		padding-bottom: 20rpx;
		/* 底部留白 */
	}

	/* 模拟导航栏样式 (与之前类似，背景透明) */
	.nav-bar {
		position: absolute;
		/* 悬浮在 banner 上 */
		top: 0;
		left: 0;
		right: 0;
		display: flex;
		align-items: center;
		justify-content: space-between;
		height: 88rpx;
		/* 状态栏高度 + 导航栏内容高度，需要适配 */
		padding: var(--status-bar-height) 30rpx 0;
		/* 适配状态栏 */
		background-color: transparent;
		/* 透明背景 */
		z-index: 10;
		color: #fff;
		/* 白色图标和文字 */
	}

	.back-icon,
	.action-icon {
		color: #fff;
		font-size: 40rpx;
	}

	.title {
		color: #fff;
		font-size: 34rpx;
		font-weight: bold;
	}

	.actions {
		display: flex;
		align-items: center;
	}

	.action-icon {
		margin-left: 30rpx;
	}


	/* 顶部 Banner */
	.banner {
		background: linear-gradient(180deg, #42B476 0%, #42B476 100%);
		/* 渐变背景 */
		padding: calc(var(--status-bar-height) + 88rpx) 30rpx 40rpx;
		/* 顶部留出导航栏空间，底部增加padding */
		text-align: center;
		color: #fff;
		position: relative;
		overflow: hidden;
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.banner-title {
		font-size: 56rpx;
		font-weight: bold;
		margin-bottom: 20rpx;
		// 可以添加文字描边或阴影效果
	}

	.tag {
		background-color: rgba(255, 255, 255, 0.8);
		color: #00796B;
		/* 深青色 */
		padding: 8rpx 20rpx;
		border-radius: 30rpx;
		font-size: 24rpx;
		margin: 10rpx 5rpx;
	}

	.gift-tag {
		background-color: rgba(255, 255, 255, 0.9);
	}

	.gift-icon {
		margin-right: 8rpx;
	}

	/* Tabs */
	.tabs {
		// text-align: center;
		// position: absolute;
		// bottom: -40rpx;
		/* 使其一半悬浮在banner下方 */
		left: 50%;
		// transform: translateX(-50%);
		display: flex;
		width: 440rpx;
		height: 60rpx;
		line-height: 60rpx;
		justify-content: center;
		flex-direction: row;
		background-color: #fff;
		border-radius: 40rpx;
		// box-shadow: 0 4rpx 10rpx rgba(0, 0, 0, 0.1);
		/* 给内部tab留出空间 */
		// z-index: 5;
	}

	.tab {
		width: 200rpx;
		// padding: 15rpx 40rpx;
		font-size: 28rpx;
		text-align: center;
		color: #666;
		border-radius: 35rpx;
		transition: all 0.3s ease;
	}

	.tab.active {
		background-color: $view-theme;
		/* 激活状态背景色 */
		color: #fff;
		font-weight: bold;
	}

	/* 我的成绩 */
	.my-score-card {
		background-color: #fff;
		margin: 20rpx 30rpx 20rpx;
		/* 顶部留出tabs空间 */
		border-radius: 16rpx;
		padding: 30rpx;
		display: flex;
		align-items: center;
		position: relative;
		/* 用于定位label */
		// box-shadow: 0 4rpx 10rpx rgba(0, 0, 0, 0.05);
	}

	.my-score-label {
		position: absolute;
		top: -20rpx;
		left: 30rpx;
		background: linear-gradient(to right, #FFD700, #FFA500);
		/* 金黄色渐变 */
		color: #fff;
		padding: 5rpx 15rpx;
		border-radius: 8rpx 8rpx 8rpx 0;
		/* 左下角直角 */
		font-size: 24rpx;
		font-weight: bold;
	}

	.avatar {
		width: 80rpx;
		height: 80rpx;
		border-radius: 50%;
		margin-right: 20rpx;
		background-color: #eee;
		/* 占位背景 */
	}

	.name {
		font-size: 30rpx;
		color: #333;
		font-weight: bold;
		flex-grow: 1;
		/* 占据剩余空间 */
	}

	.rank-status {
		font-size: 26rpx;
		color: #999;
		margin-right: 20rpx;
	}

	.score {
		font-size: 30rpx;
		color: $view-theme;
		/* 橙色 */
		font-weight: bold;
	}

	/* 排行榜 */
	.leaderboard {
		background-color: #fff;
		margin: 0 30rpx;
		border-radius: 16rpx;
		padding: 0 30rpx 20rpx;
		/* 底部留白 */
		// box-shadow: 0 4rpx 10rpx rgba(0, 0, 0, 0.05);
	}

	.list-header {
		display: flex;
		align-items: center;
		padding: 25rpx 0;
		font-size: 24rpx;
		color: #999;
		border-bottom: 1rpx solid #f0f0f0;
	}

	.header-rank {
		width: 15%;
		text-align: center;
	}

	.header-name {
		width: 40%;
		text-align: left;
		padding-left: 10rpx;
	}

	.header-score {
		width: 45%;
		text-align: right;
		padding-right: 10rpx;
	}

	.list-item {
		display: flex;
		align-items: center;
		padding: 25rpx 0;
		border-bottom: 1rpx solid #f0f0f0;

		&:last-child {
			border-bottom: none;
		}
	}

	.rank-cell {
		width: 15%;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.medal-icon {
		width: 50rpx;
		height: auto;
		/* 高度自适应 */
	}

	.rank-number {
		font-size: 30rpx;
		color: #666;
		font-weight: bold;
	}

	.name-cell {
		width: 40%;
		display: flex;
		align-items: center;
		padding-left: 10rpx;
	}

	.item-avatar {
		width: 70rpx;
		height: 70rpx;
		border-radius: 50%;
		margin-right: 15rpx;
		background-color: #eee;
		/* 占位背景 */
	}

	.name {
		font-size: 28rpx;
		color: #333;
		// 处理名字过长的情况
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	.points-cell {
		width: 25%;
		/* 调整宽度给积分 */
		font-size: 24rpx;
		color: $view-theme;
		/* 默认橙色 */
		text-align: right;
		padding-right: 10rpx;
	}

	.highlight-points {
		font-weight: bold;
	}

	.score-cell {
		width: 20%;
		/* 调整宽度给答对题数 */
		font-size: 28rpx;
		color: #333;
		font-weight: bold;
		text-align: right;
		padding-right: 10rpx;
	}
</style>