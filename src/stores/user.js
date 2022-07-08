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
                    level_bonus : [],
                    level_requirements : 12,
                    food_reward_wallet : "1,000",
                    cash_reward_wallet : "500"
                },
                {
                    stage : 1,
                    name : "Bronze",
                    items : [
                        ["5kg Rice", "1 pct. Maggi", "1 Carton of Indomie", "750ML Groundnut Oil", "5 Sachet Tomatoes", "1 450g Milo", "1 350g Milk", "1 Sardine"],
                        ["N8000"]
                    ],
                    level_bonus : "",
                    level_requirements : 12,
                    food_reward_wallet : "3,000",
                    cash_reward_wallet : "5,000"
                },
                {
                    stage : 2,
                    name : "Silver",
                    items : [
                        ["25 kg Rice","450g Milo", "350g Milk", "2 pieces sardine", "1 packet sugar", "1 packet Maggi", "4 Litre groundnut oil","1 Carton spaghetti",
                            "1 Custard", "5 kg Semo/wheat", "1 Butter", "1 Packet salt" ,"1 cornflakes", "N50,000"]
                    ],
                    level_bonus : ["Electric Kettle"],
                    level_requirements : 12,
                    food_reward_wallet : "30,000",
                    cash_reward_wallet : "50,000"
                },
                {
                    stage : 3,
                    name : "Gold",
                    items : [
                        [   
                            "1 carton spaghetti",
                            "50kg Rice,",
                            "500g Milo",
                            "Oat",
                            "10kg semo",
                            "5 pic Sadine",
                            "2 carton on indomie",
                            "1 Mayonnaise",
                            "Corn flakes",
                            "2 packet maggi",
                            "1kg Detergent",
                            "2 Packets salt",
                                "3  juice",
                            "5 litre groundnut oil",
                            "Custard",
                            "400g Milk",
                            "2 cartons of tin tomatoes",
                            "1 Butter",
                            "1 Golden Morn",
                            "5kg Beans",
                            "1Toothpaste",
                            "1Liquid wash",
                            "3 Cartons can malt",
                            "N200,000"
                        ],
                    ],
                    level_bonus : ["Table gas"],
                    level_requirements : 12,
                    food_reward_wallet : "50,000",
                    cash_reward_wallet : "200,000"
                },
                {
                    stage : 4,
                    name : "Diamond",
                    items : [
                        [
                            "2 Carton spaghetti",
                            "50kg Rice",
                            "5 500g Milo",
                            "1 Oats",
                            "10kg Semo",
                            "10 Sardine",
                            "2 Carton of indomie",
                            "1 Mayonnaise",
                            "3 Corn flakes",
                            "3 pack. Tissue",
                            "4 Crates of Eggs",
                            "1/2 Carton can malt",
                            "5 Packets salt",
                            "3 Tooth paste",
                            "5 Dish washer",
                            "5litre groundnut oil",
                            "2. Custard",
                            "400g Milk",
                            "25 kg wheat",
                            "2 Carton of tin tomatoes",
                            "2 Butter",
                            "2 Golden Morn",
                            "10kg Beans",
                            "20 Sardine",
                            "1/2 Carton Juice",
                            "1 Bottle wine",
                            "5 Packets of Maggi",
                            "2kg Detergent",
                            "N1,000,000"
                        ]
                    ],
                    level_bonus : ["Deep freezer","Generator","N200,000"],
                    level_requirements : 12,
                    food_reward_wallet : "100,000",
                    cash_reward_wallet : "1,000,000"
                },
                {
                    stage : 5,
                    name : "Platinum",
                    items : [
                        [
                            "Cash reward of N7,000,000",    
                            "Food stuffs worth N400,000.",  
                            "Brand new fridge worth N200,000",  
                            "Brand new Smart phone worth N200,000", 
                            "Additional food stuffs worth N40,000 for 3 months.",   
                        ]
                    ],
                    level_bonus : [],
                    level_requirements : 12,
                    food_reward_wallet : "7,000,000",
                    cash_reward_wallet : "400,000"
                }
            ],
            collections : []
        }
    },
    actions : {
        async loginUser(userObj){
            return await userservice.logger(userObj).then((response) => {
                this.details = response.data.details
                this.loggedin = response.data.loggedin
                this.getDownlines()
                this.getCollections(this.details.track_id)

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
        },
        async collectReward(stage, track_id){
            return await userservice.collectReward(stage, track_id).then((response) => {
                return response.data
            })
        },
        async getCollections(track_id){
            return await userservice.getCollections(track_id).then((response) => {
                this.collections = response.data
                return response.data
            })
        }

    }
})