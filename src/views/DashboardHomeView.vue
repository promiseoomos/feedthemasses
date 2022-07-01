<template>
    <div>
        <div class="flex flex-wrap justify-between p-1 gap-2">
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'User ID'" :subtitle="'101238475'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Username'" :subtitle="'promiseomos'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Sponsor ID'" :subtitle="'1023485787'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Sponsor Name'" :subtitle="'amadichenu'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total Referrals'" :subtitle="'2/3'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Stage'" :subtitle="'Stage 2'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Cash Reward Wallet'" :subtitle="'2500'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Food Reward Wallet'" :subtitle="'35000'"/>
        </div>
    </div>
</template>

<script>
import InfoBoard from '@/components/InfoBoard.vue';

export default {
    setup () {
        

        return {}
    },
    components : {
        InfoBoard
    }
}
</script>

<style lang="scss" scoped>

</style>