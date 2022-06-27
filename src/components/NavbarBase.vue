<template>
    <div class="bg-gradient-to-r from-white to-sky-700 h-20">
        <p class="text-left p-2 pt-6 text-xl font-sans font-bold">FeedtheMasses</p>
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