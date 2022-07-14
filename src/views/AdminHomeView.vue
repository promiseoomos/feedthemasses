<template>
    <div>
        <div class="flex flex-wrap justify-between p-1 gap-2">
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total Users'" :subtitle="infostats.total_users"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total Revenue'" :subtitle="'N' + infostats.total_revenue"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total Vouchers Generated'" :subtitle="infostats.total_vouchers"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total Vouchers Used'" :subtitle="infostats.total_vouchers_used"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total Collections requested'" :subtitle="infostats.total_collections_requested"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total Collections Given'" :subtitle="infostats.total_collections_collected"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total dispensed CRW'" :subtitle="'0.00'"/>
            <InfoBoard class="h-40 w-[48%] rounded-md bg-blue-700/[0.6] p-2" :title="'Total dispensed FRW'" :subtitle="'0.00'"/>
        </div>
    </div>
</template>

<script>
import InfoBoard from '@/components/InfoBoard.vue';
import { adminStore } from '@/stores/admin';

export default {
    setup () {
        
        const adminstore = adminStore();
        adminstore.getInfostats();
        const infostats = adminstore.infostats;

        return {
            infostats
        }
    },
    components : {
        InfoBoard
    }
}
</script>

<style lang="scss" scoped>

</style>