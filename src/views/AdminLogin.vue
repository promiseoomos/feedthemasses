<template>
    <div class="bg-cyan-900 p-2">
        
        <div class="w-full lg:w-1/2 bg-white mx-auto rounded-lg p-5 my-10 h-96">
            <p class="text-2xl font-bold text-center">Login</p>
            <form @submit.prevent="logAdmin">
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="clearance" v-model="regData.clearance" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="clearance" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Clearance</label>
                </div>

                <div class="relative z-0 w-full mb-6 group">
                    <input type="password" name="password" v-model="regData.password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                </div>

                <div v-if="!logresponse" :class="{ 'text-green-600 bg-green-400/[0.4]' : logresponse, 'text-red-600 bg-red-400/[0.4]' : !logresponse}" class="min-h-20 w-full p-3 mb-3 rounded-md">
                    Email or Password Incorrect
                </div>


                <div class="text-center pt-4">
                    <button type="submit" :disabled="chkfields" :class="{ 'opacity-50' : chkfields }" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-3/5 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mx-auto">Login</button>
                </div>
                
            </form>
            

        </div>
    </div>
</template>

<script>
import { reactive, toRefs, computed, ref } from 'vue'
import { useRouter } from "vue-router"
import { adminStore } from "@/stores/admin"
// import InputText from 'primevue/inputtext';


export default {
    components : {
        // InputText
    },
    setup () {
        const state = reactive({
            count: 0,
        })

        const adminstore = adminStore()
        const regData = reactive({
            clearance : "",
            password : "",
        })

        let logresponse = ref(true)

        const chkfields = computed(() => {
            return regData.clearance.length <= 0 || regData.password.length <= 0 ? true : false
        })
        const router = useRouter();

        function logAdmin(){

            return adminstore.loginAdmin(regData).then((response) => {
                // console.log(response)
                logresponse.value = response

                if(response){
                    regData.clearance = ""
                    regData.password = ""

                    router.push({
                        name : "adminhome"
                    })
                }
            })
        }
    
        return {
            ...toRefs(state),
            adminstore,
            regData,
            chkfields,
            logAdmin,
            logresponse
        }
    }
}
</script>

<style lang="scss" scoped>

</style>