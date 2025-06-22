<template>
    <button type="button" @click="classifyTicket">{{ classifyLabel }}</button>
</template>
<script lang="js">
import {defineComponent} from 'vue'
import Tooltip from "../../Common/Tooltip.vue";
import Ticket from "../../../Models/Ticket.js";
import {checkClassifyTicket, classifyTicket} from "../../../ServerActions/Tickets.js";

export default defineComponent({
    name: "ClassifyButton",
    components: {Tooltip},
    props: {
        ticket: {
            type: Ticket,
            required: true
        },
    },
    data() {
        return {
            classifying: false,
            pollInterval: null
        }
    },
    computed: {
        classifyLabel(){
            return this.classifying?"Working...":"Classify"
        }
    },
    beforeUnmount() {
        this.stopPolling();
    },
    methods: {
        classifyTicket(){
            let _this = this;
            _this.classifying = true;
            classifyTicket(this.ticket.id).then(res => {
                // _this.ticket.setData(res)
                console.log('ticket classifying...')
                _this.startPolling();

            }).finally(() => {
                // _this.classifying = false;
            })
        },
        startPolling() {
            this.pollInterval = setInterval(() => {
                this.checkClassificationStatus();
            }, 1500);
        },
        stopPolling() {
            if (this.pollInterval) {
                clearInterval(this.pollInterval);
                this.pollInterval = null;
            }
        },
        checkClassificationStatus() {
            let _this = this
            checkClassifyTicket(this.ticket.id).then(response => {
                if (response.isFinished) {
                    // Update ticket with new data
                    _this.ticket.setData(response.ticket);
                    console.log('Classification completed!');
                    _this.classifying = false;
                    _this.stopPolling();
                }
                // If status is 'processing', continue polling
            }).catch(error => {
                console.error('Error checking status:', error);
                _this.classifying = false;
                _this.stopPolling();
            });
        }
    }
})
</script>

<style scoped>

</style>
