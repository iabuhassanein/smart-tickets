<script lang="ts">
import {defineComponent} from 'vue'

export default defineComponent({
    name: "ExplanationIcon",
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
    <svg version="1.1" id="Uploaded to svgrepo.com" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         :width="width+'px'" :height="height+'px'" viewBox="0 0 32 32" xml:space="preserve">
            <path class="blueprint_een" d="M23,17h-7v-1h7V17z M23,18h-7v1h7V18z M23,8h-7v1h7V8z M23,6h-7v1h7V6z M10,22.05V19.95
        c-1.141-0.232-2-1.24-2-2.45c0-1.209,0.859-2.218,2-2.45V9.95C8.859,9.718,8,8.709,8,7.5C8,6.119,9.119,5,10.5,5S13,6.119,13,7.5
        c0,1.209-0.859,2.218-2,2.45v5.101c1.141,0.232,2,1.24,2,2.45c0,1.209-0.859,2.218-2,2.45v2.101c1.141,0.232,2,1.24,2,2.45
        c0,1.381-1.119,2.5-2.5,2.5S8,25.881,8,24.5C8,23.291,8.859,22.282,10,22.05z M10.5,23C9.673,23,9,23.673,9,24.5S9.673,26,10.5,26
        s1.5-0.673,1.5-1.5S11.327,23,10.5,23z M10.5,9C11.327,9,12,8.327,12,7.5S11.327,6,10.5,6S9,6.673,9,7.5S9.673,9,10.5,9z M10.5,19
        c0.827,0,1.5-0.673,1.5-1.5S11.327,16,10.5,16S9,16.673,9,17.5S9.673,19,10.5,19z M29,2v28c0,0.552-0.447,1-1,1H4
        c-0.553,0-1-0.448-1-1V2c0-0.552,0.447-1,1-1h24C28.553,1,29,1.448,29,2z M27,3H5v26h22V3z M23,25h-7v1h7V25z M23,23h-7v1h7V23z"/>
    </svg>
</template>

<style scoped>
.blueprint_een{fill:#111918;}
svg {
    margin-bottom: -5px;
}
</style>
