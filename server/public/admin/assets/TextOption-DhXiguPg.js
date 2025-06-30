import{h as _,B as x}from"./element-plus-BOMqSMu4.js";import{e as f}from"./tenant_exam_question-B2Ksr1j0.js";import{d as y,Z as w,o as V,c as v,a as o,V as e,M as n,S as a,u as s}from"./@vue-DWQ9eUI2.js";import{d as b}from"./index-D26yx8rh.js";import"./lodash-es-ConpBW6D.js";import"./async-validator-DKvM95Vc.js";import"./@element-plus-t6vcCXyq.js";import"./dayjs-CMfar2R3.js";import"./balanced-match-mNcR6oh4.js";import"./@popperjs-D9SI2xQl.js";import"./@ctrl-r5W6hzzQ.js";import"./normalize-wheel-es-B6fDCfyv.js";import"./nprogress-Cgf5DU8x.js";import"./vue-router-kfoHscKg.js";import"./pinia-xIQONLba.js";import"./axios-C-n2IhIP.js";import"./lodash-BtPWuHkK.js";import"./@vueuse-BGJqEudt.js";import"./css-color-function-rJvg8h-6.js";import"./color-B0v57BL7.js";import"./clone-CuIhj1wH.js";import"./color-convert-BGgJB5UM.js";import"./color-name-BQ5IbGbl.js";import"./color-string-BhgG7-8u.js";import"./ms-CzQ2E3wO.js";import"./vue-clipboard3-8CNoFg4V.js";import"./clipboard-Dch_ozqB.js";import"./echarts-BR_QmBtV.js";import"./tslib-BDyQ-Jie.js";import"./zrender-B-CeXLwU.js";import"./highlight.js-BEPSbOJo.js";import"./@highlightjs-DFNU4Zg1.js";const B={class:"margin-bottom20",style:{display:"flex"}},h={style:{width:"50%"}},A={class:"tip-head-title"},g={style:{width:"50%","padding-left":"20px"}},k={class:"tip-head-title"},C={class:"display-flex-start-center"},d=`下面是文本录入的试题格式，目前只支持单选题、多选题和判断题。每一道试题之间，需要换行。

题目：下列属于行政行为的是（ ）
A. 某县民政局建办公楼的行为
B. 某县民政局起诉建筑公司违约的行为
C. 某县民政局越权处罚违约的建筑公司的行为
D. 某县民政局依建筑合同奖励建筑公司的行为
答案：A
题型：单选题
解释：行政行为是指行政主体行使行政职权，作出的能够产生行政法律效果的行为。。

题目：下列属于行政行为的是（ ）
A. 某县民政局建办公楼的行为
B. 某县民政局起诉建筑公司违约的行为
C. 某县民政局越权处罚违约的建筑公司的行为
D. 某县民政局依建筑合同奖励建筑公司的行为
答案：A、B
题型：多选题
解释：行政行为是指行政主体行使行政职权，作出的能够产生行政法律效果的行为。。

题目：夏天小孩适合在河塘中游泳（ ）
A. 正确
B. 错误
答案：A
题型：判断题
解释：河塘水深，小孩应原理河塘。
`,T=y({__name:"TextOption",props:{libraryUid:{}},setup(u){const i=w({chapter_uid:"",tenant_exam_library_uid:u.libraryUid,content:""}),c=async()=>{const m={...i};await f(m)};return(m,t)=>{const r=_,l=x;return V(),v("div",null,[o("div",B,[o("div",h,[o("div",A,[e(r,{type:"primary",icon:"InfoFilled",link:"",disabled:""},{default:n(()=>t[2]||(t[2]=[a("编辑区")])),_:1})]),e(l,{type:"textarea",modelValue:s(i).content,"onUpdate:modelValue":t[0]||(t[0]=p=>s(i).content=p),autosize:{minRows:40,maxRows:40},placeholder:d,resize:"none","show-word-limit":!0,maxlength:"65535"},null,8,["modelValue"])]),o("div",g,[o("div",k,[e(r,{type:"primary",icon:"View",link:"",disabled:""},{default:n(()=>t[3]||(t[3]=[a("预览区")])),_:1})]),e(l,{type:"textarea",modelValue:s(i).content,"onUpdate:modelValue":t[1]||(t[1]=p=>s(i).content=p),autosize:{minRows:40,maxRows:40},placeholder:d,resize:"none","show-word-limit":!0,maxlength:"65535",disabled:!0},null,8,["modelValue"])])]),o("div",C,[e(r,{type:"primary",onClick:c},{default:n(()=>t[4]||(t[4]=[a("保存试题")])),_:1}),e(r,{type:"warning"},{default:n(()=>t[5]||(t[5]=[a("重置数据")])),_:1})])])}}}),pt=b(T,[["__scopeId","data-v-ab403c80"]]);export{pt as default};
