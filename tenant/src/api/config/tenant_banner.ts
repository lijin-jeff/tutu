import request from '@/utils/request'

// 轮播图管理列表
export function apiTenantBannerLists(params: any) {
    return request.get({ url: '/config.tenant_banner/lists', params })
}

// 添加轮播图管理
export function apiTenantBannerAdd(params: any) {
    return request.post({ url: '/config.tenant_banner/add', params })
}

// 编辑轮播图管理
export function apiTenantBannerEdit(params: any) {
    return request.post({ url: '/config.tenant_banner/edit', params })
}

// 删除轮播图管理
export function apiTenantBannerDelete(params: any) {
    return request.post({ url: '/config.tenant_banner/delete', params })
}

// 轮播图管理详情
export function apiTenantBannerDetail(params: any) {
    return request.get({ url: '/config.tenant_banner/detail', params })
}