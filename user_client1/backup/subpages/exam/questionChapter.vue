<template>
	<view class="container">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center">
				<text class="tn-text-bold tn-text-xl tn-color-white">章节练习</text>
			</view>
		</tn-nav-bar>

		<!-- 列表 -->
		<view class="list-container" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<view v-for="(group, groupIndex) in listData" :key="groupIndex" class="group-item">
				<view class="group-header" :class="{ 'expanded': group.expanded }">
					<view class="group-title-section" @click="menuExpend(groupIndex)">
						<text
							:class="group.expanded ? 'arrow-icon tn-icon-down-triangle fs-24' : 'arrow-icon tn-icon-up-triangle  fs-24'"></text>
						<text class="group-title  tn-text-ellipsis">{{ group.title }}</text>
					</view>
					<text class="count">{{ group.count }}</text>
				</view>
				<view v-if="group.expanded && group.children" class="children-list">
					<view v-for="(item, itemIndex) in group.children" :key="itemIndex" class="list-item tn-padding-left">
						<view class="item-title-section">
							<text
								:class="group.expanded ? 'arrow-icon tn-icon-down-triangle child-arrow fs-24' : 'arrow-icon tn-icon-up-triangle child-arrow  fs-24'"></text>
							<text class="item-title tn-text-ellipsis">{{ item.title }}</text>
						</view>
						<text class="count">{{ item.count }}</text>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'questionChapter',
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				listData: [{
					title: '2021章节练习~新版',
					count: 1073,
					expanded: true, // 默认展开
					children: [{
							title: '第二章 社会工作价值观与专业伦理',
							count: 67
						},
						{
							title: '第三章 人类行为与社会环境',
							count: 93
						},
					]
				}, {
					title: '2021章节练习~新版',
					count: 1073,
					expanded: false, // 默认展开
					children: [{
							title: '第二章 社会工作价值观与专业伦理',
							count: 67
						},
						{
							title: '第三章 人类行为与社会环境',
							count: 93
						},
					]
				}, ],
			};
		},
		methods: {
			menuExpend(index) {
				this.listData[index].expanded = true
				this.listData.forEach((value, key) => {
					if (key !== index) {
						value.expanded = false
					}
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import "@/scss/custom_nav_bar.scss";

	.container {
		background-color: #f8f8f8;
		min-height: 100vh;
		font-size: 28rpx;
		/* 基础字体大小 */
	}

	/* 列表容器 */
	.list-container {
		padding: 20rpx 0;
	}

	/* 分组项 */
	.group-item {
		// margin-bottom: 20rpx;
	}

	.group-header,
	.list-item {
		display: flex;
		align-items: center;
		justify-content: space-between;
		background-color: #fff;
		padding: 25rpx 20rpx;
		border-radius: 10rpx;
		// margin: 0 20rpx;
		/* 左右留边 */
		box-shadow: 0 2rpx 5rpx rgba(0, 0, 0, 0.05);
	}

	.group-header {
		border-radius: 10rpx;
		/* 确保圆角 */
		margin-bottom: 1rpx;
		/* 分组头和子项之间的细微间距 */
	}

	.list-item {
		margin-top: 1rpx;
		/* 子项之间的间距 */
		border-radius: 0;
		/* 子项默认无圆角 */
	}

	.list-item:first-child {
		border-top-left-radius: 0;
		border-top-right-radius: 0;
	}

	.list-item:last-child {
		border-bottom-left-radius: 10rpx;
		border-bottom-right-radius: 10rpx;
	}

	.bottom-item {
		margin-top: 20rpx;
	}


	.group-title-section,
	.item-title-section {
		display: flex;
		align-items: center;
	}

	.arrow-icon {
		color: #999;
		margin-right: 15rpx;
		width: 30rpx;
		/* 固定宽度方便对齐 */
		text-align: center;
	}

	.child-arrow {
		color: #ccc;
		/* 子项箭头颜色更浅 */
	}

	.blue-dot {
		color: #007aff;
		/* 蓝色指示点 */
		font-size: 20rpx;
		/* 点可以小一点 */
	}

	.group-header.expanded .arrow-icon {
		color: $view-theme;
		/* 展开时箭头颜色 */
	}

	.group-title,
	.item-title {
		color: #333;
		font-size: 30rpx;
	}

	.count {
		color: #999;
		font-size: 26rpx;
	}

	.children-list {
		// margin: 0 20rpx;
		/* 与父级左右边距一致 */
		border-radius: 10rpx;
		/* 整体圆角 */
		overflow: hidden;
		/* 隐藏子项溢出的部分以保持圆角 */
		box-shadow: 0 2rpx 5rpx rgba(0, 0, 0, 0.05);
	}

	/* 移除 children-list 中第一个 list-item 的上边距 */
	.children-list .list-item:first-child {
		margin-top: 0;
	}
</style>