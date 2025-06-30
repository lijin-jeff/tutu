<template>
	<view class="template-help tn-safe-area-inset-bottom">
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">在线帮助</text>
			</view>
		</tn-nav-bar>

		<view class="tn-margin-bottom-xl" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<block v-for="(item, index) in helpList" :key="index">
				<view class="tn-flex tn-flex-row-between tn-padding-right-sm tn-padding-left-sm tn-strip-bottom-min tn-margin-top-xs">
					<view class="justify-content-item">
						<view class="tn-text-lg">
							{{item.title}}
						</view>
					</view>
				</view>
				<!-- 文档列表开始 -->
				<view class="tn-flex tn-flex-row-between tn-strip-bottom-min tn-padding-sm tn-margin-top-xs"
					v-for="(item1, index) in item.children" :key="index" @click="tn('/subpages/common/helpContent?uid=' + item1.uid)">
					<view class="justify-content-item">
						<view class="tn-text-df">
							{{ item1.title }}
						</view>
					</view>
					<view class="justify-content-item tn-text-lg tn-color-grey">
						<view class="tn-icon-right"></view>
					</view>
				</view>
				<!-- 文档列表结束 -->
			</block>

		</view>


		<view
			class="tn-footerfixed tn-flex tn-flex-row-between tn-flex-col-center tn-padding tn-safe-area-inset-bottom tn-bg-white"
			@click="showModal">
			<view class="justify-content-item tn-padding-bottom">
				<view class="tn-flex tn-flex-col-center tn-flex-row-left">
					<view class="user-pic">
						<view class="user-image">
							<view class="tn-shadow-blur"
								style="background-image:url('https://imgcdn.tutudati.com/office-logo.png');width: 100rpx;height: 100rpx;background-size: cover;">
							</view>
						</view>
					</view>
					<view class="tn-padding-right tn-color-black">
						<view class="tn-padding-right tn-padding-left-sm">
							<text class="tn-text-lg tn-text-bold">Mandy</text>
							<text class="tn-padding-left-sm">资深服务端研发工程师</text>
						</view>
						<view class="tn-padding-right tn-padding-top-xs tn-padding-left-sm tn-text-ellipsis">
							<text class="tn-color-black tn-text-bold">兔兔工作室</text>
						</view>
					</view>
				</view>
			</view>
			<view class="justify-content-item tn-flex-col-center tn-flex-row-center tn-text-center tn-padding-bottom">
				<view class="">
					<text class="tn-icon-wechat-fill tn-color-green--dark" style="font-size: 50rpx;"></text>
				</view>
				<view class="">
					<text class="tn-text-sm">联系客服</text>
				</view>
			</view>
		</view>

		<tn-modal v-model="show1" :custom="true">
			<view class="custom-modal-content">
				<image @tap="previewQRCodeImage" src='https://imgcdn.tutudati.com/9a24e2f9cad6b7c328bb7f4af49fe1b0.png'
					mode='aspectFill' style="width: 100%;"></image>
				<view class="tn-text-center tn-padding-top" @click="copyWechat">
					<text class="">客服微信：wx_06282 </text>
					<text class="tn-color-blue--disabled tn-padding-left-xs tn-text-df tn-icon-copy"></text>
				</view>
				<view class="tn-text-center tn-padding-top tn-text-lg">点击上图，可识别微信二维码</view>
			</view>
		</tn-modal>

		<view class='tn-tabbar-height'></view>
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	export default {
		name: 'TemplateHelp',
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				show1: false,
				helpList: [{
					title: '分类名称',
					uid: '',
					children: [{
						uid: '',
						title: '文章标题'
					}],
				}]
			}
		},
		onLoad() {
			// this.fetchDocumentGroupList()
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
			// 获取帮助文档列表
			fetchDocumentGroupList() {
				this.$api.apiDocumentGroupList({}).then(res => {
					if (res.code == 100) {
						this.helpList = res.data
						return
					}
					return this.$func.showToast(res.msg)
				})
			},
			// 跳转
			tn(e) {
				uni.navigateTo({
					url: e,
				});
			},
			// 复制微信号
			copyWechat() {
				this.$func.setClipboardData('wx_06282')
			},
			// 预览作者图片
			previewQRCodeImage() {
				this.$func.previewQRCodeImage()
			},

			// 弹出模态框
			showModal(event) {
				this.openModal()
			},
			// 打开模态框
			openModal() {
				this.show1 = true
			},
		}
	}
</script>

<style lang="scss" scoped>
	@import "@/scss/custom_nav_bar.scss";

	/* 间隔线 start*/
	.tn-strip-bottom-min {
		width: 100%;
		// border-bottom: 1rpx solid #F8F9FB;
	}

	.tn-strip-top {
		width: 100%;
		border-top: 20rpx solid rgba(241, 241, 241, 0.8);
	}

	/* 间隔线 end*/

	/* 毛玻璃*/
	.dd-glass {
		width: 100%;
		backdrop-filter: blur(20rpx);
		-webkit-backdrop-filter: blur(20rpx);
	}


	/* 用户头像 start */
	.user-image {
		width: 90rpx;
		height: 90rpx;
		position: relative;
	}

	.user-pic {
		background-size: cover;
		background-repeat: no-repeat;
		// background-attachment:fixed;
		background-position: top;
		border-radius: 50%;
		overflow: hidden;
		background-color: #FFFFFF;
	}

	/* 底部悬浮按钮 start*/
	.tn-tabbar-height {
		min-height: 120rpx;
		height: calc(140rpx + env(safe-area-inset-bottom) / 2);
		height: calc(140rpx + constant(safe-area-inset-bottom));
	}

	.tn-footerfixed {
		position: fixed;
		background-color: rgba(255, 255, 255, 0.5);
		box-shadow: 0rpx 0rpx 30rpx 0rpx rgba(0, 0, 0, 0.07);
		bottom: 0;
		width: 100%;
		transition: all 0.25s ease-out;
		z-index: 100;
	}
</style>