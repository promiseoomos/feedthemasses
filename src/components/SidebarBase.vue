<template>
    <div>
        <div class="bg-black text-white h-screen">
            <!-- <div class="p-3 text-black">
                <img src="../assets/logo.jpg">
                <!- <p class="text-4xl text-bold font-sans text-center">Feed The Masses</p> ->
            </div> -->

            <div class="text-center py-2">
                <router-link :to="{ name : 'dashboardhome' }" active-class="bg-gray-500/[0.1]" @click="$emit('routeChanged')" class="text-white bg-gray-800 w-full flex p-3 mt-16 hover:bg-gray-400">
                    <img src="../assets/015-home-1.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">Dashboard</span>
                </router-link>

                <router-link :to="{ name : 'profile' , params : { username : 'promiseomos' } }" @click="$emit('routeChanged')" active-class="bg-gray-600/[0.4]" class="text-white bg-gray-800 w-full flex p-3 mt-3 hover:bg-gray-400">
                    <img src="../assets/007-user.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">Your Profile</span>
                </router-link>

                <router-link :to="{ name : 'upgrade' }" active-class="bg-gray-600/[0.4]" @click="$emit('routeChanged')" class="text-white bg-gray-800 w-full flex p-3 mt-3 hover:bg-gray-400">
                    <img src="../assets/locked.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">Upgrade Stage</span>
                </router-link>

                <router-link :to="{ name : 'matrix' }" active-class="bg-gray-600/[0.4]" @click="$emit('routeChanged')" class="text-white bg-gray-800 w-full flex p-3 mt-3 hover:bg-gray-400">
                    <img src="../assets/011-people.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">Genealogy</span>
                </router-link>

                <router-link :to="{ name : 'rewards' }" active-class="bg-gray-600/[0.4]" @click="$emit('routeChanged')" class="text-white bg-gray-800 w-full flex p-3 mt-3 hover:bg-gray-400">
                    <img src="../assets/014-money-bag.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">Your Rewards</span>
                </router-link>

                <router-link to="" active-class="bg-gray-600/[0.4]" class="text-white bg-gray-800 w-full flex p-3 mt-3 hover:bg-gray-400" @click="logout()">
                    <img src="../assets/logout.png" class="w-8 h-7 mr-5">
                    <span class="font-black">Logout</span>
                </router-link>
            </div>
        
        </div>
    </div>
</template>

<script setup>
import { userStore } from "../stores/user.js"
import { useRouter } from "vue-router"
const userstore = userStore()
const router = useRouter()

function logout(){
    userstore.logOut
    router.push("/login")
}

</script>

<style lang="scss" scoped>

</style>