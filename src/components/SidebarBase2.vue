<template>
    <div>
        <div class="bg-black text-white h-screen">
            <div class="p-3">
                <!-- <img src="../assets/logo.jpg"> -->
                <!-- <p class="text-4xl text-bold font-sans text-center">Feed The Masses</p> -->
            </div>

            <div class="text-center p-2">
                <router-link :to="{ name : 'adminhome' }" active-class="bg-gray-500/[0.1]" @click="$emit('routeChanged')" class="text-white bg-gray-800 w-full flex rounded-md p-3 mt-3 hover:bg-gray-400">
                    <img src="../assets/015-home-1.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">Dashboard</span>
                </router-link>

                <router-link :to="{ name : 'collections'}" @click="$emit('routeChanged')" active-class="bg-gray-600/[0.4]" class="text-white bg-gray-800 w-full flex rounded-md p-3 mt-3 hover:bg-gray-400">
                    <img src="../assets/007-user.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">All Collections</span>
                </router-link>

                <router-link :to="{ name : 'allusers' }" active-class="bg-gray-600/[0.4]" @click="$emit('routeChanged')" class="text-white bg-gray-800 w-full flex rounded-md p-3 mt-3 hover:bg-gray-400">
                    <img src="../assets/locked.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">All Users</span>
                </router-link>

                <router-link :to="{ name : 'generatevouchers' }" active-class="bg-gray-600/[0.4]" @click="$emit('routeChanged')" class="text-white bg-gray-800 w-full flex rounded-md p-3 mt-3 hover:bg-gray-400">
                    <img src="../assets/011-people.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">Generate Vouchers</span>
                </router-link>

                <router-link to="" active-class="bg-gray-600/[0.4]" class="text-white bg-gray-800 w-full flex p-3 mt-3 hover:bg-gray-400" @click="logout()">
                    <img src="../assets/logout.png" class="w-8 h-7 mr-5">
                    <span class="font-black">Logout</span>
                </router-link>

                <!-- <router-link :to="{ name : 'rewards' }" active-class="bg-gray-600/[0.4]" @click="$emit('routeChanged')" class="text-white bg-gray-800 w-full flex rounded-md p-3 mt-3 hover:bg-gray-400">
                    <img src="../assets/014-money-bag.png" alt="Feed" class="w-8 h-7 mr-5">
                    <span class="font-black">Your Rewards</span>
                </router-link> -->
            </div>
        
        </div>
    </div>
</template>

<script>
export default {
    setup () {
        

        return {}
    }
}
</script>

<style lang="scss" scoped>

</style>