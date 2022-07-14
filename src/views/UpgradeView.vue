<template>
<div>
    <div class="bg-white rounded-md min-h-screen text-center p-3 overflow-x">
        <div class="">
            <p class="text-xl font-bold">You are currently in {{ details.stage_name }} Stage</p>
            <p v-if="downlines.upgradesponsors.length > 0" class="rounded-lg p-2 w-fit mx-auto bg-cyan-500 text-white">
                Upgrade to Next Stage with this Downlines
            </p>
            <div v-if="downlines.upgradesponsors.length > 0">
                <p class="text-lg font-medium" v-if="downlines.upgradesponsors.length < 12">To be Eligible for an Upgrade, 12 of your downlines has to be in {{ details.stage_name }} Stage</p>
                <p>You have {{ downlines.upgradesponsors.length }} downline{{ downlines.upgradesponsors.length > 1 ? 's' : 's' }} in {{ details.stage_name }} Stage</p>
                <div v-for="(downlines, index) in downlines.upgradesponsors" :key="index" class="flex flex-wrap mt-2 text-left">
                    <img class="w-16" src="../assets/012-profile.png">
                    <div class="w-1/2 p-3">
                        <p class="text-xl">{{ downlines.username }}</p>
                        <p class="text-sm">{{ downlines.track_id  }}</p>
                    </div>
                </div>
            </div>
            <div v-else class="my-5">
                <p class="text-3xl font-black"> You are not Eligible for an Upgrade</p>
                <p>To be Eligible for an Upgrade, 12 of your downlines has to be in {{ details.stage_name }} Stage</p>
            </div>

            <button :disabled="!downlines.ripeforupgrade" :class="{ 'bg-green-400/[0.8] hover:bg-green-400/[0.8]' : !downlines.ripeforupgrade }" class="bg-green-600 w-3/5 p-3 rounded-lg text-white font-bold font-sans hover:bg-green-400" @click="upgradeUser">Upgrade to {{ downlines.upgradetoname }}</button>
            
            <div v-if="upgResponse != ''" :class="{ 'text-green-600 bg-green-400/[0.4]' : upgResponse.status, 'text-red-600 bg-red-400/[0.4]' : !upgResponse.status}" class="min-h-20 w-full p-3 mb-3 rounded-md">
                {{ upgResponse.msg }}
            </div>
            <!-- <div class="modal absolute inset-y-1/2 h-56 min-w-[40%] shadow-lg bg-gray-400 rounded-lg p-3">
                        <Skeleton class="mb-2" borderRadius="16px"></Skeleton>
                        <Skeleton width="10rem" class="mb-2"></Skeleton>
                </div> -->
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
    component: {},
    setup() {

        const userstore = userStore();
        const details = userstore.details
        const rewards = userstore.rewards
        const downlines = userstore.downlines
        let upgResponse = ref("");

        const upgradeObj = reactive({
            track_id: details.track_id,
            oldlevel: details.stage,
            oldlevelname: details.stage_name,
            newlevel: downlines.upgradeto,
            newlevelname: downlines.upgradetoname,
            upgradedownlines: downlines.upgradesponsors
        })
        userstore.getDownlines().then((response) => {
            userstore.$patch({
                downlines: response
            })
        })

        const router = useRouter()

        function upgradeUser() {
            return userstore.upgradeUser(upgradeObj).then((response) => {
                upgResponse = response

                userstore.$patch((state) => {
                    state.details.stage = upgradeObj.newlevel
                    state.details.stage_name = upgradeObj.newlevelname
                })
                userstore.getDownlines().then((response) => {
                    console.log(response)
                    userstore.$patch({
                        downlines: response
                    })

                    router.push({
                        name : "rewards",
                        query : { upgraded : true }
                    })
                    console.log(userstore.downlines)
                })
            })
        }

        return {
            details,
            rewards,
            downlines,
            upgradeUser,
            upgResponse
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
