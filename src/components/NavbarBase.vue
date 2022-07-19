<template>
    <div class="bg-white p-3">
        <img src="@/assets/logo.jpg" class="ml-10" />
        <!-- <p class="text-left p-2 pt-6 text-xl font-sans font-bold">FeedtheMasses</p> -->
    </div>
</template>

<script>
import { reactive, toRefs } from 'vue'

export default {
    setup () {
        const state = reactive({
            count: 0,
        })
    
        return {
            ...toRefs(state),
        }
    }
}
</script>

<style lang="scss" scoped>

</style>