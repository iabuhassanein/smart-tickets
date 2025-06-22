<template>
    <div class="pagination">
        <ul class="outer">
            <li
                class="item"
                :class="{
            active: pagination.current_page === 1
          }"
                @click="goToPage(1)">
                1
            </li>
            <li class="item" v-if="pagination.current_page-max>2">...</li>
            <template v-for="i in Array.from({length: parseInt(pagination.total_pages)},(v,k)=>k+1)">
                <li
                    v-if="i>1 && i<=pagination.total_pages && (pagination.current_page-max)<=i && i<=(pagination.current_page+max)"
                    :key="'page_' + i"
                    class="item"
                    :class="{ active: pagination.current_page === i }"
                    @click="goToPage(i)">
                    {{ i }}
                </li>
            </template>
            <li class="item" v-if="pagination.total_pages-pagination.current_page>=max+2">...</li>
            <li
                v-if="pagination.total_pages > max"
                class="item"
                :class="{
          active: pagination.current_page === pagination.total_pages,
        }"
                @click="goToPage(pagination.total_pages)">
                {{ pagination.total_pages }}
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    name: 'Pagination',
    props: {
        pagination: {
            type: Object,
            required: true,
            default: null,
        },
    },
    data() {
        return {
            max: 5,
        }
    },
    methods: {
        goToPage(_page){
            this.$emit('goToPage', _page)
        }
    }
}
</script>

<style scoped>
.pagination {
    align-content: center;
    text-align: center;
    padding: 20px;
}
.outer {
    display: inline-flex;
    text-align: left;
    margin-bottom: 20px;
    list-style: none;
}
.item {
    height: 40px;
    width: 40px;
    text-align: center;
    line-height: 40px;
    margin: 0 5px;
    border-radius: 5px;
    cursor: pointer;
    padding: 0 5px;
    border: 1px solid #ccc;
}
.item:first-child {
    margin-left: 0;
}
.item:last-child {
    margin-right: 0;
}
.item:hover {
    background-color: #ccc;
}
.active {
    background-color: #007bff;
    color: white;
}
</style>
