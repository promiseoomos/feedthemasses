import { defineStore } from "pinia"
import userservice from "@/services/userservice.js"

export const useUser = defineStore("user", {
    state : () => {
        return{
            details : {},
            loggedin : false,
            counter : 0
        }
    },
    actions : {
        loginUser(userObj){
            return userservice.logger(userObj).then((response) => {
                this.details = response.data.details
                this.loggedin = response.data.loggedin
                
                return response.data.loggedin
            })
        },
        registerUser(userObj){
            // console.log(userObj)
            return userservice.register(userObj).then((response) => {
                return response.data
            })
        }
    }
})