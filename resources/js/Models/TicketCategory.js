import {get} from './../utils/ClassHelper';

export default class TicketCategory {
    _value
    _label

    constructor (r = {}) {
        this.setData(r)
    }

    setData(r = {}) {
        this.value = get(r, 'value', '')??"";
        this.label = get(r, 'label', '')??"";
    }


    get value() {
        return this._value;
    }

    set value(value) {
        this._value = value;
    }

    get label() {
        return this._label;
    }

    set label(value) {
        this._label = value;
    }
}


