"use strict";(self["webpackChunksherlock_godjango_admin_ui"]=self["webpackChunksherlock_godjango_admin_ui"]||[]).push([[842],{8842:(e,t,l)=>{l.r(t),l.d(t,{default:()=>Q});var n=l(9835),o=l(499),a=l(6970),i=l(4587),u=l(4880),c=l(33),r=l(5304),d=l(8910),s=l(4072),m=function(e,t,l,n){function o(e){return e instanceof l?e:new l((function(t){t(e)}))}return new(l||(l=Promise))((function(l,a){function i(e){try{c(n.next(e))}catch(t){a(t)}}function u(e){try{c(n["throw"](e))}catch(t){a(t)}}function c(e){e.done?l(e.value):o(e.value).then(i,u)}c((n=n.apply(e,t||[])).next())}))};const p=(0,n._)("div",{class:"text-h6 text-center"},"Tarea Actual",-1),v=(0,n.aZ)({setup(e){delete i.Icon.Default.prototype._getIconUrl,i.Icon.Default.mergeOptions({iconRetinaUrl:l(2420),iconUrl:l(6667),shadowUrl:l(6458)});const t='&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a> contributors',v="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",f=(0,r.Ey)(r.cH),h=(0,d.tv)(),g=(0,n.Fl)((()=>f.assignments)),w=(0,o.iH)(c.he),k=(0,o.iH)(!1),y=(0,o.iH)([]),_=(0,o.iH)({multiple:!1,zoom:{max:18,min:8}}),b=(0,o.iH)(12);function W(e){e&&h.push({name:s.I.AGENT_CHECKPOINT,params:{id:e}})}function q(e){w.value=e}function C(e){b.value=e}function x(e){const t=y.value.findIndex((t=>{var l,n;return(null===(l=t.checkpoint)||void 0===l?void 0:l.id)===(null===(n=e.checkpoint)||void 0===n?void 0:n.id)}));t>=0&&(y.value[t].visible=!y.value[t].visible)}return(0,n.wF)((()=>m(this,void 0,void 0,(function*(){let e;yield f.listAssignments(),g.value.forEach((t=>{var l;(null===(l=t.checkpoints)||void 0===l?void 0:l.length)&&t.checkpoints.forEach((t=>{t.status||(e=(0,i.latLng)(t.position.lat,t.position.lng),e.checkpoint=t,e.visible=!0,y.value.push(e))}))}))})))),(e,l)=>{const i=(0,n.up)("q-card-section"),c=(0,n.up)("q-btn"),r=(0,n.up)("q-card"),d=(0,n.up)("q-item-label"),s=(0,n.up)("q-item-section"),m=(0,n.up)("q-icon"),f=(0,n.up)("q-item"),h=(0,n.up)("q-list"),g=(0,n.up)("q-card-actions"),z=(0,n.up)("q-dialog"),U=(0,n.up)("q-page"),Z=(0,n.Q2)("close-popup");return(0,n.wg)(),(0,n.j4)(U,{padding:""},{default:(0,n.w5)((()=>[(0,n.Wm)(r,{class:"full-width",style:{height:"80vh"}},{default:(0,n.w5)((()=>[(0,n.Wm)(i,{class:"q-pa-xs"},{default:(0,n.w5)((()=>[p])),_:1}),((0,n.wg)(),(0,n.j4)((0,o.SU)(u.iA),{ref:"map",id:"map--page-managerleaflet",class:"full-heigth",zoom:Number(b.value),center:w.value,"min-zoom":_.value.zoom.min,"max-zoom":_.value.zoom.max,"onUpdate:center":q,"onUpdate:zoom":C,key:`map-key-${b.value}-${w.value.lat}-${w.value.lng}`},{default:(0,n.w5)((()=>[(0,n.Wm)((0,o.SU)(u.Hw),{url:v,attribution:t}),y.value.length?((0,n.wg)(),(0,n.j4)((0,o.SU)(u.oJ),{key:0},{default:(0,n.w5)((()=>[(0,n.Wm)(c,{color:"white","text-color":"dark",icon:"mdi-eye",onClick:l[0]||(l[0]=e=>k.value=!0)})])),_:1})):(0,n.kq)("",!0),((0,n.wg)(!0),(0,n.iD)(n.HY,null,(0,n.Ko)(y.value,((e,t)=>((0,n.wg)(),(0,n.iD)(n.HY,{key:`marker-${t}`},[e.visible?((0,n.wg)(),(0,n.j4)((0,o.SU)(u.$R),{key:0,"lat-lng":e,onClick:t=>{var l;return W(null===(l=e.checkpoint)||void 0===l?void 0:l.id)}},null,8,["lat-lng","onClick"])):(0,n.kq)("",!0)],64)))),128))])),_:1},8,["zoom","center","min-zoom","max-zoom"]))])),_:1}),(0,n.Wm)(z,{modelValue:k.value,"onUpdate:modelValue":l[1]||(l[1]=e=>k.value=e)},{default:(0,n.w5)((()=>[(0,n.Wm)(r,{class:"no-box-shadow",style:{"min-width":"20rem"}},{default:(0,n.w5)((()=>[(0,n.Wm)(i,null,{default:(0,n.w5)((()=>[(0,n.Wm)(h,{bordered:""},{default:(0,n.w5)((()=>[((0,n.wg)(!0),(0,n.iD)(n.HY,null,(0,n.Ko)(y.value,((e,t)=>{var l;return(0,n.wg)(),(0,n.j4)(f,{key:`mlistas-${null===(l=e.checkpoint)||void 0===l?void 0:l.id}-key-${t}`},{default:(0,n.w5)((()=>[(0,n.Wm)(s,null,{default:(0,n.w5)((()=>[(0,n.Wm)(d,null,{default:(0,n.w5)((()=>{var t;return[(0,n.Uk)((0,a.zw)(null===(t=e.checkpoint)||void 0===t?void 0:t.name),1)]})),_:2},1024),(0,n.Wm)(d,{caption:"",lines:"2"},{default:(0,n.w5)((()=>{var t;return[(0,n.Uk)((0,a.zw)(0===(null===(t=e.checkpoint)||void 0===t?void 0:t.status)?"Pendiente":"Completado"),1)]})),_:2},1024)])),_:2},1024),(0,n.Wm)(s,{avatar:"",onClick:t=>x(e)},{default:(0,n.w5)((()=>[(0,n.Wm)(m,{color:"primary",name:e.visible?"mdi-eye":"mdi-eye-off"},null,8,["name"])])),_:2},1032,["onClick"])])),_:2},1024)})),128))])),_:1})])),_:1}),(0,n.Wm)(g,{align:"right"},{default:(0,n.w5)((()=>[(0,n.wy)((0,n.Wm)(c,{flat:"",label:"Aceptar",color:"primary"},null,512),[[Z]])])),_:1})])),_:1})])),_:1},8,["modelValue"])])),_:1})}}});var f=l(9885),h=l(4458),g=l(3190),w=l(4455),k=l(2074),y=l(3246),_=l(490),b=l(1233),W=l(3115),q=l(2857),C=l(1821),x=l(2146),z=l(9984),U=l.n(z);const Z=v,Q=Z;U()(v,"components",{QPage:f.Z,QCard:h.Z,QCardSection:g.Z,QBtn:w.Z,QDialog:k.Z,QList:y.Z,QItem:_.Z,QItemSection:b.Z,QItemLabel:W.Z,QIcon:q.Z,QCardActions:C.Z}),U()(v,"directives",{ClosePopup:x.Z})}}]);