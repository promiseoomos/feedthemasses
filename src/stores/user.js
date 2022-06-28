import { defineStore } from "pinia"
import userservice from "@/services/userservice"

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
            userservice.logger(userObj).then((response) => {
                this.details = response.data.details
                this.loggedin = response.data.loggedin
                
                return response.data.loggedin
            })
        },
        registerUser(userObj){
            userservice.register(userObj).then((response) => {
                return response.data
            })
        }
    }
})