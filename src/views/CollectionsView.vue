<template>
    <div>
        <div class="rounded-lg bg-white p-3">
            
            <div v-if="generated" :class="{ 'text-green-600 bg-green-400/[0.4]' : generated }" class="min-h-20 w-full p-3 mb-3 rounded-md">
                {{ collections_count }} {{ collections_count > 1 ? 'Vouchers' : 'Voucher' }} has been successfully generated.
            </div>

            <h3 class="text-center">All Vouchers</h3>
            <!-- <p class="text-center">Click on any title to edit</p> -->
            <div class="text-center flex flex-nowrap bg-blue-700 p-3 text-white font-bold overflow-x-auto gap-4 rounded-md text-xs lg:text-md">
                <p class="w-1/3">S/N</p>
                <p class="w-1/3">Username</p>
                <p class="w-1/3">Stage Req</p>
                <p class="w-1/3">Status</p>
                <p class="w-1/3"></p>
            </div>
            <!-- {{ usedata }} -->
            <!-- {{ tabledata }} {{ tabledatacount }} {{ endss }} -->
            <CollectionsItemsList v-for="(item, index) in tabledata" :key="index" :item="item" :sn="index + 1" :page="pages" :interval="intervalnum" />
            <PaginaterBase v-if="tabledatacount > 0" :intervalnum="intervalnum" :pages="pages" :endss="endss" :endnum="endnum" :datalength="endss" @paginator="newPage" @changeInterval="effectInterval" />
            
            <!-- <p class="text-3xl">Generate Vouchers here</p> -->
        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive, watch, watchEffect } from "vue"
import { adminStore } from "../stores/admin.js"
import CollectionsItemsList from '@/components/CollectionsItemsList'
import PaginaterBase from '@/components/PaginaterBase'
import { functionExpression } from "@babel/types";

let collections_count = ref(10);
let adminstore = adminStore();
let collections = ref({
    tabledata : []
})
let tabledata = ref([])
let tabledatacount = ref(0)
let generating = ref(false)

let startnum = ref(0)
let intervalnum = ref(10)
let endnum = ref(10)
const endss = computed(() => { return collections.value.datacount })
// const usedata = computed(() => { return  })
let limitnum = endss
let pages = ref(1)
let downloadurl = ref("")
let generated = ref(false)


adminstore.getVouchers().then((response) => {
    collections.value = adminstore.collections
    tabledata.value = collections.value.tabledata.slice(startnum.value, endnum.value)
    tabledatacount.value = collections.value.datacount
    downloadurl.value = adminstore.environ == 'development' ? `${adminstore.origin}/feedthemasses/src/${collections.value.url}` : `${adminstore.origin}/${collections.value.url}` 
})

// watch(usedata, )

watchEffect(() => {
    collections.value = adminstore.collections
    tabledata.value = collections.value.tabledata.slice(startnum.value, endnum.value)
    tabledatacount.value = collections.value.datacount
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
        pages.value = pages.value < Math.ceil(collections.value.datacount / intervalnum.value) ? pages.value = pages.value + 1 : pages.value = Math.ceil(collections.value.datacount / intervalnum.value)
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
    adminstore.generateVoucher(collections_count.value).then((response) => {
        generating.value = false
        generated.value = true
        adminstore.getVouchers();
    })
}


</script>

<style lang="scss" scoped>

</style>