<template>
    <div class="overflow-x-auto mt-3">
         <div class="text-center vmore overflow-x-auto text-xs lg:text-lg">
            <div class="flex flex-nowrap justify-between overflow-x-auto">
                <div class="text-left">
                    <p>Showing {{ ((intervalnum * pages) - intervalnum) + 1 }} - {{ endnum > endss ? endss : endnum }}</p>
                </div>
                <div class="text-center">
                    <select id="target" class="p-1 bg-gray-200 text-md border-1 border-gray-400" v-model="localintervalnum" @change="$emit('changeInterval', localintervalnum)" required>
                        <option v-for="(level, index) in levels" :key="index" :value="level">{{ level }}</option>
                    </select>
                </div>
                <div class="text-right overflow-x-auto">
                    <div size="overflow-x-auto">
                        <button v-for="(page, index) in ranger" :key="index" :page="page" :class="[ pages == page ? 'bg-green-700 text-white' : '']" @click="$emit('paginator', page)" class="ml-1 page-buttons w-8 h-8 rounded-md outline-green-600 border border-green-600" size="xs" variant="outline-dark">{{ page }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue"

const props = defineProps({
    intervalnum : [String, Number],
    pages : Number,
    endnum : Number,
    endss : Number,
    datalength : Number
})
const emit = defineEmits(['changeInterval', 'paginator'])

const levels = ref([10, 25, 50, 100, 250, 500])
const localintervalnum = ref(10)
const ranger = computed(() => { return Math.ceil(props.datalength/props.intervalnum)})

</script>

<style lang="scss" scoped>

</style>