import { defineStore } from "pinia";
import adminservice from "@/services/adminservice.js"

export const adminStore = defineStore("admin", {

    state : () => {
        return {
            loggedin : "",
            details : "",
            clearance : "",
            infostats : {},
            collections : {},
            vouchers : {
                datacount : "",
                tabledata : []
            },
            users : {},
            environ : process.env.NODE_ENV,
            origin : "",
            rewards : []
        }
    },
    actions : {
        async loginAdmin(adminObj){
            return await adminservice.logger(adminObj).then((response) => {
                this.details = response.data.details
                this.loggedin = response.data.loggedin
                // this.getDownlines()
                // this.getCollections(this.details.track_id)

                return response.data.loggedin
            })
        },

        async getInfostats(){
            return await adminservice.getInfostats().then((response) => {
                this.infostats = response.data

                return response.data
            })
        },
        
        async getCollections(){
            return await adminservice.getCollections().then((response) => {
                this.collections = response.data

                return response.data
            })
        },
        
        async getVouchers(){
            return await adminservice.getVouchers().then((response) => {
                this.vouchers = response.data

                return response.data
            })
        },
        
        async getUsers(){
            return await adminservice.getUsers().then((response) => {
                this.users = response.data

                return response.data
            })
        },
        async generateVoucher(vouchers_count){
            return await adminservice.generateVoucher(vouchers_count).then((response) => {
                this.getVouchers()

                return response.data
            })
        },
        async approveRequest(rid){
            return await adminservice.approveRequest(rid).then((response) => {
                this.getCollections();
                return response.data
            })
        },
        async disapproveRequest(rid){
            return await adminservice.disapproveRequest(rid).then((response) => {
                this.getCollections();
                return response.data
            })
        },
        async updateReward(rewardObj, stage){
            return await adminservice.updateReward(rewardObj, stage).then((response) => {
                this.getRewards();

                return response.data
            })
        },
        async getRewards(){
            return await adminservice.getRewards().then((response) => {
                this.rewards = response.data
                
                return response.data
            })
        }
    }
})