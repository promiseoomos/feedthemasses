<template>
    <div class="overflow-auto">
        <div class="rounded-lg bg-white p-3">
            <div class="flex flex-wrap justify-center">
                <input type="number" v-model="voucher_count" class="p-3 border border-solid border-gray-400 rounded-md outline-none m-2 w-full lg:w-1/3">
                <button :disabled="generating" :class="{ 'bg-green-400' : generating }" class="w-full lg:w-1/2 p-3 rounded-md font-bold text-white text-md bg-green-700 m-2 hover:bg-green-500" @click="generateVoucher">Generate Vouchers</button>
            </div>
            <div v-if="generated" :class="{ 'text-green-600 bg-green-400/[0.4]' : generated }" class="min-h-20 w-full p-3 mb-3 rounded-md">
                {{ voucher_count }} {{ voucher_count > 1 ? 'Vouchers' : 'Voucher' }} has been successfully generated.
            </div>

            <div class="text-center mt-5">
                <a download :href="downloadurl" target="_blank" class="inline-block bg-emerald-700 hover:bg-emerald-500 p-3 text-white rounded-md w-3/5 mx-auto">Download Vouchers (Unused)</a>
            </div>
            <h3 class="text-center">All Vouchers</h3>
            <!-- <p class="text-center">Click on any title to edit</p> -->
            <div class="text-center flex flex-nowrap bg-blue-700 p-3 text-white font-bold overflow-x-auto gap-4 rounded-md text-xs lg:text-md">
                <p class="w-1/3">S/N</p>
                <p class="w-1/3">Voucher Pin</p>
                <p class="w-1/3">Used By</p>
                <p class="w-1/3">Status</p>
                <p class="w-1/3">Date used</p>
                <p class="w-1/3"></p>
            </div>
            <!-- {{ usedata }} -->
            <!-- {{ tabledata }} {{ tabledatacount }} {{ endss }} -->
            <VouchersItemsList v-for="(item, index) in tabledata" :key="index" :item="item" :sn="index + 1" :page="pages" :interval="intervalnum" />
            <PaginaterBase v-if="tabledatacount > 0" :intervalnum="intervalnum" :pages="pages" :endss="endss" :endnum="endnum" :datalength="endss" @paginator="newPage" @changeInterval="effectInterval" />
            
            <div class="text-center mt-5">
                <a download :href="downloadurl" target="_blank" class="inline-block bg-emerald-700 hover:bg-emerald-500 p-3 text-white rounded-md w-3/5 mx-auto">Download Vouchers (Unused)</a>
            </div>
            
            <!-- <p class="text-3xl">Generate Vouchers here</p> -->
        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive, watch, watchEffect } from "vue"
import { adminStore } from "../stores/admin.js"
import VouchersItemsList from '@/components/VouchersItemsList'
import PaginaterBase from '@/components/PaginaterBase'
import { functionExpression } from "@babel/types";
// import VouchersItemsList from "@/components/VouchersItemsList.vue.js";

let voucher_count = ref(10);
let adminstore = adminStore();
let vouchers = ref({
    tabledata : []
})
let tabledata = ref([])
let tabledatacount = ref(0)
let generating = ref(false)

let startnum = ref(0)
let intervalnum = ref(10)
let endnum = ref(10)
const endss = computed(() => { return vouchers.value.datacount })
// const usedata = computed(() => { return  })
let limitnum = endss
let pages = ref(1)
let downloadurl = ref("")
let generated = ref(false)


adminstore.getVouchers().then((response) => {
    vouchers.value = adminstore.vouchers
    tabledata.value = vouchers.value.tabledata.slice(startnum.value, endnum.value)
    tabledatacount.value = vouchers.value.datacount
    downloadurl.value = adminstore.environ == 'development' ? `${adminstore.origin}/feedthemasses/src/${vouchers.value.url}` : `${adminstore.origin}/${vouchers.value.url}` 
})

// watch(usedata, )

watchEffect(() => {
    vouchers.value = adminstore.vouchers
    tabledata.value = vouchers.value.tabledata.slice(startnum.value, endnum.value)
    tabledatacount.value = vouchers.value.datacount
})
// console.log(usedata.value)
watchEffect(() => {
    let newend = intervalnum.value * pages.value;

    if (newend < endss.value) {
        endnum.value = newend;
        startnum.value = newend - intervalnum.value ;
    } else {
        endnum.value = endss.value;
        startnum.value = newend - intervalnum.value ;
    }
})

function  newPage(action){

    if(action == 'decrease'){
        pages.value = pages.value > 1 ? pages.value = pages.value - 1 : pages.value = 1
    }else if(action == 'increase'){
        pages.value = pages.value < Math.ceil(vouchers.value.datacount / intervalnum.value) ? pages.value = pages.value + 1 : pages.value = Math.ceil(vouchers.value.datacount / intervalnum.value)
    }

}
function effectInterval(newinterval){
    intervalnum.value = newinterval
    pages.value = 1
    newPage(pages.value)
}

function generateVoucher(){
    generating.value = true
    generated.value = false
    adminstore.generateVoucher(voucher_count.value).then((response) => {
        generating.value = false
        generated.value = true
        adminstore.getVouchers();
    })
}






</script>

<style lang="scss" scoped>

</style>