import{i as c,y as i,o as t,f as a,b as d,t as n,r as m,x as p,q as _}from"./app-6f4a4b14.js";const f={class:"text-sm text-red-600"},y={__name:"InputError",props:["message"],setup(e){return(o,s)=>c((t(),a("div",null,[d("p",f,n(e.message),1)],512)),[[i,e.message]])}},v={class:"block font-medium text-sm text-gray-700"},g={key:0},h={key:1},k={__name:"InputLabel",props:["value"],setup(e){return(o,s)=>(t(),a("label",v,[e.value?(t(),a("span",g,n(e.value),1)):(t(),a("span",h,[m(o.$slots,"default")]))]))}},x=["value"],$={__name:"TextInput",props:["modelValue"],emits:["update:modelValue"],setup(e,{expose:o}){const s=p(null);return _(()=>{s.value.hasAttribute("autofocus")&&s.value.focus()}),o({focus:()=>s.value.focus()}),(r,u)=>(t(),a("input",{class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm",value:e.modelValue,onInput:u[0]||(u[0]=l=>r.$emit("update:modelValue",l.target.value)),ref_key:"input",ref:s},null,40,x))}};export{k as _,$ as a,y as b};
