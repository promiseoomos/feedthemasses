<template>
    <div>
        <div class="bg-white rounded-md p-5">
            <form @submit.prevent="updateUser">
               
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="first_name" v-model="regData.first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First Name</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="surname" v-model="regData.surname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
                    <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Surname</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="email" name="floating_email" disabled v-model="regData.email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required="">
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
                <div v-if="regResponse != ''" :class="{ 'text-green-600 bg-green-400/[0.4]' : regResponse.signedup, 'text-red-600 bg-red-400/[0.4]' : !regResponse.signedup}" class="min-h-20 w-full p-3 mb-3 rounded-md">
                    {{ regResponse.msg }} 
                 </div>

                <div class="text-center">
                    <button type="submit" :disabled="chkfields" :class="{ 'opacity-50' : chkfields }" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-3/5 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mx-auto">Update profile</button>
                </div>
                
            </form>
            
        </div>
    </div>
</template>

<script>
import { userStore } from "../stores/user.js"
import { ref, reactive, computed } from "vue"

export default {
    setup () {
        
        const userstore = userStore();
        const details = userstore.details

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
        regData.first_name = details.first_name; regData.surname = details.surname; regData.email = details.email; regData.phone = details.phone;
        regData.bank_name = details.bank_name; regData.account_name = details.account_name; regData.account_number = details.account_number;
        regData.next_of_kin = details.next_of_kin; regData.next_of_kin_phone = details.next_of_kin_phone; regData.address = details.address;
        regData.username = details.username;
        
        const chkfields = computed(() => {
            return regData.first_name.length <= 0 || regData.surname.length <= 0 || regData.email.length <= 0 || regData.username.length <= 0 ||
            regData.phone.length <= 0 || regData.bank_name.length <= 0 || regData.account_name.length <= 0 || regData.account_number.length <= 0 || regData.next_of_kin.length <= 0 || regData.next_of_kin_phone.length <= 0 || regData.address.length <= 0
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

        let regResponse = ref("");

        function updateUser(){
            // if()
            userstore.updateUseracct(regData).then((response) => {
                
                if(response.signedup){
                    regData.first_name =""; regData.surname ="";regData.email =""; regData.phone =""; regData.username =""; regData.bank_name =""; regData.first_name =""; regData.surname = ""
                    regData.email =""; regData.phone =""; regData.username =""; regData.bank_name=""; regData.account_name=""; regData.account_number=""; regData.next_of_kin = ""
                    regData.next_of_kin_phone=""; regData.address="";  
                }
                regResponse.value = response
            })
        }
        const validator = reactive({
            userphoneerror : false,
            userphoneerrormsg : "",
            unmatchpassword : false,
            unmatchpasswordmsg : ""
        })

        return {
            details,
            regData,
            chkfields,
            updateUser,
            validatephone,
            validator,
            regResponse
        }
    }
}
</script>

<style lang="scss" scoped>

</style>