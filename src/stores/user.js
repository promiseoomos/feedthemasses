import { defineStore } from "pinia"
import userservice from "@/services/userservice.js"

export const userStore = defineStore("user", {
    state : () => {
        return{
            details : {},
            loggedin : false,
            counter : 0,
            downlines : {},
            rewards : [
                {
                    stage : 0,
                    name : "Feeders",
                    items : [
                        ["1 Custard/golden Morn", "5pcs Milo & 5pcs Milk"],
                        ["1 kg Semo/Wheat", "1 Spaghetti", "5 sachet tomatoes", "1 packet maggi"],
                        ["N1500"]
                    ],
                    level_bonus : "",
                    level_requirements : 12
                },
                {
                    stage : 1,
                    name : "Bronze",
                    items : [
                        ["5kg Rice", "1 pct. Maggi", "1 Carton of Indomie", "750ML Groundnut Oil", "5 Sachet Tomatoes", "1 450g Milo", "1 350g Milk", "1 Sardine"],
                        ["N8000"]
                    ],
                    level_bonus : "",
                    level_requirements : 12
                },
                {
                    stage : 2,
                    name : "Silver",
                    items : [
                        ["25 kg Rice","450g Milo", "350g Milk", "2 pieces sardine", "1 packet sugar", "1 packet Maggi", "4 Litre groundnut oil","1 Carton spaghetti",
                            "1 Custard", "5 kg Semo/wheat", "1 Butter", "1 Packet salt" ,"1 cornflakes", "N50,000"]
                    ],
                    level_bonus : "Electric Kettle",
                    level_requirements : 12
                },
                {
                    stage : 3,
                    name : ""
                }
            ]
        }
    },
    actions : {
        async loginUser(userObj){
            return await userservice.logger(userObj).then((response) => {
                this.details = response.data.details
                this.loggedin = response.data.loggedin
                this.getDownlines()

                return response.data.loggedin
            })
        },
        async registerUser(userObj){
            // console.log(userObj)
            return await userservice.register(userObj).then((response) => {
                return response.data
            })
        },
        async getDownlines(){
            // console.log(this.details.track_id)
            return await userservice.retrieveDownlines(this.details.track_id).then((response) => {
                this.downlines = response.data
                return response.data
            })
        },
        async updateUseracct(userObj){
            return await userservice.updateuser(userObj).then((response) => {
                return response.data
            })
        },
        async upgradeUser(upgradeObj){
            return await userservice.upgradeUserNow(upgradeObj).then((response) => {
                return response.data
            })
        }

    }
})