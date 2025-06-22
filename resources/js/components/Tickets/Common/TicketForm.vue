<template>
    <div class="form">
        <form @submit="()=>{}">
            <div class="form-block">
                <label>Subject</label>
                <input type="text" placeholder="Enter Subject..." v-model="ticket.subject" :disabled="isEdit">
            </div>
            <div class="form-block">
                <label>Body</label>
                <textarea placeholder="Enter Body..." v-model="ticket.body" :disabled="isEdit"></textarea>
            </div>
            <template v-if="isEdit">
                <div class="form-block">
                    <label>status</label>
                    <select v-model="ticket.status.value">
                        <option value="">Select Status...</option>
                        <option value="new">New</option>
                        <option value="in_progress">In Progress</option>
                        <option value="done">Done</option>
                    </select>
                </div>
                <div class="form-block">
                    <label>Category</label>
                    <select v-model="ticket.category.value">
                        <option value="">Select Category...</option>
                        <option value="technical_support">Technical Support</option>
                        <option value="billing_payment">Billing & Payment</option>
                        <option value="account_access">Account Access</option>
                        <option value="bug_report">Bug Report</option>
                        <option value="feature_request">Feature Request</option>
                        <option value="general_inquiry">General Inquiry</option>
                        <option value="refund_request">Refund Request</option>
                        <option value="installation_help">Installation Help</option>
                        <option value="performance_issue">Performance Issue</option>
                        <option value="security_concern">Security Concern</option>
                        <option value="data_export">Data Export</option>
                        <option value="integration_support">Integration Support</option>
                    </select>
                </div>
                <div class="form-block">
                    <label>Note</label>
                    <textarea placeholder="Enter Note..." v-model="ticket.note"></textarea>
                </div>
            </template>
        </form>
    </div>
</template>
<script lang="js">
import {defineComponent} from 'vue'
import Ticket from "../../../Models/Ticket.js";

export default defineComponent({
    name: "TicketForm", props: {
        ticket: {
            type: Ticket,
            required: true,
        },
        isEdit: {
            type: Boolean,
            required: false,
            default: false
        }
    }
})
</script>


<style scoped>
.form-block {
    float: left;
    width: 100%;
    padding: 10px;
    border-bottom: 1px solid #ccc;
    margin-bottom: 10px;
    display: block;
}
.form-block:last-child {
    border-bottom: 0;
}
.form-block label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.form-block input, .form-block textarea, .form-block select {
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
}
.form-block textarea {
    height: 100px;
}
</style>
