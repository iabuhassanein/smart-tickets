<template>
    <MainLayout :show-back-button="true">
        <div class="card-info">
            <div v-if="loading" class="loader-container">
                <LoaderIcon />
            </div>
            <div class="ticket-content" v-else>
                <div class="info-block">
                    <label><strong>Subject: </strong></label>
                    <p>{{ ticket.subject }}</p>
                </div>
                <div class="info-block">
                    <label><strong>Body: </strong></label>
                    <p>{{ ticket.body }}</p>
                </div>
                <div class="info-block">
                    <label><strong>Status: </strong></label>
<!--                    <p>{{ ticket.status.label || '' }}</p>-->
                    <p>
                        <select v-model="ticket.status.value" @change="updateStatus">
                            <option value="new">New</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </p>
                </div>
                <div class="info-block">
                    <div class="d-flex note-form">
                        <label><strong>category: </strong></label>
                        <div class="cntl-btns">
                            <ClassifyButton :ticket="ticket" />
                        </div>
                    </div>
                    <p>
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
                    </p>
                </div>
                <div class="info-block">
                    <label><strong>Confidence: </strong></label>
                    <p>{{ ticket.confidence }}</p>
                </div>
                <div class="info-block">
                    <label><strong>Explanation: </strong></label>
                    <p>{{ ticket.explanation }}</p>
                </div>
                <div class="info-block">
                    <div class="d-flex note-form">
                        <label><strong>Note: </strong></label>
                        <div class="cntl-btns">
                            <template v-if="openEditNote">
                                <button type="button" @click="saveNote">Save</button>
                                <button type="button" @click="cancelEditNote">Cancel</button>
                            </template>
                            <button v-else type="button" @click="editNote">Edit</button>
                        </div>
                    </div>
                    <textarea v-if="openEditNote" v-model="noteInput"></textarea>
                    <p v-else>{{ ticket.note }}</p>
                    <div class=""></div>
                </div>
                <div class="info-block">
                    <label><strong>isOverride: </strong></label>
                    <p>{{ ticket.isOverride?'Yes':'No' }}</p>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
<script lang="js">
import {defineComponent} from 'vue'
import MainLayout from "../../Layouts/MainLayout.vue";
import LoaderIcon from "../../components/Icons/LoaderIcon.vue";
import {fetchTicket, updateTicket} from "../../ServerActions/Tickets.js";
import Ticket from "../../Models/Ticket.js";
import ClassifyButton from "../../components/Tickets/Common/ClassifyButton.vue";

export default defineComponent({
    name: "ViewTicket",
    components: {ClassifyButton, LoaderIcon, MainLayout},
    data() {
        return {
            loading: true,
            ticket: new Ticket(),
            openEditNote: false,
            noteInput: ''
        }
    },
    mounted() {
        this.fetchTicket()
    },
    methods: {
        fetchTicket() {
            let _this = this;
            _this.loading = true;
            fetchTicket(_this.$route.params.id).then(res => {
                _this.ticket.setData(res);
            }).catch(err => {
                    console.error(err)
            }).finally(() => {
                _this.loading = false;
            })
        },
        editNote(){
            this.noteInput = this.ticket.note+"";
            this.openEditNote = true;
        },
        cancelEditNote(){
            this.openEditNote = false;
        },
        updateCategory() {
            let _this = this
            updateTicket(_this.ticket.id, {category: _this.ticket.category.value}).then(res => {
                _this.ticket.setData(res)
                console.log('category updated')
            })
        },
        saveNote(){
            let _this = this
            _this.ticket.note = _this.noteInput+"";
            updateTicket(_this.ticket.id, {note: _this.noteInput}).then(res => {
                _this.ticket.setData(res)
                console.log('note updated')
            })
            this.openEditNote = false;
        },
        updateStatus(){
            let _this = this
            updateTicket(_this.ticket.id, {status: _this.ticket.status.value}).then(res => {
                _this.ticket.setData(res)
                console.log('status updated')
            })
        }
    }
})
</script>

<style scoped>
.loader-container {
    text-align: center;
    padding: 50px;
}
.card-info {
    width: 100%;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    margin-bottom: 10px;
    overflow: hidden;
}
.info-block {
    float: left;
    width: 100%;
    padding: 10px;
    border-bottom: 1px solid #ccc;
    margin-bottom: 20px;
    display: block;
}
.info-block p {
    margin-top: 5px;
}
.note-form label {
    width: 70%;
    flex: 0 0 70%;
}
.cntl-btns{
    display: flex;
    align-items: end;
    justify-content: end;
    width: 30%;
    flex: 0 0 30%;
    gap: 15px;
}
textarea {
    width: 100%;
    margin-top: 10px;
}
</style>
