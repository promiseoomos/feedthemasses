<template>
    <div class="bg-cyan-500 p-2">
        <p class="text-xl text-bold text-center">Sign up</p>
        <div class="w-full lg:w-1/2 bg-white mx-auto rounded-lg p-5">
        
            <form @submit.prevent="regUser">
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="refferer_id" v-model="regData.referer_id" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="refferer_id" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Refferer ID</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="voucher_pin" v-model="regData.voucher_pin" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="voucher_pin" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Voucher Pin</label>
                </div>

                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="first_name" v-model="regData.first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First Name</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="surname" v-model="regData.surname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Surname</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="email" name="floating_email" v-model="regData.email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
                </div>
                <div class="grid xl:grid-cols-2 xl:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="username" v-model="regData.username" id="username" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                        <label for="username" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="tel" name="phone" v-model="regData.phone" @keyup="validatephone()" id="phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                        <label for="phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone Number</label>
                        <div v-if="validator.userphoneerror" class="">
                            <p v-html="validator.userphoneerrormsg"></p>
                        </div>
                    </div>

                </div>

                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="address" v-model="regData.address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="address" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Address</label>
                </div>

                <div class="grid xl:grid-cols-2 xl:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="next_of_kin" v-model="regData.next_of_kin" id="next_of_kin" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                        <label for="next_of_kin" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Next of Kin</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="tel" v-model="regData.next_of_kin_phone" name="next_of_kin_phone" id="next_of_kin_phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                        <label for="next_of_kin_phone" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Next of Kin Phone</label>
                    </div>
                </div>

                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="bank_name" v-model="regData.bank_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="bank_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Bank Name</label>
                </div>

                <div class="grid xl:grid-cols-2 xl:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="account_name" v-model="regData.account_name" id="account_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                        <label for="account_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Account Name</label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="account_number" v-model="regData.account_number" id="account_number" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                        <label for="account_number" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Account Number</label>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="password" name="password" v-model="regData.password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="password" name="repassword" v-model="repassword" @keyup="confirmpassword()" id="repassword" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="repassword" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm password</label>
                </div>
                <div v-if="validator.unmatchpassword" class="-mt-4">
                    <p v-html="validator.unmatchpasswordmsg"></p>
                </div>

                <div v-if="regResponse != ''" :class="{ 'text-green-600 bg-green-400/[0.4]' : regResponse.signedup, 'text-red-600 bg-red-400/[0.4]' : !regResponse.signedup}" class="min-h-20 w-full p-3 mb-3 rounded-md">
                    {{ regResponse.msg }} 
                 </div>

                <div class="text-center">
                    <button type="submit" :disabled="chkfields" :class="{ 'opacity-50' : chkfields }" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-3/5 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mx-auto">Sign up</button>
                </div>
                
            </form>
            <div class="text-center pt-5">
                <p>Or</p>
                <router-link :to="{ name : 'login'}" class="pt-3 block text-cyan-800 hover:text-cyan-600">Login</router-link>
            </div>
            

        </div>
    </div>
</template>

<script>
import { reactive, toRefs, computed, ref } from 'vue'
import { useUser } from "@/stores/user"
// import InputText from 'primevue/inputtext';


export default {
    components : {
        // InputText
    },
    setup () {
        const state = reactive({
            count: 0,
        })

        const userstore = useUser()
        const regData = reactive({
            first_name : "",
            surname : "",
            email : "",
            username : "",
            phone : "",
            password : "",
            bank_name : "",
            account_name : "",
            account_number : "",
            next_of_kin : "",
            next_of_kin_phone : "",
            address : "",
            referrer_id : "",
            voucher_pin : ""
        })
        const repassword = ref("")

        const validator = reactive({
            userphoneerror : false,
            userphoneerrormsg : "",
            unmatchpassword : false,
            unmatchpasswordmsg : ""
        })

        userstore.$patch({
            counter : 6,
            loggedin : true
        })
        userstore.$subscribe((mutation, state) => {
            mutation.type
            localStorage.setItem('userdetails', JSON.stringify(state))
        })

        const chkfields = computed(() => {
            return regData.first_name.length <= 0 || regData.surname.length <= 0 || regData.email.length <= 0 || regData.username.length <= 0 ||
            regData.phone.length <= 0 || regData.password.length <= 0 || regData.bank_name.length <= 0 || regData.account_name.length <= 0 ||  
            regData.account_number.length <= 0 || regData.next_of_kin.length <= 0 || regData.next_of_kin_phone.length <= 0 || regData.address.length <= 0 || 
            regData.voucher_pin.length <= 0 || validator.userphoneerror == true || validator.unmatchpassword == true  ? true : false
        })

        function validatephone(){
            let phone = regData.phone
            var patt = /[a-z]+/i

            if((patt.test(phone) || phone.length != 11)){
                validator.userphoneerror = true
                validator.userphoneerrormsg = "<ul class='text-red-500'><li>Only numeric characters required</li><li>Number must be 11 digits</li></ul>"
            }else{
                validator.userphoneerror = false
                validator.userphoneerrormsg = ""
            }
        }

        function confirmpassword(){
            let pword1 = regData.password
            let pword2 = repassword.value
            
            if(pword1.length < 8){
                validator.unmatchpassword = true
                validator.unmatchpasswordmsg = "<b class='text-red-500'>Passwords must be 8 Characters or more</b>"
            }else if(pword1 != pword2){
                validator.unmatchpassword = true
                validator.unmatchpasswordmsg = "<b class='text-red-500'>Passwords do not match</b>"
            }else{
                validator.unmatchpassword = false
                validator.unmatchpasswordmsg = ""
            }
        }

        let regResponse = ref("");
        function regUser(){
            // if()
            userstore.registerUser(regData).then((response) => {
                
                if(response.signedup){
                    regData.first_name =""; regData.surname ="";regData.email =""; regData.phone =""; regData.username =""; regData.bank_name =""; regData.first_name =""; regData.surname = ""
                    regData.email =""; regData.phone =""; regData.username =""; regData.bank_name=""; regData.account_name=""; regData.account_number=""; regData.next_of_kin = ""
                    regData.next_of_kin_phone=""; regData.address=""; regData.referrer_id=""; regData.voucher_pin = ""; regData.password = "";
                    repassword.value = ""  
                }
                regResponse.value = response
            })
        }

        userstore.counter++
    
        return {
            ...toRefs(state),
            userstore,
            regData,
            chkfields,
            regUser,
            confirmpassword,
            validatephone,
            validator,
            repassword,
            regResponse
        }
    }
}
</script>

<style lang="scss" scoped>

</style>