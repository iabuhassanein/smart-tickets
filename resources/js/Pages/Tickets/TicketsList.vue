<template>
    <MainLayout>
        <div class="filters">
            <div class="search">
                <input v-model="filter.search" @input="filterList" placeholder="search...">
            </div>
            <div class="filter-status">
                <select v-model="filter.status" @change="refreshList">
                    <option value="">Select Status</option>
                    <option value="new">New</option>
                    <option value="in_progress">In Progress</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <div class="filter-category">
                <select v-model="filter.category" @change="refreshList">
                    <option value="">Select Category</option>
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
            <div class="create-btn">
                <button type="button" @click="openCreateModal">Add</button>
            </div>
        </div>
        <div class="card-header d-flex">
            <div class="subject">
                <h3>Subject</h3>
            </div>
            <div class="category">
                <h3>Category</h3>
            </div>
            <div class="confidence">
                <h3>Confidence</h3>
            </div>
            <div class="explanation">
                <h3>Explanation</h3>
            </div>
            <div class="note">
                <h3>Note</h3>
            </div>
            <div class="controls">
                <h3>Controls</h3>
            </div>

        </div>
        <div v-if="loading" class="loader-container">
            <LoaderIcon />
        </div>
        <div class="tickets-list" v-else>
            <TicketCardH v-for="(item, index) in list"
                         :key="'ticket-item' + item.id"
                         :ticket="item"
            />
        </div>
        <Pagination :pagination="pagination" @goToPage="goToPage" />
        <CreateTicketModal :is-open="isOpenCreateModal" @close="isOpenCreateModal = false"
                           @ticket-created="refreshList"
        />
    </MainLayout>
</template>
<script lang="js">
import {defineComponent} from 'vue'
import MainLayout from "../../Layouts/MainLayout.vue";
import { fetchTickets } from '../../ServerActions/Tickets'
import TicketCardH from "../../components/Tickets/Parts/TicketCardH.vue";
import LoaderIcon from "../../components/Icons/LoaderIcon.vue";
import CreateTicketModal from "../../components/Tickets/CreateTicketModal.vue";
import Pagination from "../../components/Common/Pagination.vue";

export default defineComponent({
    name: "TicketsList",
    components: {Pagination, CreateTicketModal, LoaderIcon, MainLayout, TicketCardH},
    data() {
        return {
            timer: null,
            list: [],
            loading: false,
            isOpenCreateModal: false,
            pagination: {
                total: 0,
                count: 0,
                per_page: 15,
                current_page: 1,
                total_pages: 1,
            },
            filter: {
                search: '',
                status: '',
                category: ''
            },
        }
    },
    mounted() {
        this.fetchList()
    },
    methods: {
        defaultData() {
            return this.$options.data.call(this);
        },
        async fetchList() {
            this.loading = true;
            let _filters = [];
            _filters['status'] = this.filter.status.trim();
            _filters['category'] = this.filter.category.trim();
            let _res = await fetchTickets(this.pagination.current_page, this.filter.search.trim(), _filters);
            this.list = _res.tickets;
            this.pagination = _res.pagination;
            this.loading = false;
        },
        refreshList() {
            this.pagination = this.defaultData().pagination;
            this.fetchList();
        },
        filterList() {
            let _this = this;
            if (_this.timer) {
                clearTimeout(_this.timer);
                _this.timer = null;
            }
            _this.timer = setTimeout(() => {
                _this.refreshList();
            }, 500);
        },
        openCreateModal(){
            this.isOpenCreateModal = true;
        },
        goToPage(page){
            this.pagination.current_page = page;
            this.fetchList();
        }
    }
})
</script>

<style scoped>
.filters {
    display: flex;
    margin-bottom: 20px;
    gap: 20px;
}
.loader-container {
    text-align: center;
    padding: 50px;
}
.create-btn {
    width: 100%;
    display: flex;
    align-items: end;
    justify-content: end;
}
.create-btn button {
    padding: 10px 20px;
}
.card-header {
    width: 100%;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
    margin-bottom: 10px;
}
.subject {
    width: 40%;
    flex: 0 0 40%;
}
.category {
    width: 15%;
    flex: 0 0 15%;
}
.confidence {
    width: 10%;
    flex: 0 0 10%;
}
.explanation {
    width: 10%;
    flex: 0 0 10%;
}
.note {
    width: 10%;
    flex: 0 0 10%;
}
.controls {
    display: flex;
    align-items: end;
    justify-content: end;
    width: 15%;
    flex: 0 0 15%;
}
</style>
