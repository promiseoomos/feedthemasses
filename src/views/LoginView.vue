<template>
    <div class="bg-cyan-500 p-2 h-screen">
        <p class="text-xl text-bold text-center">Login</p>
        <div class="w-full lg:w-1/2 h-80 bg-white mx-auto rounded-lg">

            <form>
                <input type="Text"/>
                <InputText placeholder="First Name" />
            </form>
        </div>
    </div>
</template>

<script>
import { reactive, toRefs } from 'vue'
import InputText from 'primevue/inputtext';


export default {
    components : {
        InputText
    },
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