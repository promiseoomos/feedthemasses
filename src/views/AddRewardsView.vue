<template>
    <div>
        <div class="rounded-lg bg-white p-3 pb-10">
            
            <p class="text-lg text-center mb-5 mt-5">Add or Modify Rewards</p>
            <div class="flex flex-wrap justify-start gap-4 font-medium border-b cursor-pointer border-gray-200">
                <p class="p-2 px-4" :class="{ 'rounded-md bg-slate-300 font-semibold text-blue-600' : activeTab == 'feeder' }" @click="activeTab = 'feeder'">Feeder</p>
                <p class="p-2 px-4" :class="{ 'rounded-md bg-slate-300 font-semibold text-blue-600' : activeTab == 'bronze' }" @click="activeTab = 'bronze'">Bronze</p>
                <p class="p-2 px-4" :class="{ 'rounded-md bg-slate-300 font-semibold text-blue-600' : activeTab == 'silver' }" @click="activeTab = 'silver'">Silver</p>
                <p class="p-2 px-4" :class="{ 'rounded-md bg-slate-300 font-semibold text-blue-600' : activeTab == 'gold' }" @click="activeTab = 'gold'">Gold</p>
                <p class="p-2 px-4" :class="{ 'rounded-md bg-slate-300 font-semibold text-blue-600' : activeTab == 'diamond' }" @click="activeTab = 'diamond'">Diamond</p>
                <p class="p-2 px-4" :class="{ 'rounded-md bg-slate-300 font-semibold text-blue-600' : activeTab == 'platinum' }" @click="activeTab = 'platinum'">Platinum</p>
            </div>

            <div class="mt-5">
                <form @submit.prevent="updateReward">
                    <div class="mt-3">
                        <p class="font-bold">Level Name</p>
                        <el-input v-model="reward.name" size="large" disabled />
                    </div>

                    <div class="mt-3">
                        <p class="font-bold">Level Stage</p>
                        <el-input-number v-model="reward.stage" size='large'/>
                    </div>

                    <div class="mt-3">
                        <p class="font-bold">Add Reward Items</p>
                        <div class="border border-gray-100 p-2">
                            <el-tag v-for="item in reward.items" :key="item" size="large" class="m-1" closable @close="handleRemove(item)">{{ item }}</el-tag>
                            <el-input v-model="item" class="mt-2" placeholder="Add reward Items">
                            </el-input>
                            <el-button class="mt-2" @click="addtoItems">Add</el-button>    
                        </div>
                    </div>

                    <div class="mt-3">
                        <p class="font-bold">Add Level Bonus</p>
                        <div class="border border-gray-100 p-2">
                            <el-tag v-for="item in reward.level_bonus" :key="item" size="large" class="m-1" closable @close="handleRemoveBonus(item)">{{ item }}</el-tag>
                            <el-input v-model="bonus" class="mt-2" placeholder="Add reward Items">
                            </el-input>
                            <el-button class="mt-2" @click="addtoBonus">Add</el-button>    
                        </div>
                    </div>

                    <div class="mt-3">
                        <p class="font-bold">Level downlines Requirement</p>
                        <el-input size="large" v-model="reward.level_requirements" disabled />
                    </div>

                    <div class="mt-3">
                        <p class="font-bold">Food Reward Wallet Amount</p>
                        <el-input size="large" placeholder="2,000,000" v-model="reward.food_reward_wallet"/>
                    </div>

                    <div class="mt-3">
                        <p class="font-bold">Cash Reward Wallet Amount</p>
                        <el-input size="large" placeholder="40,000" v-model="reward.cash_reward_wallet"/>
                    </div>

                    <button v-loading="loading" class="mt-4 bg-slate-600 text-white font-bold hover:bg-slate-500 rounded-md p-3 mx-auto block">Update {{ capitalize(activeTab) }} rewards</button>

                </form>
            </div>
            <!-- <p class="text-center">Click on any title to edit</p> -->
            
            
            <!-- <p class="text-3xl">Generate Vouchers here</p> -->
        </div>
    </div>
</template>

<script setup>
import { ref, computed, reactive, watch, watchEffect } from "vue"
import { adminStore } from "../stores/admin.js"
import CollectionsItemsList from '@/components/CollectionsItemsList'
import PaginaterBase from '@/components/PaginaterBase'
import { functionExpression } from "@babel/types";
import capitalize from "../composables/useCapitalize.js"


let collections_count = ref(10);
let adminstore = adminStore();
let collections = ref({
    tabledata : []
})
let tabledata = ref([])
let tabledatacount = ref(0)
let loading = ref(false)
let activeTab = ref("feeder")
let item = ref("")
let bonus = ref("")

let reward = ref({
    name : capitalize(activeTab.value),
    stage : 0,
    items : [],
    level_bonus : [],
    level_requirements : 12,
    food_reward_wallet : "",
    cash_reward_wallet : ""
})

const addtoItems = () => {
    reward.value.items.push(item.value)
    item.value = ""
}

const addtoBonus = () => {
    reward.value.level_bonus.push(bonus.value)
    bonus.value = ""
}

const handleRemove = (tag) => {
  reward.value.items.splice(reward.value.items.indexOf(tag), 1)
}

const handleRemoveBonus = (tag) => {
  reward.value.level_bonus.splice(reward.value.level_bonus.indexOf(tag), 1)
}

watch(activeTab, () => {
    reward.value.name = capitalize(activeTab.value)
    reward.value.stage = 0
    reward.value.items = []
    reward.value.level_bonus = []
    reward.value.food_reward_wallet = ""
    reward.value.cash_reward_wallet = ""
    loading.value = false
})

const updateReward = () => {
    loading.value = true

    adminstore.updateReward(reward.value, activeTab.value).then((response) => {
        loading.value = false

        console.log(response)
        adminstore.getRewards();
    })
}


</script>

<style lang="scss" scoped>

</style>