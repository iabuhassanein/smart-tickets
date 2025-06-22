import {get, isIsset} from './../utils/ClassHelper';
import TicketStatus from "./TicketStatus.js";
import TicketCategory from "./TicketCategory.js";

export default class Ticket {
    _id
    _subject
    _body
    _status
    _category
    _confidence
    _explanation
    _note
    _isOverride

    constructor (r = {}) {
        this.setData(r)
    }

    setData(r = {}) {
        this.id = get(r, 'id', '');
        this.subject = get(r, 'subject', '');
        this.body = get(r, 'body', '');
        this.status = isIsset(r, 'status')?new TicketStatus(get(r, 'status')):new TicketStatus();
        this.category = isIsset(r, 'category')?new TicketCategory(get(r, 'category')):new TicketCategory();
        this.confidence = get(r, 'confidence', 0);
        this.explanation = get(r, 'explanation', '');
        this.note = get(r, 'note', '');
        this.isOverride = get(r, 'isOverride', false);
    }


    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get subject() {
        return this._subject;
    }

    set subject(value) {
        this._subject = value;
    }

    get body() {
        return this._body;
    }

    set body(value) {
        this._body = value;
    }

    get status() {
        return this._status;
    }

    set status(value) {
        this._status = value;
    }

    get category() {
        return this._category;
    }

    set category(value) {
        this._category = value;
    }

    get confidence() {
        return this._confidence;
    }

    set confidence(value) {
        this._confidence = value;
    }

    get explanation() {
        return this._explanation;
    }

    set explanation(value) {
        this._explanation = value;
    }

    get note() {
        return this._note;
    }

    set note(value) {
        this._note = value;
    }

    get isOverride() {
        return this._isOverride;
    }

    set isOverride(value) {
        this._isOverride = value;
    }
}


