<template>
    <div>
        <div class="flex flex-wrap justify-between p-1 gap-2">
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'User ID'" :subtitle="details.track_id"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Username'" :subtitle="details.username"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Sponsor ID'" :subtitle="details.referrer_id"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Sponsor Name'" :subtitle="details.referrer_username"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total Referrals'" :subtitle="details.referrals_count"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Stage'" :subtitle="`Stage ${details.stage} (${details.stage_name})`"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Cash Reward Wallet'" :subtitle="cashrewardwallet"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Food Reward Wallet'" :subtitle="foodrewardwallet"/>
        </div>
    </div>
</template>

<script>
import InfoBoard from '@/components/InfoBoard.vue';
import { userStore } from '@/stores/user';
import { ref } from "vue"

export default {
    setup () {
        
        const userstore = userStore();
        const details = userstore.details;
        const rewards = userstore.rewards
        let foodrewardwallet = ref("")
        let cashrewardwallet = ref("")

        rewards.forEach((item) => {
            // console.log(item.stage + "-- " + details.stage)
            if(item.stage == details.stage){
                foodrewardwallet = item.food_reward_wallet
                cashrewardwallet = item.cash_reward_wallet    
            }
        })

        return {
            details,
            foodrewardwallet,
            cashrewardwallet
        }
    },
    components : {
        InfoBoard
    }
}
</script>

<style lang="scss" scoped>

</style>