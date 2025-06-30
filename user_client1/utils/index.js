import commonApi from './api/common.js'
import orderApi from './api/order'
import resourceApi from './api/resource.js'
import courseApi from './api/course.js'
import articleApi from './api/article.js'
import documentApi from './api/document.js'
import shopApi from './api/shop.js'
import userApi from './api/user.js'
import examApi from './api/exam.js'
import scoreApi from './api/score.js'

export default {
	...commonApi,
	...examApi,
	...orderApi,
	...resourceApi,
	...courseApi,
	...documentApi,
	...articleApi,
	...shopApi,
	...userApi,
	...scoreApi
}