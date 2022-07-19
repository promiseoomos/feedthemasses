<template>
    <div>
        <div class="flex flex-nowrap gap-4 lg:text-center text-right p-3 border-b-2 border-b-gray-300 overflow-x-auto text-xs lg:text-md">
            <p class="w-1/3">{{ sn + ((page - 1) * interval) }}</p>
            <!-- <p class="flex-child"><b-link :to="{ name : 'edititem', params : { trackid : item.trackid }}">{{ item.title }}</b-link></p> -->
            <p class="w-1/3"><button class="text-blue-500" @click="showuserdetails = !showuserdetails">{{ item.user_details.username }}</button></p>
            <p class="w-1/3">{{ item.stagename }}</p>
            <p :class="{ 'bg-yellow-500/[0.4]' : item.status == 'Requested', 'bg-rose-700/[0.4]' : item.status == 'Disapproved', 'bg-green-700/[0.4]' : item.status == 'Approved' }" class=" lg:w-1/3 bg-rose-700/[0.4] h-fit rounded-xl p-1 lg:flex font-bold font-sans">
                <span :class="{ 'bg-yellow-400' : item.status == 'Requested', 'bg-rose-700/[0.4]' : item.status == 'Disapproved', 'bg-green-700' : item.status == 'Approved' }" class="h-1 w-1 lg:h-3 lg:w-3 lg:ml-5 lg:mt-1 lg:inline-block rounded-full"></span><span class="inline-block lg:w-1/2">{{ item.status }}</span>
            </p>
            <!-- <p class="w-1/3">{{ item.used_date }}</p> -->
            <div class="w-1/3 overflow-x-auto">
                <button class="p-2 list-button  w-full text-right hover:text-white font-bold rounded-md" variant="success" @click="showactions = !showactions; activeitem = item.trackid"> <img v-if="!showactions" src="@/assets/More.png" class="inline-block" /> <img v-if="showactions" src="@/assets/close.png" class="inline-block w-5 h-5" /> </button><br>
                <!-- <button v-if="item.req_status == 'Unapproved'" class="p-1 list-button mt-1" variant="danger" @click="confirmdisapprove()"> Disapp </button> -->
                <div v-if="showactions" class="bg-gray-100 rounded-lg  w-56 absolute right-10 z-50">
                    <button class="text-green-600 hover:text-green-400 hover:bg-gray-200 w-full p-2 block text-sm text-left">Approve Collection</button>
                    <button class="text-yellow-600 hover:text-yellow-400 hover:bg-gray-200 p-2 block text-sm w-full text-left">Disapprove Collection</button>
                    <button class="text-red-600 hover:text-red-400 hover:bg-gray-200 p-2 block text-sm w-full text-left">Delete Collection</button>
                </div>
            </div>
        </div>
        <div v-if="showuserdetails" class="">
            {{ item.user_details }}
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue"

const props = defineProps({
    item : Object,
    sn : [Number, String],
    page : [Number, String],
    interval : Number
})

const showactions = ref(false)
const activeitem = ref(0)
const showuserdetails = ref(false)


</script>

<style lang="scss" scoped>

</style>