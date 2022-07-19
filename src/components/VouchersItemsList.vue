<template>
    <div>
        <div class="flex flex-nowrap gap-4 lg:text-center text-right p-3 border-b-2 border-b-gray-300 overflow-x-auto text-xs lg:text-sm">
            <p class="w-1/3">{{ sn + ((page - 1) * interval) }}</p>
            <!-- <p class="flex-child"><b-link :to="{ name : 'edititem', params : { trackid : item.trackid }}">{{ item.title }}</b-link></p> -->
            <p class="w-1/3">{{ item.voucher_pin }}</p>
            <p class="w-1/3">{{ item.voucher_user }}</p>
            <p :class="{ 'bg-rose-700/[0.4]' : item.status == 'Used', 'bg-green-700/[0.4]' : item.status == 'Unused' }" class=" lg:w-1/3 bg-rose-700/[0.4] h-fit rounded-xl p-1 lg:flex font-bold font-sans">
                <span :class="{ 'bg-orange-700' : item.status == 'Used', 'bg-green-700' : item.status == 'Unused' }" class="h-1 w-1 lg:h-3 lg:w-3 lg:ml-5 lg:mt-1 lg:inline-block rounded-full"></span><span class="inline-block lg:w-1/2">{{ item.status }}</span>
            </p>
            <p class="w-1/3">{{ item.used_date }}</p>
            <p class="w-1/3 overflow-x-auto">
                <button class="p-2 list-button bg-red-500/[0.7] hover:bg-red-800 hover:text-white font-bold rounded-md" variant="success" @click="confirmapprove()"> Deactivate </button><br>
                <!-- <button v-if="item.req_status == 'Unapproved'" class="p-1 list-button mt-1" variant="danger" @click="confirmdisapprove()"> Disapp </button> -->
            </p>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    item : Object,
    sn : [Number, String],
    page : [Number, String],
    interval : Number
})


</script>

<style lang="scss" scoped>

</style>