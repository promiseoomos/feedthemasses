<template>
    <div>
        <div class="flex flex-wrap justify-between p-1 gap-2">
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'User ID'" :subtitle="details.track_id"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Username'" :subtitle="details.username"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Sponsor ID'" :subtitle="details.referrer_id"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Sponsor Name'" :subtitle="details.referrer_username"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total Referrals'" :subtitle="details.referrals_count + '/3'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Stage'" :subtitle="details.stage"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Cash Reward Wallet'" :subtitle="'0.00'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Food Reward Wallet'" :subtitle="'0.00'"/>
        </div>
    </div>
</template>

<script>
import InfoBoard from '@/components/InfoBoard.vue';
import { userStore } from '@/stores/user';

export default {
    setup () {
        
        const userstore = userStore();
        const details = userstore.details;

        return {
            details
        }
    },
    components : {
        InfoBoard
    }
}
</script>

<style lang="scss" scoped>

</style>