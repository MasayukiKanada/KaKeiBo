import{j as v,o as s,f as a,a as g,u as w,w as y,F as i,b as e,e as h,d as _,i as l,k as m,l as c,m as p,g as u,p as k,t as x}from"./app-6f4a4b14.js";import{_ as V}from"./AuthenticatedLayout-71d4442e.js";import{Z as C}from"./index.esm-07391a9d.js";import{_ as j}from"./ValidationErrors-8826aa86.js";import"./ApplicationLogoS-f240c343.js";const N={class:"py-12"},U={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},B={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},D={class:"p-6 text-gray-900"},M={class:"text-gray-500 body-font relative"},O={class:"container px-5 py-8 mx-auto"},S={class:"lg:w-2/3 md:w-4/5 mx-auto"},F={class:"flex flex-wrap -m-2"},T={class:"p-2 w-full"},$={class:"relative"},E=["value"],I={key:0,class:"p-2 w-full"},L={class:"relative"},Z=["value"],q={key:0,class:"p-2 w-full"},z={class:"relative"},A={key:1,class:"p-2 w-full"},G={class:"relative"},W={__name:"Create",props:{primary_categories:Object,secondary_categories:Object,errors:Object},setup(d){const o=v({primary_category_id:null,secondary_category_id:null,secondary_category_name:null,thirdry_category_name:null}),f=()=>{k.Inertia.post("/categories",o)},b=()=>{o.primary_category_id=null,o.secondary_category_id=null,o.secondary_category_name=null,o.thirdry_category_name=null};return(H,t)=>(s(),a(i,null,[g(w(C),{title:"カテゴリ作成"}),g(V,null,{header:y(()=>t[4]||(t[4]=[e("h2",{class:"font-semibold text-lg text-gray-500 leading-none"},"カテゴリ作成",-1)])),default:y(()=>[e("div",N,[e("div",U,[e("div",B,[e("div",D,[g(j,{errors:d.errors},null,8,["errors"]),e("section",M,[e("div",O,[e("form",{onSubmit:h(f,["prevent"])},[e("div",S,[e("div",F,[e("div",T,[e("div",$,[t[6]||(t[6]=e("label",{for:"primary_category",class:"leading-7 text-sm text-gray-500"},[_("収支区分"),e("span",{class:"text-red-500"},"※")],-1)),l(e("select",{id:"primary_category",name:"primary_category","onUpdate:modelValue":t[0]||(t[0]=r=>o.primary_category_id=r),class:"w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"},[t[5]||(t[5]=e("option",{value:null,disabled:""},"選択してください",-1)),(s(!0),a(i,null,c(d.primary_categories,r=>(s(),a("option",{value:r.id,key:r.id},x(r.name),9,E))),128))],512),[[m,o.primary_category_id]])])]),(s(!0),a(i,null,c(d.primary_categories,r=>(s(),a("div",null,[r.id===o.primary_category_id?(s(),a("div",I,[e("div",L,[t[8]||(t[8]=e("label",{for:"secondary_category",class:"leading-7 text-sm text-gray-500"},[_("大カテゴリ"),e("span",{class:"text-red-500"},"※"),e("span",{class:"text-red-500 text-xs"},"新規作成の場合は不要")],-1)),l(e("select",{id:"secondary_category",name:"secondary_category","onUpdate:modelValue":t[1]||(t[1]=n=>o.secondary_category_id=n),class:"w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"},[t[7]||(t[7]=e("option",{value:null},"選択してください／空白にする",-1)),(s(!0),a(i,null,c(r.secondary_category,n=>(s(),a("option",{value:n.id,key:n.id},x(n.name),9,Z))),128))],512),[[m,o.secondary_category_id]])])])):u("",!0)]))),256)),o.secondary_category_id==null?(s(),a("div",q,[e("div",z,[t[9]||(t[9]=e("label",{for:"secondary_category",class:"leading-7 text-sm text-gray-500"},"大カテゴリの新規作成",-1)),l(e("input",{placeholder:"作成する大カテゴリ名を入力してください",type:"text",id:"secondary_category",name:"secondary_category","onUpdate:modelValue":t[2]||(t[2]=r=>o.secondary_category_name=r),class:"w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"},null,512),[[p,o.secondary_category_name]])])])):u("",!0),o.secondary_category_id!==null||o.secondary_category_name!==null?(s(),a("div",A,[e("div",G,[t[10]||(t[10]=e("label",{for:"thirdry_category",class:"leading-7 text-sm text-gray-500"},"小カテゴリの新規作成",-1)),l(e("input",{placeholder:"作成する小カテゴリ名を入力してください",type:"text",id:"thirdry_category",name:"thirdry_category","onUpdate:modelValue":t[3]||(t[3]=r=>o.thirdry_category_name=r),class:"w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-500 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"},null,512),[[p,o.thirdry_category_name]])])])):u("",!0),e("div",{class:"p-2 w-full flex mt-10"},[t[11]||(t[11]=e("button",{class:"flex mx-auto text-white bg-indigo-500 border-0 py-2 sm:px-8 px-5 focus:outline-none hover:bg-indigo-600 rounded text-lg"},"作成する",-1)),e("button",{onClick:b,as:"button",class:"flex mx-auto text-white bg-green-500 border-0 py-2 sm:px-8 px-5 focus:outline-none hover:bg-green-600 rounded text-lg"},"入力の取消")])])])],32)])])])])])])]),_:1})],64))}};export{W as default};
