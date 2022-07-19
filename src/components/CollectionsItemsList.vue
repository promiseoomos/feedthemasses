<template>
    <div>
        <div class="flex flex-nowrap gap-4 lg:text-center text-left p-3 border-b-2 border-b-gray-300 overflow-x-auto text-xs lg:text-sm">
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
                    <button class="text-green-600 hover:text-green-400 hover:bg-gray-200 w-full p-2 block text-sm text-left">Approve Request</button>
                    <button class="text-yellow-600 hover:text-yellow-400 hover:bg-gray-200 p-2 block text-sm w-full text-left">Disapprove Request</button>
                    <button class="text-red-600 hover:text-red-400 hover:bg-gray-200 p-2 block text-sm w-full text-left">Delete Request</button>
                </div>
            </div>
        </div>
        <div v-if="showuserdetails" class="bg-gray-200">
            <div class="flex flex-wrap justify-around">
                <div class="">
                    <p class="font-bold text-xl text-center underline">User Details</p>
                    <div class="text-left">
                        <div class="flex flex-wrap justify-start">
                            <p class="text-sm mr-3">Name: </p>
                            <p class="font-bold">{{ item.user_details.first_name }} {{ item.user_details.surname }}</p>
                        </div>
                         <div class="flex flex-wrap justify-start">
                            <p class="text-sm mr-3">User ID: </p>
                            <p class="font-bold">{{ item.user_id }}</p>
                        </div>
                        <div class="flex flex-wrap justify-start">
                            <p class="text-sm mr-3">Username: </p>
                            <p class="font-bold">{{ item.user_details.username }}</p>
                        </div>
                        <div class="flex flex-wrap justify-start">
                            <p class="text-sm mr-3">Phone: </p>
                            <p class="font-bold">{{ item.user_details.phone }}</p>
                        </div>
                        <div class="flex flex-wrap justify-start">
                            <p class="text-sm mr-3">Address: </p>
                            <p class="font-bold">{{ item.user_details.address }}</p>
                        </div>
                        <div class="flex flex-wrap justify-start">
                            <p class="text-sm mr-3">Next of Kin: </p>
                            <p class="font-bold">{{ item.user_details.next_of_kin }}</p>
                        </div>
                            <div class="flex flex-wrap justify-start">
                                <p class="text-sm mr-3">Next of Kin Phone: </p>
                                <p class="font-bold">{{ item.user_details.next_of_kin_phone }}</p>
                            </div>
                        </div>
                </div>
                <div class="">
                    <p class="font-bold text-xl text-center underline">Accout Details</p>
                    <div class="text-left">
                        <div class="flex flex-wrap justify-start">
                            <p class="text-sm mr-3">Bank Name: </p>
                            <p class="font-bold">{{ item.user_details.bank_name }}</p>
                        </div>
                        <div class="flex flex-wrap justify-start">
                            <p class="text-sm mr-3">Account Number: </p>
                            <p class="font-bold">{{ item.user_details.account_number }}</p>
                        </div>
                        <div class="flex flex-wrap justify-start">
                            <p class="text-sm mr-3">Account Name: </p>
                            <p class="font-bold">{{ item.user_details.account_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue"
import { adminStore } from "@/stores/admin";

const props = defineProps({
    item : Object,
    sn : [Number, String],
    page : [Number, String],
    interval : Number
})

const showactions = ref(false)
const activeitem = ref(0)
const showuserdetails = ref(false)

const adminstore = adminStore();

function approveRequest(){
    return adminstore.approveRequest(item.track_id).then(() => {

    })
}

function disapproveRequest(){
    return adminstore.disapproveRequest(item.track_id).then(() => {

    })
}

function deleteRequest(){
    return adminstore.deleteRequest(item.track_id).then(() => {

    })
}

</script>

<style lang="scss" scoped>

</style>