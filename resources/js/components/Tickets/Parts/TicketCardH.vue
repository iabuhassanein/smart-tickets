<template>
    <div class="ticket-card-h d-flex">
        <div class="subject">
            <h4>{{ ticket.subject }}</h4>
        </div>
        <div class="category">
            <div class="d-flex">
                <select v-model="ticket.category.value" @change="updateCategory">
                    <option value="">None</option>
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
        </div>
        <div class="confidence">
            <p>{{ ticket.confidence }}</p>
        </div>
        <div class="explanation">
            <Tooltip :text="ticket.explanation||'No Explanation yet!'" position="top">
                Explanation: <ExplanationIcon :width="24" :height="20" />
            </Tooltip>
        </div>
        <div class="note">
            <Tooltip :text="ticket.note||'No Note added!'" position="top">
                Note: <NoteIcon :width="24" :height="20" v-if="ticket.note" /> <span v-else>none</span>
            </Tooltip>
        </div>
        <div class="controls">
            <Tooltip text="Classify the ticket using AI" position="top">
                <ClassifyButton :ticket="ticket" />
            </Tooltip>
            <Tooltip text="View Ticket" position="top">
                <router-link :to="'/ticket/'+ticket.id"><ViewIcon :width="24" :height="20" /></router-link>
            </Tooltip>
            <Tooltip text="Edit Ticket" position="top">
                <EditIcon :width="24" :height="20" @click="openEdit" />
            </Tooltip>
            <Tooltip text="Delete Ticket" position="top">
                <TrashIcon :width="24" :height="20" />
            </Tooltip>
        </div>
        <EditTicketModal :is-open="isEdit" :ticket="ticket" @close="isEdit = false" />
    </div>
</template>
<script lang="js">
import {defineComponent} from 'vue'
import Ticket from "../../../Models/Ticket.js";
import ExplanationIcon from "../../Icons/ExplanationIcon.vue";
import Tooltip from "../../Common/Tooltip.vue";
import NoteIcon from "../../Icons/NoteIcon.vue";
import ViewIcon from "../../Icons/ViewIcon.vue";
import EditIcon from "../../Icons/EditIcon.vue";
import TrashIcon from "../../Icons/TrashIcon.vue";
import LoaderIcon from "../../Icons/LoaderIcon.vue";
import {checkClassifyTicket, classifyTicket, updateTicket} from '../../../ServerActions/Tickets'
import EditTicketModal from "../EditTicketModal.vue";
import ClassifyButton from "../Common/ClassifyButton.vue";

export default defineComponent({
    name: "TicketCardH",
    components: {
        ClassifyButton,
        EditTicketModal, LoaderIcon, TrashIcon, EditIcon, ViewIcon, NoteIcon, Tooltip, ExplanationIcon},
    props: {
        ticket: {
            type: Ticket,
            default: new Ticket(),
        },
    },
    data() {
        return {
            isEdit: false,
        }
    },
    methods: {
        updateCategory() {
            let _this = this
            if (_this.ticket.category.value.trim() === '') return
            updateTicket(_this.ticket.id, {category: _this.ticket.category.value}).then(res => {
               _this.ticket.setData(res)
               console.log('category updated')
            })
        },
        openEdit(){
            this.isEdit = true;
        },
    }
})
</script>
<style scoped>
.ticket-card-h {
    width: 100%;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    margin-bottom: 20px;
    background-color: white;
}
.subject {
    width: 40%;
    flex: 0 0 40%;
    overflow: hidden;
    text-overflow: ellipsis;
    padding-right: 20px;
}
.category {
    width: 15%;
    flex: 0 0 15%;
    overflow: hidden;
    text-overflow: ellipsis;
}
.confidence {
    width: 10%;
    flex: 0 0 10%;
    overflow: hidden;
    text-overflow: ellipsis;
    padding-left: 10px;
}
.explanation {
    width: 10%;
    flex: 0 0 10%;
    text-overflow: ellipsis;
}
.note {
    width: 10%;
    flex: 0 0 10%;
    text-overflow: ellipsis;
}
.controls {
    display: flex;
    align-items: end;
    justify-content: end;
    width: 15%;
    flex: 0 0 15%;
    gap: 15px;
}
.controls > div{
  cursor: pointer;
}
</style>
