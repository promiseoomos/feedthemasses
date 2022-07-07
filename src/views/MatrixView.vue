<template>
    <div class="overflow-auto">
        <div class="bg-white rounded-md min-h-screen text-center p-3">
            <div class="text-center">
                <img class="text-center mx-auto w-20 h-20" src="@/assets/012-profile.png">
                <p class="font-bold">{{ details.track_id }}</p>
                <p class="font-bold">{{ details.username }}</p>
            </div>
            <div class="h-8 border-0 border-l-2 border-black mx-auto w-1"></div>
            <div class="border-0 border-b-2 border-black mx-auto"></div>
            <div v-if="downlines.hasReferrals" class="overflow-auto">
                <div v-for="(downlines, index) in downlines.data" :key="index" class="overflow-auto">
                    <div class="flex flex-nowrap justify-start overflow-auto">
                        
                        <div v-for="(downline, index) in downlines.referrals" :key="index" class="text-center w-1/2 px-2 border-r-2 last:border-0">
                            <div class="h-4 border-0 border-l-2 border-black mx-auto w-1"></div>
                            <img class="mx-auto w-20 h-20" src="@/assets/012-profile.png">
                            <p class="font-bold">{{ downline.userid }}</p>
                            <p class="font-bold">{{ downline.username }}<br> <span class="p-1 inline-block mx-auto w-fit -mt-1 text-xs bg-green-500 rounded-lg font-bold text-white">{{ downline.stage_name }}</span>
                                <span class="p-1 inline-block mb-2 text-xs bg-green-500 ml-1 rounded-lg font-bold text-white">{{ downline.uplineid }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="border-0 border-b-2 border-black mx-auto"></div>
                    <!-- {{ downlines x}} -->
                </div>
            </div>
            <div v-else class="p-3 mt-3 text-3xl font-sans font-black">You have no Referrals Yet</div>
        </div>
    </div>
</template>

<script>
import { userStore } from "@/stores/user"
import { ref, reactive, nextTick } from "vue"

export default {
    setup () {
        
        const userstore = userStore()
        userstore.getDownlines()
        const downlines = userstore.downlines
        const details = userstore.details

        return {
            downlines,
            details
        }
    }
}
</script>

<style lang="scss" scoped>

</style>