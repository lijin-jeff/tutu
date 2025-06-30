<template>
	<view class="tn-safe-area-inset-bottom">
		<!-- 顶部自定义导航 -->
		<tn-nav-bar fixed customBack :backgroundColor="mainColor">
			<view slot="back" class='tn-custom-nav-bar__back'>
				<text class='icon tn-icon-left'  @click="goBack"></text>
				<text class='icon tn-icon-home-capsule-fill'  @click="goHome"></text>
			</view>
			<view class="tn-flex tn-flex-col-center tn-flex-row-center ">
				<text class="tn-text-bold tn-text-xl tn-color-white">资料设置</text>
			</view>
		</tn-nav-bar>

		<view class="tn-margin-top" :style="{paddingTop: vuex_custom_bar_height + 'px'}">
			<!-- 这个是图鸟UI响应用户需求，推出的一个uni_modules组件，插件市场点击右上角，导入即可 https://ext.dcloud.net.cn/plugin?id=10172 -->
			<wx-user-info-modal v-model="showAuthorizationModal" @updated="updatedUserInfoEvent"></wx-user-info-modal>

			<view class="tn-flex tn-flex-row-between tn-strip-bottom tn-padding" @tap.stop="openAuthorizationModal">
				<view class="justify-content-item">
					<view class="tn-text-bold tn-text-lg">
						{{userInfo.nickname || ""}}
					</view>
					<view class="tn-color-gray tn-padding-top-xs">
						{{userInfo.remark || ""}}
					</view>
				</view>
				<view class="justify-content-item tn-text-lg tn-color-grey">
					<view class="logo-pic tn-shadow">
						<view class="logo-image">
							<view class="tn-shadow-blur"
								:style="'background-image:url('+ userInfo.avatar +');width: 80rpx;height: 80rpx;background-size: cover;'">
							</view>
						</view>
					</view>
				</view>
			</view>
		</view>

		<!-- 修改个人备注开始 -->
		<view class="tn-flex tn-flex-row-between tn-strip-bottom-min tn-padding" @click="showUserReamrk">
			<view class="justify-content-item">
				<view class="tn-color-gray tn-padding-top-xs">
					{{userInfo.remark || ""}}
				</view>
			</view>
			<view class="justify-content-item tn-text-lg tn-color-grey">
				<view class="tn-icon-right tn-padding-top"></view>
			</view>
		</view>
		<!-- 修改个人备注结束 -->

		<!-- 修改个人备注弹窗开始 -->
		<tn-modal v-model="showRemark" :custom="true" :showCloseBtn="true">
			<view class="custom-modal-content">
				<view class="">
					<view class="tn-text-lg tn-text-bold tn-text-center tn-padding" :style="{color: mainColor}">请填写个人备注</view>
					<view class="tn-bg-gray--light" style="border-radius: 10rpx;padding: 20rpx 30rpx;margin: 50rpx 0 60rpx 0;">
						<textarea placeholder="请输入个人备注" name="input" :value="userInfo.remark" @input="inputUserReamrk" placeholder-style="color:#AAAAAA"
							maxlength="32" style="width: 100%;height: 100rpx;"></textarea>
					</view>
				</view>
				<view class="tn-flex-1 justify-content-item tn-margin-sm tn-text-center">
					<tn-button :backgroundColor="mainColor" padding="40rpx 0" width="60%" fontBold @click="closeUserReamrk">
						<text class="tn-color-white">保 存</text>
					</tn-button>
				</view>
			</view>
		</tn-modal>
		<!-- 修改个人备注弹窗结束 -->


		<!-- 性别修改开始 -->
		<picker @change="bindGenderChange" :value="index" :range="genderList">
			<view class="tn-flex tn-flex-row-between tn-strip-bottom-min tn-padding">
				<view class="justify-content-item">
					<view class="tn-text-bold tn-text-lg">
						*性别
					</view>
					<view class="tn-color-gray tn-padding-top-xs">
						<view class="tn-color-gray">{{genderList[userInfo.sex]}}</view>
					</view>
				</view>
				<view class="justify-content-item tn-text-lg tn-color-grey">
					<view class="tn-icon-right tn-padding-top"></view>
				</view>
			</view>
		</picker>
		<!-- 性别修改结束 -->


		<tn-button :backgroundColor="mainColor" margin="40rpx 2%" width="96%" fontBold height="80rpx" fontSize="30"
			@click="updateUserInfo">
			<text class="tn-color-white">更 新 信 息</text>
		</tn-button>
	</view>
	</view>
</template>

<script>
	import template_page_mixin from '@/libs/mixin/template_page_mixin.js'
	import WxUserInfoModal from '@/uni_modules/tuniaoui-wx-user-info/components/tuniaoui-wx-user-info/tuniaoui-wx-user-info.vue'
	export default {
		components: {
			WxUserInfoModal
		},
		name: 'TemplateSet',
		mixins: [template_page_mixin],
		data() {
			return {
				mainColor: getApp().globalData.mainColor,
				showAuthorizationModal: false,
				showRemark: false,
				show2: false,
				showNameModal: false,
				genderList: ['保密', '男', '女'],
				userInfo: {},
				startDate: '1990-00-00',
				endDate: '2099-07-25',
			}
		},
		onShow() {
			// this.getUserInfo()
		},
		onLoad() {
			// #ifdef MP-WEIXIN
			this.$t.mpShare = {
				share: false,
			}
			if (!this.$t.mpShare.share) {
				uni.hideShareMenu()
			}
			// #endif
		},
		methods: {
			// 获取用户专业配置表
			getUserProfession() {
				this.$api.apiGetUserProfessionList({}).then(res => {
					if (res.code == 100) {
						for (var i = 0; i < res.data.length; i++) {
							this.userProfessionList.push(res.data[i].title)
						}
						this.userProfession = res.data
						return
					}
					this.$func.showToast(res.msg)
				})
			},
			// 获取用户信息
			getUserInfo() {
				this.$api.apiGetUserBasicInfo().then(res => {
					this.userInfo = res.data
					uni.setStorageSync('avatar', res.data.avatar)
					uni.setStorageSync('nickname', res.data.nickname)
				})
			},
			// 更新用户信息
			updateUserInfo() {
				this.$api.apiUpdateUserBasicInfo(this.userInfo).then(res => {
					if (res.code === 100) {
						uni.setStorageSync("avatar", this.userInfo.avatar)
						uni.setStorageSync("nickname", this.userInfo.nickname)
						this.$func.showToast("更新成功")
						return
					}
					this.$func.showToast(res.msg)
				})
			},

			// 性别修改选择赋值
			bindGenderChange: function(e) {
				this.userInfo.sex = parseInt(e.detail.value)
			},


			// 修改个人备注弹窗
			showUserReamrk(event) {
				this.showRemark = true
			},

			// 关闭个人备注弹窗
			closeUserReamrk() {
				this.showRemark = false
			},

			// 个人备注输入监听
			inputUserReamrk(e) {
				if (e.detail.value.length > 32) {
					this.$func.showToast("备注长度不能超过32")
				}
				this.userInfo.remark = e.detail.value
			},

			// 打开获取用户信息弹框
			openAuthorizationModal() {
				this.showAuthorizationModal = true
			},

			// 上传用户头像
			updatedUserInfoEvent(info) {
				this.userInfo.nickname = info.nickname
				this.userInfo.avatar = info.avatar
				// 判断缓存头像和当前的头像是否一致，一致则不进行上传操作
				if (info.avatar === uni.getStorageSync('avatar')) {
					this.userInfo.avatar = uni.getStorageSync('avatar')
					this.showAuthorizationModal = false
					return
				}
				uni.showLoading({
					title: '头像上传中',
					mask: true,
				})
				this.$api.apiUploadImage(info.avatar).then(res => {
					if (res.code == 100) {
						this.userInfo.avatar = res.data.url
						this.showAuthorizationModal = false
					} else {
						this.$func.showToast('头像上传失败')
					}
					uni.hideLoading()
				})
			},
		}
	}
</script>

<style lang="scss" scoped>
	/* 胶囊*/
	.tn-custom-nav-bar__back {
		width: 100%;
		height: 100%;
		position: relative;
		display: flex;
		justify-content: space-evenly;
		align-items: center;
		box-sizing: border-box;
		background-color: rgba(0, 0, 0, 0.15);
		border-radius: 1000rpx;
		border: 1rpx solid rgba(255, 255, 255, 0.5);
		color: #FFFFFF;
		font-size: 18px;

		.icon {
			display: block;
			flex: 1;
			margin: auto;
			text-align: center;
		}

		&:before {
			content: " ";
			width: 1rpx;
			height: 110%;
			position: absolute;
			top: 22.5%;
			left: 0;
			right: 0;
			margin: auto;
			transform: scale(0.5);
			transform-origin: 0 0;
			pointer-events: none;
			box-sizing: border-box;
			opacity: 0.7;
			background-color: #FFFFFF;
		}
	}

	/* 授权 */
	.login-page {
		width: 100vw;
		height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	/* 授权按钮 */
	.submit-btn {
		width: 100%;
		background-color: #05C160;
		color: #FFFFFF;
		margin-top: 60rpx;
		border-radius: 10rpx;
		padding: 25rpx;
		font-size: 32rpx;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 30rpx;
	}

	/* 间隔线 start*/
	.tn-strip-bottom-min {
		width: 100%;
		border-bottom: 1rpx solid #F8F9FB;
	}

	.tn-strip-bottom {
		width: 100%;
		border-bottom: 20rpx solid rgba(241, 241, 241, 0.8);
	}

	/* 间隔线 end*/


	/* 用户头像 start */
	.logo-image {
		width: 80rpx;
		height: 80rpx;
		position: relative;
	}

	.logo-pic {
		background-size: cover;
		background-repeat: no-repeat;
		// background-attachment:fixed;
		background-position: top;
		border: 2rpx solid rgba(255, 255, 255, 0.05);
		box-shadow: 0rpx 0rpx 80rpx 0rpx rgba(0, 0, 0, 0.15);
		border-radius: 50%;
		overflow: hidden;
		// background-color: #FFFFFF;
	}


	/* 底部悬浮按钮 start*/
	.tn-tabbar-height {
		min-height: 100rpx;
		height: calc(120rpx + env(safe-area-inset-bottom) / 2);
	}

	.tn-footerfixed {
		position: fixed;
		width: 100%;
		bottom: calc(30rpx + env(safe-area-inset-bottom));
		z-index: 1024;
		box-shadow: 0 1rpx 6rpx rgba(0, 0, 0, 0);

	}

	/* 底部悬浮按钮 end*/
</style>