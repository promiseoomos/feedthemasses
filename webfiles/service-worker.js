if(!self.define){let e,s={};const l=(l,r)=>(l=new URL(l+".js",r).href,s[l]||new Promise((s=>{if("document"in self){const e=document.createElement("script");e.src=l,e.onload=s,document.head.appendChild(e)}else e=l,importScripts(l),s()})).then((()=>{let e=s[l];if(!e)throw new Error(`Module ${l} didn’t register its module`);return e})));self.define=(r,i)=>{const n=e||("document"in self?document.currentScript.src:"")||location.href;if(s[n])return;let o={};const u=e=>l(e,n),t={module:{uri:n},exports:o,require:u};s[n]=Promise.all(r.map((e=>t[e]||u(e)))).then((e=>(i(...e),o)))}}define(["./workbox-2d118ab0"],(function(e){"use strict";e.setCacheNameDetails({prefix:"feedthemasses"}),self.addEventListener("message",(e=>{e.data&&"SKIP_WAITING"===e.data.type&&self.skipWaiting()})),e.precacheAndRoute([{url:"/css/app.de46bb38.css",revision:null},{url:"/index.html",revision:"0b883e49c5811e26216b8e12fbe493d1"},{url:"/js/105.e34ad8f5.js",revision:null},{url:"/js/13.00ad6333.js",revision:null},{url:"/js/178.e44160bb.js",revision:null},{url:"/js/270.67754f68.js",revision:null},{url:"/js/449.04879c88.js",revision:null},{url:"/js/711.a4d79439.js",revision:null},{url:"/js/768.7700ba06.js",revision:null},{url:"/js/797.8d3d4fcb.js",revision:null},{url:"/js/about.718448da.js",revision:null},{url:"/js/app.ea93aa45.js",revision:null},{url:"/js/chunk-vendors.873cd1d8.js",revision:null},{url:"/manifest.json",revision:"98db6bbea5fec550e18cc69936dc686d"},{url:"/robots.txt",revision:"b6216d61c03e6ce0c9aea6ca7808f7ca"}],{})}));
//# sourceMappingURL=service-worker.js.map
