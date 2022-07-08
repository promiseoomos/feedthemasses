<template>
    <div>
        <div class="bg-white rounded-md min-h-screen text-center p-3 overflow-x">
            <p class="text-3xl font-black text-black">You are currently in {{ details.stage_name }} Stage</p>
            <div v-if="upgraded" :class="{ 'text-green-600 bg-green-400/[0.4]' : upgraded, 'text-red-600 bg-red-400/[0.4]' : !upgraded}" class="min-h-20 w-full p-3 mb-3 rounded-md">
                Congratulations you just Upgraded to {{ details.stage_name }}. Here are you rewards.
            </div>

            <div v-for="(reward, index) in rewards" :key="index" class="">
            <!-- v-if="reward.stage == details.stage - 1" -->
                <div class="p-5 rounded-lg my-3 bg-gray-100" >
                    <p class="text-lg font-bold">Reward for {{ reward.name }} Stage</p>
                    <ul v-for="(items, index1) in reward.items" :key="index1" class="text-left">
                        <p class="text-lg font-bold my-3" v-if="reward.items.length > 1">Option {{ index1 + 1 }}</p>
                        <li v-for="(item, index2) in items" :key="index2" class="list-disc">{{ item }}</li>
                        <!-- <p class="mt-3 mb-3" v-if="index + 1 < reward.items.length">Or</p> -->
                    </ul>
    
                    <!-- <Select v-model="rewardoption" ref="rewardoptions" v-if="reward.items.length > 1" class="p-3 w-1/2 block rounded-md bg-white my-2 mx-auto">
                      <Option v-for="i in reward.items.length" :value="i" :key="i + 1" class="p-3">Option {{ i }}</Option>
                      <Option value="null" key="">--Select Option--</Option>
                    </Select> -->

                    <div v-if="reward.level_bonus.length > 0" class="text-left">
                        <p class="font-bold text-lg">Level Bonus</p>
                        <p class="" v-if="reward.level_bonus.length > 1">Any of</p>
                        <li v-for="(bonus, index) in reward.level_bonus" :key="index">{{ bonus }}</li>
                    </div>

                    <div v-if="colresponse && reward.stage == collectedstage" :class="{ 'text-green-600 bg-green-400/[0.4]' : colresponse, 'text-red-600 bg-red-400/[0.4]' : !colresponse}" class="min-h-20 w-full p-3 mb-3 rounded-md">
                        Congratulations your reward for {{ reward.name }} is on its way!
                    </div>
                    <button :disabled="reward.stage >= details.stage || chkdis(reward.stage) || collected" :class="{ 'bg-green-400/[0.8] hover:bg-green-400/[0.8]' : reward.stage >= details.stage || chkdis(reward.stage) || collected}" class="bg-green-600 w-full lg:w-3/5 p-3 rounded-lg text-white font-bold font-sans hover:bg-green-400" :ref="button+'_'+index" @click="collectReward(reward.stage, details.track_id, button+'_'+index)">{{ chkdis(reward.stage) ? 'Collected' : 'Collect'}} rewards for {{ reward.name }}</button>
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
        const rewardoptions = ref(1)
        const rewardoption = ref(0)
        let colresponse = ref(false)
        let collectedstage = ref(0)
        let collected = ref(false)

        userstore.getCollections(details.track_id)

        const route = useRoute();
        const router = useRouter();
        console.log(route.query.upgraded)
        if(route.query.upgraded){

        }
        const upgraded = route.query.upgraded

        function collectReward(stage, track_id,ref){
            userstore.collectReward(stage, track_id).then((response) => {
                // console.log(response.status)
                collectedstage.value = stage
                colresponse.value = response.status
                collected.value = true

    
            })
        }

        const collections = userstore.collections
        // console.log(collections)

        function chkdis(stage){
            let colle = collections.filter(x => x.stage == stage);
            // console.log(colle.length)
            return colle.length > 0 ? true : false
        }
        
        return {
            details,
            rewards,
            downlines,
            upgraded,
            rewardoptions,
            collectReward,
            rewardoption,
            chkdis,
            colresponse,
            collections,
            collectedstage,
            collected
        }
    }
}
</script>

<style lang="scss" scoped>

</style>