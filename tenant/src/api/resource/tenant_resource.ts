import request from '@/utils/request'

// 资源管理列表
export function apiTenantResourceLists(params: any) {
    return request.get({ url: '/resource.tenant_resource/lists', params })
}

// 添加资源管理
export function apiTenantResourceAdd(params: any) {
    return request.post({ url: '/resource.tenant_resource/add', params })
}

// 编辑资源管理
export function apiTenantResourceEdit(params: any) {
    return request.post({ url: '/resource.tenant_resource/edit', params })
}

// 删除资源管理
export function apiTenantResourceDelete(params: any) {
    return request.post({ url: '/resource.tenant_resource/delete', params })
}

// 资源管理详情
export function apiTenantResourceDetail(params: any) {
    return request.get({ url: '/resource.tenant_resource/detail', params })
}