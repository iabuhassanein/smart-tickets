import axios from 'axios';
import {isIsset} from "../utils/ClassHelper.js";
import Ticket from "./../Models/Ticket";
    // Actions
export function fetchTickets(_page = 1, _search = null, _filters = []) {
    let _filtersQuery = ``
    console.log(_filters)
    if (!!_filters['status'] || !!_filters['category']) {
        _filtersQuery += `${(!!_filters['status'])?'&filters[status]='+_filters['status']:''}`
        _filtersQuery += `${(!!_filters['category'])?'&filters[category]='+_filters['category']:''}`
    }
    return axios.get(`/api/tickets?page=${_page}&search=${_search}${_filtersQuery}`).then(res => {
        if (res.status === 200 && res.data.status===2000){
            let _tickets = []
            res.data?.result?.data.forEach((item, index) => {
                _tickets.push(new Ticket(item))
            })
            return {tickets: _tickets, pagination: res.data?.result.pagination};
        }
    }).catch(err => {
        console.error(err)
    })
}

export function fetchTicket(_id) {
    return axios.get(`/api/tickets/${_id}`).then(res => {
        if (res.status === 200 && res.data.status===2000){
            return res.data.result;
        }
    }).catch(err => {
        console.error(err)
    })
}

export function createTicket(_data = {}) {
    return axios.post(`/api/tickets`, _data).then(res => {
        if (res.status === 200 && res.data.status===2000){
            return true;
        }
    }).catch(err => {
        console.error(err)
    })
}
export function updateTicket(_id, _data = {}) {
    return axios.patch(`/api/tickets/${_id}`, _data).then(res => {
        if (res.status === 200 && res.data.status===2000){
            return res.data.result;
        }
    }).catch(err => {
        console.error(err)
    })
}

export function classifyTicket(_id) {
    return axios.patch(`/api/tickets/${_id}/classify`).then(res => {
        if (res.status === 200 && res.data.status===2000){
            return true;
        }
    }).catch(err => {
        console.error(err)
    })
}

export function checkClassifyTicket(_id) {
    return axios.get(`/api/tickets/${_id}/classify/check`).then(res => {
        if (res.status === 200 && res.data.status===2000){
            return res.data.result;
        }
    }).catch(err => {
        console.error(err)
    })
}
export function dashboardStats() {
    return axios.get(`/api/stats`).then(res => {
        if (res.status === 200 && res.data.status===2000){
            return res.data.result;
        }
    }).catch(err => {
        console.error(err)
    })
}
