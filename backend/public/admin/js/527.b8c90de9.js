"use strict";(globalThis["webpackChunksherlock_godjango_admin_ui"]=globalThis["webpackChunksherlock_godjango_admin_ui"]||[]).push([[527],{2527:(e,a,l)=>{l.r(a),l.d(a,{default:()=>g});var o=l(9835),n=l(9302),u=l(33),d=l(5304),t=l(499),s=function(e,a,l,o){function n(e){return e instanceof l?e:new l((function(a){a(e)}))}return new(l||(l=Promise))((function(l,u){function d(e){try{s(o.next(e))}catch(a){u(a)}}function t(e){try{s(o["throw"](e))}catch(a){u(a)}}function s(e){e.done?l(e.value):n(e.value).then(d,t)}s((o=o.apply(e,a||[])).next())}))};const i=(0,o._)("div",{class:"text-h6"},"Perfil de Agente",-1),r=(0,o.aZ)({setup(e){const a=(0,d.Ey)(d.cH),l=(0,n.Z)(),r=(0,d.Ey)(d.Tc),c=(0,o.Fl)((()=>a.agent)),m=(0,t.iH)({email:"",name:"",address:"",nick:"",phone:"",password:""}),p=(0,o.Fl)((()=>r.profile));function v(){return s(this,void 0,void 0,(function*(){try{c.value&&(yield a.update(c.value.id,{nick:m.value.nick,address:m.value.address}),a.save(),u.j7.success(["Perfil Actualizado"]))}catch(e){u.j7.axiosError(e)}}))}function h(e){return s(this,void 0,void 0,(function*(){try{switch(e){case"email":r.profile=yield r.updateEmail(p.value.id,m.value.email);break;case"name":r.profile=yield r.update(p.value.id,{name:m.value.name});break;case"phone":r.profile=yield r.update(p.value.id,{phone:m.value.phone});break;case"password":l.dialog({title:"Cambiar Password",message:"¿Desea modificar la contraseña?",ok:"si",cancel:"no"}).onOk((()=>s(this,void 0,void 0,(function*(){r.profile=yield r.update(p.value.id,{password:m.value.password,password_confirmation:m.value.password}),r.save(),r.logout()}))));break;default:break}"password"!==e&&(r.save(),u.j7.success(["Perfil Actualizado"]))}catch(a){u.j7.axiosError(a)}}))}return(0,o.wF)((()=>{c.value&&(m.value={email:p.value.email,name:p.value.name,phone:p.value.phone,nick:c.value.nick,password:"",address:c.value.address})})),(e,a)=>{const l=(0,o.up)("q-card-section"),n=(0,o.up)("q-input"),u=(0,o.up)("q-card"),d=(0,o.up)("q-page");return(0,o.wg)(),(0,o.j4)(d,{padding:""},{default:(0,o.w5)((()=>[(0,o.Wm)(u,{class:"no-box-shadow",style:{"max-width":"25rem"}},{default:(0,o.w5)((()=>[(0,o.Wm)(l,null,{default:(0,o.w5)((()=>[i])),_:1}),(0,o.Wm)(l,{class:"q-gutter-y-sm"},{default:(0,o.w5)((()=>[(0,o.Wm)(n,{modelValue:m.value.name,"onUpdate:modelValue":a[0]||(a[0]=e=>m.value.name=e),type:"text",label:"Nombre",onChange:a[1]||(a[1]=e=>h("name"))},null,8,["modelValue"]),(0,o.Wm)(n,{modelValue:m.value.nick,"onUpdate:modelValue":a[2]||(a[2]=e=>m.value.nick=e),type:"text",label:"Nick",onChange:v},null,8,["modelValue"]),(0,o.Wm)(n,{modelValue:m.value.email,"onUpdate:modelValue":a[3]||(a[3]=e=>m.value.email=e),type:"email",label:"Email",onChange:a[4]||(a[4]=e=>h("email"))},null,8,["modelValue"]),(0,o.Wm)(n,{modelValue:m.value.phone,"onUpdate:modelValue":a[5]||(a[5]=e=>m.value.phone=e),type:"tel",label:"Telefono",onChange:a[6]||(a[6]=e=>h("phone"))},null,8,["modelValue"]),(0,o.Wm)(n,{modelValue:m.value.address,"onUpdate:modelValue":a[7]||(a[7]=e=>m.value.address=e),type:"text",label:"Direccion",onChange:v},null,8,["modelValue"]),(0,o.Wm)(n,{modelValue:m.value.password,"onUpdate:modelValue":a[8]||(a[8]=e=>m.value.password=e),type:"password",label:"Contraseña",onChange:a[9]||(a[9]=e=>h("password"))},null,8,["modelValue"])])),_:1})])),_:1})])),_:1})}}});var c=l(9885),m=l(4458),p=l(3190),v=l(6611),h=l(9984),f=l.n(h);const w=r,g=w;f()(r,"components",{QPage:c.Z,QCard:m.Z,QCardSection:p.Z,QInput:v.Z})}}]);