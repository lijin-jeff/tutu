import commonApi from './api/common.js'
import collectionApi from './api/collection'
import resourceApi from './api/resource.js'
import courseApi from './api/course.js'
import articleApi from './api/article.js'
import documentApi from './api/document.js'
import shopApi from './api/shop.js'
import userApi from './api/user.js'

export default {
	...commonApi,
	...collectionApi,
	...resourceApi,
	...courseApi,
	...documentApi,
	...articleApi,
	...shopApi,
	...userApi
}