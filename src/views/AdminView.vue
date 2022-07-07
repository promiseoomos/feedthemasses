<template>
    <div>
        <button class="absolute left-5 top-5 lg:hidden" @click="showsidebar = !showsidebar">
            <div v-if="!showsidebar" class="border-b-2 border-black w-8 mt-1"></div>
            <div v-if="!showsidebar" class="border-b-2 border-black w-6 mt-1"></div>
            <div v-if="!showsidebar" class="border-b-2 border-black w-4 mt-1"></div>
            <p v-if="showsidebar" class="text-3xl text-black -mt-3">x</p>
        </button>

        <div class="grid grid-cols-1 lg:grid-cols-8">
            <SidebarBase class="col-span-2 z-50 absolute lg:static w-full lg:w-fit lg:hidden" @route-changed="showsidebar = false" v-if="showsidebar"/>
            <SidebarBase class="col-span-2 z-50 absolute lg:static w-full lg:w-fit hidden lg:block" v-if="showsidebar"/>
            <router-view class="bg-gray-300 col-span-6 h-screen -ml-1 p-3"></router-view>
            
        </div>
    </div>
</template>

<script>
import SidebarBase from "@/components/SidebarBase"
import { ref, onBeforeMount } from "vue"
import { adminStore } from "@/stores/admin";
import { useRoute, useRouter } from "vue-router";

export default  {
    components : {
        SidebarBase
    },
    setup() {

        const showsidebar = ref(true);
        const adminstore = adminStore()
        let lastknownstate = ""

        const router = useRouter()

        if(adminstore.loggedin){
            adminstore.$subscribe((state) => {
                // console.log(mutation.type)
                localStorage.setItem("user", JSON.stringify(state))
            }, { detached : true })
        }else{
            router.push({
                name : "sadminlogin"
            })
        }
        

        return {
            showsidebar,
            lastknownstate
        }
    }
}
</script>

<style lang="scss" scoped>

</style>