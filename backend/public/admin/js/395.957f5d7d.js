"use strict";(self["webpackChunksherlock_godjango_admin_ui"]=self["webpackChunksherlock_godjango_admin_ui"]||[]).push([[395],{4395:(e,l,n)=>{n.r(l),n.d(l,{default:()=>C});var t=n(9835),o=n(6970),a=n(499),u=n(3890),c=n(33),s=n(5304),i=function(e,l,n,t){function o(e){return e instanceof n?e:new n((function(l){l(e)}))}return new(n||(n=Promise))((function(n,a){function u(e){try{s(t.next(e))}catch(l){a(l)}}function c(e){try{s(t["throw"](e))}catch(l){a(l)}}function s(e){e.done?n(e.value):o(e.value).then(u,c)}s((t=t.apply(e,l||[])).next())}))};const d={class:"text-h6 text-center"},r={class:"text-subtitle text-center"},v={class:"row q-col-gutter-sm"},m=(0,t.aZ)({setup(e){const l=(0,s.Ey)(s.TM),n=(0,a.iH)(!0),m=(0,a.iH)(!1),p=(0,a.iH)(),f=(0,a.iH)([]),g=(0,t.Fl)((()=>n.value?l.events:f.value));function h(e){return i(this,void 0,void 0,(function*(){try{l.listOnProgress();const e=yield l.listCompleted();f.value=e}catch(n){c.j7.axiosError(n)}e()}))}function w(){return i(this,void 0,void 0,(function*(){if(p.value)try{yield l.update(p.value.id,{status:"completed"})}catch(e){c.j7.axiosError(e,"No se pudo guardar")}m.value=!1,p.value=void 0,h((()=>{console.log("Evento actualizado")}))}))}function k(e){p.value=e,m.value=!0}return(0,t.wF)((()=>{h((()=>{console.log("Events Page")}))})),(e,l)=>{const c=(0,t.up)("q-chip"),s=(0,t.up)("q-card-section"),i=(0,t.up)("q-card"),f=(0,t.up)("q-dialog"),h=(0,t.up)("q-page");return(0,t.wg)(),(0,t.j4)(h,{padding:""},{default:(0,t.w5)((()=>[(0,t.Wm)(i,{class:"no-box-shadow"},{default:(0,t.w5)((()=>[(0,t.Wm)(s,null,{default:(0,t.w5)((()=>[(0,t._)("div",d," Eventos "+(0,o.zw)(n.value?"Pendientes":"Resueltos"),1),(0,t._)("div",r,[(0,t.Wm)(c,{class:(0,o.C_)({glossy:n.value}),clickable:"",icon:"mdi-check",label:"Resueltos",onClick:l[0]||(l[0]=e=>n.value=!1)},null,8,["class"]),(0,t.Wm)(c,{class:(0,o.C_)({glossy:!n.value}),clickable:"",icon:"mdi-clock",label:"Pendientes",onClick:l[1]||(l[1]=e=>n.value=!0)},null,8,["class"])])])),_:1}),(0,t.Wm)(s,null,{default:(0,t.w5)((()=>[(0,t._)("div",v,[((0,t.wg)(!0),(0,t.iD)(t.HY,null,(0,t.Ko)((0,a.SU)(g),((e,l)=>((0,t.wg)(),(0,t.iD)("div",{class:"col-xs-12 col-sm-6 col-md-4",key:`event-solved-${e.id}-${l}`},[(0,t.Wm)(u.Z,{class:"cursor-pointer",event:e,onClick:l=>k(e)},null,8,["event","onClick"])])))),128))])])),_:1})])),_:1}),(0,t.Wm)(f,{modelValue:m.value,"onUpdate:modelValue":l[2]||(l[2]=e=>m.value=e)},{default:(0,t.w5)((()=>[p.value?((0,t.wg)(),(0,t.j4)(u.Z,{key:0,style:{"min-width":"20rem","max-width":"30rem"},event:p.value,advanced:"",onRequestComplete:w},null,8,["event"])):(0,t.kq)("",!0)])),_:1},8,["modelValue"])])),_:1})}}});var p=n(9885),f=n(4458),g=n(3190),h=n(7691),w=n(2074),k=n(9984),_=n.n(k);const y=m,C=y;_()(m,"components",{QPage:p.Z,QCard:f.Z,QCardSection:g.Z,QChip:h.Z,QDialog:w.Z})}}]);