<template>
	<view class="nav-index-button" :style="{bottom: `${bottom}rpx`, right: `${right}rpx`}" @tap.stop="navTop">
		<view class="nav-index-button__content">
			<view
				class="nav-index-button__content--icon tn-flex tn-flex-row-center tn-flex-col-center tn-shadow-blur tn-bg-cyan tn-color-white">
				<view class="tn-icon-revoke"></view>
			</view>
		</view>

		<view class="nav-index-button__meteor">
			<view class="nav-index-button__meteor__wrapper">
				<view v-for="(item,index) in 6" :key="index" class="nav-index-button__meteor__item"
					:style="{transform: `rotateX(${-60 + (30 * index)}deg) rotateZ(${-60 + (30 * index)}deg)`}">
					<view class="nav-index-button__meteor__item--pic"></view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		name: 'nav-index-button',
		props: {
			// 距离底部的距离
			bottom: {
				type: [Number, String],
				default: 100
			},
			// 距离右边的距离
			right: {
				type: [Number, String],
				default: 60
			},
			url: {
				type: '',
				default: ''
			},
		},
		methods: {
			navTop() {
				console.log(this.url)
				if (this.url !== '') {
					this.$func.navigatorTo(this.url)
				} else {
					this.$func.tnHome()
				}
			}
		}
	}
</script>

<style lang="scss" scoped>
	.nav-index-button {
		position: fixed;
		animation: suspension 3s ease-in-out infinite;
		z-index: 999999;

		&__content {
			position: absolute;
			width: 100rpx;
			height: 100rpx;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);

			&--icon {
				width: 100rpx;
				height: 100rpx;
				font-size: 60rpx;
				border-radius: 50%;
				margin-bottom: 18rpx;
				position: relative;
				z-index: 1;
				transform: scale(0.85);

				&::after {
					content: " ";
					position: absolute;
					z-index: -1;
					width: 100%;
					height: 100%;
					left: 0;
					bottom: 0;
					border-radius: inherit;
					opacity: 1;
					transform: scale(1, 1);
					background-size: 100% 100%;
					background-image: url(https://tnuiimage.tnkjapp.com/cool_bg_image/icon_bg6.png);
				}
			}
		}

		&__meteor {
			position: absolute;
			top: 50%;
			left: 50%;
			width: 100rpx;
			height: 100rpx;
			transform-style: preserve-3d;
			transform: translate(-50%, -50%) rotateY(75deg) rotateZ(10deg);

			&__wrapper {
				width: 100rpx;
				height: 100rpx;
				transform-style: preserve-3d;
				animation: spin 20s linear infinite;
			}

			&__item {
				position: absolute;
				width: 100rpx;
				height: 100rpx;
				border-radius: 1000rpx;
				left: 0;
				top: 0;

				&--pic {
					display: block;
					width: 100%;
					height: 100%;
					background: url(https://tnuiimage.tnkjapp.com/cool_bg_image/arc3.png) no-repeat center center;
					background-size: 100% 100%;
					animation: arc 4s linear infinite;
				}
			}
		}
	}


	@keyframes suspension {

		0%,
		100% {
			transform: translateY(0);
		}

		50% {
			transform: translateY(-0.8rem);
		}
	}

	@keyframes spin {
		0% {
			transform: rotateX(0deg);
		}

		100% {
			transform: rotateX(-360deg);
		}
	}

	@keyframes arc {
		to {
			transform: rotate(360deg);
		}
	}
</style>