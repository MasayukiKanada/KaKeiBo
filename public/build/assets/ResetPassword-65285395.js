import{o as c,c as f,w as n,a as o,u as e,b as t,d as w,n as _,e as V}from"./app-6f4a4b14.js";import{_ as g}from"./GuestLayout-1e3c1ee9.js";import{_ as l,a as m,b as i}from"./TextInput-f460bfac.js";import{_ as b}from"./PrimaryButton-ffa46006.js";import{T as k,Z as v}from"./index.esm-07391a9d.js";import"./ApplicationLogoS-f240c343.js";const x={class:"mt-4"},y={class:"mt-4"},P={class:"flex items-center justify-end mt-4"},U={__name:"ResetPassword",props:{email:String,token:String},setup(p){const d=p,s=k({token:d.token,email:d.email,password:"",password_confirmation:""}),u=()=>{s.post(route("password.store"),{onFinish:()=>s.reset("password","password_confirmation")})};return($,a)=>(c(),f(g,null,{default:n(()=>[o(e(v),{title:"Reset Password"}),t("form",{onSubmit:V(u,["prevent"])},[t("div",null,[o(l,{for:"email",value:"Email"}),o(m,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:e(s).email,"onUpdate:modelValue":a[0]||(a[0]=r=>e(s).email=r),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.email},null,8,["message"])]),t("div",x,[o(l,{for:"password",value:"Password"}),o(m,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:e(s).password,"onUpdate:modelValue":a[1]||(a[1]=r=>e(s).password=r),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.password},null,8,["message"])]),t("div",y,[o(l,{for:"password_confirmation",value:"Confirm Password"}),o(m,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:e(s).password_confirmation,"onUpdate:modelValue":a[2]||(a[2]=r=>e(s).password_confirmation=r),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.password_confirmation},null,8,["message"])]),t("div",P,[o(b,{class:_({"opacity-25":e(s).processing}),disabled:e(s).processing},{default:n(()=>a[3]||(a[3]=[w(" Reset Password ")])),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{U as default};
