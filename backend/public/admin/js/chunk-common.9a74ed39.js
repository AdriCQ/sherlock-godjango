"use strict";(self["webpackChunksherlock_godjango_admin_ui"]=self["webpackChunksherlock_godjango_admin_ui"]||[]).push([[64],{685:(e,t,n)=>{n.d(t,{Z:()=>h});var a=n(9835),o=n(1957),l=n(499),i=n(33),s=n(5304),c=function(e,t,n,a){function o(e){return e instanceof n?e:new n((function(t){t(e)}))}return new(n||(n=Promise))((function(n,l){function i(e){try{c(a.next(e))}catch(t){l(t)}}function s(e){try{c(a["throw"](e))}catch(t){l(t)}}function c(e){e.done?n(e.value):o(e.value).then(i,s)}c((a=a.apply(e,t||[])).next())}))};const u=(0,a.aZ)({props:{assignment:null},emits:["complete","cancel"],setup(e,{emit:t}){const n=e,u=(0,s.Ey)(s.cH),r=(0,s.Ey)(s.VT),m=(0,l.Fl)((()=>{const e=u.availableAgents;return n.assignment&&n.assignment.agent&&e.unshift(n.assignment.agent),e})),d=(0,l.iH)();function p(){return c(this,void 0,void 0,(function*(){i.j7.loading();try{n.assignment?yield r.update(n.assignment.id,d.value):yield r.create(d.value),t("complete")}catch(e){i.j7.axiosError(e,"No se pudo guardar")}i.j7.loading(!1)}))}return(0,a.wF)((()=>c(this,void 0,void 0,(function*(){yield u.list(),n.assignment?d.value={agent_id:n.assignment.agent_id,description:n.assignment.description,event:n.assignment.event,name:n.assignment.name,observations:n.assignment.observations,status:n.assignment.status}:(d.value={agent_id:0,description:"",event:"",name:"",observations:"",status:0,checkpoints:[]},m.value.length&&(d.value.agent_id=m.value[0].id))})))),(e,t)=>{const n=(0,a.up)("q-input"),i=(0,a.up)("q-select"),s=(0,a.up)("q-card-section"),c=(0,a.up)("q-btn"),u=(0,a.up)("q-card-actions"),r=(0,a.up)("q-form"),g=(0,a.up)("q-card");return(0,a.wg)(),(0,a.j4)(g,null,{default:(0,a.w5)((()=>[d.value?((0,a.wg)(),(0,a.j4)(r,{key:0,onSubmit:(0,o.iM)(p,["prevent"])},{default:(0,a.w5)((()=>[(0,a.Wm)(s,{class:"q-gutter-y-sm"},{default:(0,a.w5)((()=>[(0,a.Wm)(n,{modelValue:d.value.name,"onUpdate:modelValue":t[0]||(t[0]=e=>d.value.name=e),type:"text",label:"Nombre"},null,8,["modelValue"]),(0,a.Wm)(n,{modelValue:d.value.event,"onUpdate:modelValue":t[1]||(t[1]=e=>d.value.event=e),type:"text",label:"Evento"},null,8,["modelValue"]),(0,a.Wm)(n,{modelValue:d.value.description,"onUpdate:modelValue":t[2]||(t[2]=e=>d.value.description=e),type:"textarea",label:"Descripción"},null,8,["modelValue"]),(0,a.Wm)(n,{modelValue:d.value.observations,"onUpdate:modelValue":t[3]||(t[3]=e=>d.value.observations=e),type:"textarea",label:"Observación"},null,8,["modelValue"]),(0,a.Wm)(i,{modelValue:d.value.agent_id,"onUpdate:modelValue":t[4]||(t[4]=e=>d.value.agent_id=e),options:(0,l.SU)(m),label:"Agente","map-options":"","emit-value":"","option-label":"nick","option-value":"id"},null,8,["modelValue","options"])])),_:1}),(0,a.Wm)(u,null,{default:(0,a.w5)((()=>[(0,a.Wm)(c,{class:"full-width",type:"submit",color:"primary",label:"Guardar"})])),_:1})])),_:1},8,["onSubmit"])):(0,a.kq)("",!0)])),_:1})}}});var r=n(4458),m=n(8326),d=n(3190),p=n(6611),g=n(215),v=n(1821),f=n(4455),k=n(9984),b=n.n(k);const w=u,h=w;b()(u,"components",{QCard:r.Z,QForm:m.Z,QCardSection:d.Z,QInput:p.Z,QSelect:g.Z,QCardActions:v.Z,QBtn:f.Z})},2304:(e,t,n)=>{n.d(t,{Z:()=>b});var a=n(9835),o=n(6970),l=n(4072),i=n(8910);const s={class:"text-body1"},c={class:"text-subtitle2"},u={class:"text-subtitle2"},r=(0,a.aZ)({props:{assignment:null,asAgent:{type:Boolean}},setup(e){const t=e,n=(0,i.tv)();function r(e){n.push({name:t.asAgent?l.I.AGENT_ASSIGNMENT:l.I.ADMIN_ASSIGNMENT,params:{id:e}})}return(e,n)=>{const l=(0,a.up)("q-icon"),i=(0,a.up)("q-chip"),m=(0,a.up)("q-card-section"),d=(0,a.up)("q-card");return(0,a.wg)(),(0,a.j4)(d,{class:"cursor-pointer",onClick:n[0]||(n[0]=e=>r(t.assignment.id))},{default:(0,a.w5)((()=>[(0,a.Wm)(m,null,{default:(0,a.w5)((()=>{var e;return[(0,a._)("div",s,(0,o.zw)(t.assignment.name),1),(0,a._)("div",c,[(0,a.Wm)(l,{name:"mdi-account",class:"q-mr-sm"}),(0,a.Uk)((0,o.zw)(null===(e=t.assignment.agent)||void 0===e?void 0:e.nick),1)]),(0,a._)("div",u,[(0,a.Wm)(i,{class:"glossy",icon:t.assignment.status?"mdi-check":"mdi-clock",label:t.assignment.status?"Completado":"En Progreso"},null,8,["icon","label"])])]})),_:1})])),_:1})}}});var m=n(4458),d=n(3190),p=n(2857),g=n(7691),v=n(9984),f=n.n(v);const k=r,b=k;f()(r,"components",{QCard:m.Z,QCardSection:d.Z,QIcon:p.Z,QChip:g.Z})},3890:(e,t,n)=>{n.d(t,{Z:()=>x});var a=n(9835),o=n(6970),l=n(499),i=n(33),s=n(5304),c=function(e,t,n,a){function o(e){return e instanceof n?e:new n((function(t){t(e)}))}return new(n||(n=Promise))((function(n,l){function i(e){try{c(a.next(e))}catch(t){l(t)}}function s(e){try{c(a["throw"](e))}catch(t){l(t)}}function c(e){e.done?n(e.value):o(e.value).then(i,s)}c((a=a.apply(e,t||[])).next())}))};const u={class:"text-subtitle2 absolute-top-right"},r={class:"text-subtitle2"},m={class:"text-subtitle2"},d={class:"text-subtitle2"},p={class:"text-subtitle2"},g={class:"text-subtitle2"},v=(0,a.aZ)({props:{event:null,advanced:{type:Boolean},editable:{type:Boolean}},emits:["request-complete"],setup(e,{emit:t}){const n=e,v=(0,i.GZ)(),f=(0,a.Fl)((()=>{switch(n.event.type){case"danger":return{bg:"bg-negative",icon:"mdi-alert-outline"};case"warning":return{bg:"bg-warning",icon:"mdi-alert-box"};default:return{bg:"bg-info",icon:"mdi-information-outline"}}}));function k(){n.editable&&"onprogress"===n.event.status&&v.deleteDialog({message:"Cambiar a Completeado",title:"Cambiar estado",onOk:()=>c(this,void 0,void 0,(function*(){try{yield s.ID.update(n.event.id,{status:"completed"})}catch(e){i.j7.axiosError(e)}}))})}return(e,i)=>{const s=(0,a.up)("q-chip"),c=(0,a.up)("q-icon"),v=(0,a.up)("q-card-section"),b=(0,a.up)("q-btn"),w=(0,a.up)("q-card-actions"),h=(0,a.up)("q-card");return(0,a.wg)(),(0,a.j4)(h,null,{default:(0,a.w5)((()=>[(0,a.Wm)(v,{class:(0,o.C_)(`${(0,l.SU)(f).bg} q-pa-sm`)},{default:(0,a.w5)((()=>[(0,a._)("div",u,[(0,a.Wm)(s,{clickable:"",onClick:k,class:"glossy",color:"completed"===n.event.status?"positive":"","text-color":"completed"===n.event.status?"white":"",icon:"completed"===n.event.status?"mdi-check":"mdi-clock",label:"completed"===n.event.status?"Resuelto":"Pendiente"},null,8,["color","text-color","icon","label"])]),(0,a.Wm)(c,{color:"dark",size:"sm",name:(0,l.SU)(f).icon},null,8,["name"])])),_:1},8,["class"]),(0,a.Wm)(v,null,{default:(0,a.w5)((()=>{var e;return[(0,a._)("div",r,[(0,a.Wm)(c,{name:"mdi-account",class:"q-mr-sm"}),(0,a.Uk)(" "+(0,o.zw)(null===(e=n.event.agent)||void 0===e?void 0:e.nick),1)]),(0,a._)("div",m,(0,o.zw)(n.event.details),1)]})),_:1}),n.advanced?((0,a.wg)(),(0,a.iD)(a.HY,{key:0},[(0,a.Wm)(v,null,{default:(0,a.w5)((()=>{var e;return[(0,a._)("div",d,[(0,a.Wm)(c,{name:"mdi-account",class:"q-mr-sm"}),(0,a.Uk)(" Agente: "+(0,o.zw)(null===(e=n.event.agent)||void 0===e?void 0:e.nick),1)]),(0,a._)("div",p,[(0,a.Wm)(c,{name:"mdi-clock-in",class:"q-mr-sm"}),(0,a.Uk)(" Fecha Creación: "+(0,o.zw)(new Date(n.event.created_at).toLocaleDateString()),1)]),(0,a._)("div",g,[(0,a.Wm)(c,{name:"mdi-clock-out",class:"q-mr-sm"}),(0,a.Uk)(" Fecha Actualización: "+(0,o.zw)(new Date(n.event.updated_at).toLocaleDateString()),1)])]})),_:1}),"completed"!==n.event.status?((0,a.wg)(),(0,a.j4)(w,{key:0},{default:(0,a.w5)((()=>[(0,a.Wm)(b,{color:"primary",icon:"mdi-check",label:"Completar",onClick:i[0]||(i[0]=e=>t("request-complete"))})])),_:1})):(0,a.kq)("",!0)],64)):(0,a.kq)("",!0)])),_:1})}}});var f=n(4458),k=n(3190),b=n(7691),w=n(2857),h=n(1821),y=n(4455),_=n(9984),C=n.n(_);const q=v,x=q;C()(v,"components",{QCard:f.Z,QCardSection:k.Z,QChip:b.Z,QIcon:w.Z,QCardActions:h.Z,QBtn:y.Z})},28:(e,t,n)=>{n.d(t,{Z:()=>u});var a=n(9835),o=n(499),l=n(4587),i=n(4880);const s=(0,a.aZ)({props:{markers:{default:()=>[]},settings:{default:()=>({multiple:!1,zoom:{max:18,min:10}})},mapClickFn:null,readonly:{type:Boolean,default:!1},center:{default:()=>(0,l.latLng)(0,0)},zoom:{default:16},markerClickFn:null},emits:["add-marker","update-center","update-zoom"],setup(e,{emit:t}){const s=e;delete l.Icon.Default.prototype._getIconUrl,l.Icon.Default.mergeOptions({iconRetinaUrl:n(2420),iconUrl:n(6667),shadowUrl:n(6458)});const c='&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a> contributors',u="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{markers:r,settings:m}=(0,o.BK)(s);function d(e){if(s.mapClickFn)s.mapClickFn(e);else{if(s.readonly)return;e.latlng&&t("add-marker",e.latlng)}}function p(e,t){s.markerClickFn&&s.markerClickFn(e,t)}return(n,l)=>((0,a.wg)(),(0,a.j4)((0,o.SU)(i.iA),{ref:"map",id:"map--pageleaflet",class:"full-heigth",zoom:Number(e.zoom),center:e.center,"min-zoom":(0,o.SU)(m).zoom.min,"max-zoom":(0,o.SU)(m).zoom.max,onClick:d,"onUpdate:center":l[0]||(l[0]=e=>t("update-center",e)),"onUpdate:zoom":l[1]||(l[1]=e=>t("update-zoom",e)),key:`map-key-${e.zoom}-${e.center.lat}-${e.center.lng}`},{default:(0,a.w5)((()=>[(0,a.Wm)((0,o.SU)(i.Hw),{url:u,attribution:c}),((0,a.wg)(!0),(0,a.iD)(a.HY,null,(0,a.Ko)((0,o.SU)(r),((e,t)=>((0,a.wg)(),(0,a.j4)((0,o.SU)(i.$R),{key:`marker-${t}`,"lat-lng":e,onClick:n=>p(e,t)},null,8,["lat-lng","onClick"])))),128))])),_:1},8,["zoom","center","min-zoom","max-zoom"]))}}),c=s,u=c}}]);