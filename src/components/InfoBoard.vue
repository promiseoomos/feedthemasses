<template>
    <div>
        <div class="">
                <p class="text-2xl lg:text-3xl text-white font-sans font-bold">{{ title }}</p>
                <p class="text-xl lg:text-1xl text-white font-sans font-bold mt-4">{{ subtitle }}</p>
            </div>
    </div>
</template>

<script>
export default {
    props : [ "title", "subtitle"]
}
</script>

<style lang="scss" scoped>

</style>