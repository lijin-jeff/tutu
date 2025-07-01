import request from '@/utils/request'

// 试题分类列表
export function apiExamCategoryLists(params: any) {
    return request.get({ url: '/exam.exam_category/lists', params })
}

// 添加试题分类
export function apiExamCategoryAdd(params: any) {
    return request.post({ url: '/exam.exam_category/add', params })
}

// 编辑试题分类
export function apiExamCategoryEdit(params: any) {
    return request.post({ url: '/exam.exam_category/edit', params })
}

// 删除试题分类
export function apiExamCategoryDelete(params: any) {
    return request.post({ url: '/exam.exam_category/delete', params })
}

// 试题分类详情
export function apiExamCategoryDetail(params: any) {
    return request.get({ url: '/exam.exam_category/detail', params })
}

// 试题分类父级列表
export function apiExamCategoryParent() {
    return request.get({ url: '/exam.exam_category/parentList' })
}

// 试题分类树
export function apiExamCategoryTree() {
    return request.get({ url: '/exam.exam_category/categoryTree' })
}
