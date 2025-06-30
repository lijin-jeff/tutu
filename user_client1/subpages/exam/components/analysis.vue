<template>
	<view>
		<tn-popup v-model="show" mode="bottom" height="40%" :safeAreaInsetBottom="true"
			borderRadius="30" @close="closePop">
			<view class="exam-count-info tn-flex">
				<view class="tn-padding tn-text-bold">{{title}}</view>
			</view>
			<view class="options tn-padding-left tn-padding-right tn-padding-bottom">
				<mp-html :selectable="true" :content="content"></mp-html>
			</view>
		</tn-popup>
	</view>
</template>

<script>
	export default {
		name: "analysis",
		props: {
			content: {
				type: String,
				required: true,
			},
			showPop: {
				type: Boolean,
				default: false,
				required: true
			},
			showTitle: {
				type: String,
				default: '试题解析',
				required: false,
			}
		},
		data() {
			return {
				show: false,
				title: '试题解析'
			}
		},
		watch: {
			// 单独用创建一个变量并且用监听器监听父组件传递过来的属性
			// 这样做是为了解决，子组件内部修改父组件传递过来的属性，在vue中会报错
			// 当父组件传递值过来后，监听器会监听到prop属性发生变化，此时就去修改data的值
			showPop(newValue, oldValue) {
				this.show = newValue
			},
			showTitle(newValue, oldValue) {
				this.title = newValue
			},
		},
		methods: {
			closePop() {
				this.$emit('close')
			},
		},
	}
</script>

<style scoped lang="scss">
</style>