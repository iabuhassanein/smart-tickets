<template>
    <div class="tooltip">
        <slot />
        <span class="tooltiptext">{{ text }}</span>
    </div>
</template>
<script lang="js">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "Tooltip",
    props: {
        text: {
            type: String,
            default: '',
        },
    },
})
</script>

<style scoped>.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 200px;
    background-color: rgba(0, 0, 0, 0.7);
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 10px;

    /* Position the tooltip */
    position: absolute;
    z-index: 1;
    bottom: 100%;
    left: 50%;
    margin-left: -100px;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
</style>
