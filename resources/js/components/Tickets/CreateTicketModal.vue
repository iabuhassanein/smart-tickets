<template>
    <div v-if="isOpen" class="modal-overlay" @click="closeModal">
        <div class="modal-container" @click.stop>
            <div class="modal-header">
                <h3>Create Ticket</h3>
                <button class="modal-close-btn" @click="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <TicketForm :ticket="ticket" />
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" @click="closeModal" :disabled="submitting">Cancel</button>
                <button class="btn btn-primary" @click="handleSubmit" :disabled="submitting">{{ submitLabel }}</button>
            </div>
        </div>
    </div>
</template>

<script lang="js">
import {defineComponent} from 'vue'
import TicketForm from "./Common/TicketForm.vue";
import Ticket from "../../Models/Ticket.js";
import {createTicket} from "../../ServerActions/Tickets.js";

export default defineComponent({
    name: "CreateTicketModal",
    components: {TicketForm},
    props: {
        isOpen: {
            type: Boolean,
            required: true,
        },
    },
    data() {
        return {
            ticket: new Ticket(),
            submitting: false
        }
    },
    computed: {
        submitLabel(){
            return (this.submitting)?"Submitting...":"Submit"
        }
    },
    mounted() {
        // Close modal on ESC key press
        document.addEventListener('keydown', this.handleKeydown);
    },
    beforeUnmount() {
        document.removeEventListener('keydown', this.handleKeydown);
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        handleSubmit() {
            let _this = this;
            _this.submitting = true
            createTicket({subject: _this.ticket.subject, body: _this.ticket.body}).then(response => {
                if (response){
                    _this.closeModal();
                    _this.$emit('ticket-created');
                }
            }).finally(() => {
                _this.submitting = false
            })
        },
        handleKeydown(event) {
            if (event.key === 'Escape' && this.isOpen) {
                this.closeModal();
            }
        }
    }
})
</script>

<style scoped>

</style>
