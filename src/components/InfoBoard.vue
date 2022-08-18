<template>
    <div>
        <div class="overflow-wrap">
                <p class="text-xl lg:text-2xl text-white font-sans font-bold">{{ title }}</p>
                <p class="text-md lg:text-xl text-white font-sans font-bold mt-4">{{ subtitle }}</p>
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