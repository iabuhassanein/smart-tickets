<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "NoteIcon",
    props: {
        width: {
            type: Number,
            default: 32,
        },
        height: {
            type: Number,
            default: 32,
        },
    },
})
</script>

<template>
    <svg fill="#000000" :width="width+'px'" :height="height+'px'" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
        <path d="m1783.68 1468.235-315.445 315.445v-315.445h315.445Zm-541.327-338.823v112.94h-903.53v-112.94h903.53Zm338.936-338.824V903.53H338.824V790.59h1242.465ZM621.176 0c93.403 0 169.412 76.01 169.412 169.412 0 26.09-6.437 50.484-16.94 72.62L999.98 468.255l-79.962 79.962-226.221-226.334c-22.137 10.504-46.532 16.942-72.622 16.942-93.402 0-169.411-76.01-169.411-169.412C451.765 76.009 527.775 0 621.176 0Zm395.295 225.882v112.942h790.588v1016.47h-451.765v451.765H112.941V338.824h225.883V225.882H0V1920h1421.478c45.176 0 87.755-17.619 119.717-49.581l329.224-329.11c31.962-32.076 49.581-74.655 49.581-119.831V225.882h-903.53Z" fill-rule="evenodd"/>
    </svg>
</template>

<style scoped>
svg {
    margin-bottom: -5px;
}
</style>
