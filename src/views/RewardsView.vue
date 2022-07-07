<template>
    <div>
        <div class="bg-white rounded-md min-h-screen text-center p-3 overflow-x">
            <p class="text-3xl font-black text-black">You are in {{ details.stage_name }} Stage</p>
            <div v-if="upgraded != ''" :class="{ 'text-green-600 bg-green-400/[0.4]' : upgraded, 'text-red-600 bg-red-400/[0.4]' : !upgraded}" class="min-h-20 w-full p-3 mb-3 rounded-md">
                Congratulations you just Upgraded to {{ details.stage_name }}. Here are you rewards for the Previous Stage
            </div>

            <div v-for="(reward, index) in rewards" :key="index" class="">
                <div class="p-3">
                    <ul v-for="(items, index) in reward.items" :key="index" class="text-left">
                        <p class="text-lg font-bold my-3">Option {{ index + 1 }}</p>
                        <li v-for="(item, index2) in items" :key="index2" class="list-disc">{{ item }}</li>
                        <!-- <p class="mt-3 mb-3" v-if="index + 1 < reward.items.length">Or</p> -->
                    </ul>

                    <button :disabled="false" :class="{ 'bg-green-400/[0.8] hover:bg-green-400/[0.8]' : false }" class="bg-green-600 w-full lg:w-3/5 p-3 rounded-lg text-white font-bold font-sans hover:bg-green-400" @click="upgradeUser">Collect rewards for {{ reward.name }}</button>
                </div>

            </div>
            
        </div>
    </div>
</template>

<script>
import {
    userStore
} from "../stores/user.js"
import {
    ref,
    reactive,
    computed
} from "vue"
import { useRoute, useRouter } from "vue-router";


export default {
    setup () {
        
        const userstore = userStore();
        const details = userstore.details
        const rewards = userstore.rewards
        const downlines = userstore.downlines

        const route = useRoute();
        console.log(route.query.upgraded)
        if(route.query.upgraded){

        }
        const upgraded = route.query.upgraded

        return {
            details,
            rewards,
            downlines,
            upgraded
        }
    }
}
</script>

<style lang="scss" scoped>

</style>