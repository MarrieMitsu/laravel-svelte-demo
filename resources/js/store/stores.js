import { writable } from "svelte/store";

/**
 * queueStore
 *
 * @param {Array<any>} array
 */
function queueStore(array = []) {
    const { subscribe, update } = writable(array);

    function insert(obj) {
        update((arr) => {
            arr.unshift(obj);
            return arr;
        });
    }

    function push(obj) {
        update((arr) => {
            arr.push(obj);
            return arr;
        });
    }

    function popIndex(index) {
        if (index === undefined || isNaN(index)) {
            return;
        }

        update((arr) => {
            if (arr.length <= 0) return arr;

            arr.splice(index, 1);

            return arr;
        });
    }

    function pop(cb) {
        if (cb === undefined || cb === "function") {
            return;
        }

        update((arr) => {
            if (arr.length <= 0) return arr;

            cb(arr);

            return arr;
        });
    }

    return { subscribe, insert, push, popIndex, pop };
}

/**
 * @typedef {"info" | "success" | "warning" | "error"} AlertType
 */

/**
 * alertManager
 *
 */
function alertManager() {
    let identifier = 0;
    const { subscribe, ...queue } = queueStore();

    /**
     *
     * @param {AlertType} type
     * @param {string} msg
     */
    function push(type, msg) {
        identifier += 1;

        const obj = {
            id: identifier,
            type: type,
            message: msg,
        };

        queue.insert(obj);
    }

    /**
     *
     * @param {number} id
     */
    function pop(id) {
        if (id === undefined || isNaN(id)) {
            return arr;
        }

        queue.pop((arr) => {
            const index = arr.findIndex(e => e.id === id);

            arr.splice(index, 1);
        });
    }

    /**
     *
     * @param {string} msg
     */
    function info(msg) {
        push('info', msg);
    }

    /**
     *
     * @param {string} msg
     */
    function success(msg) {
        push('success', msg);
    }

    /**
     *
     * @param {string} msg
     */
    function warning(msg) {
        push('warning', msg);
    }

    /**
     *
     * @param {string} msg
     */
    function error(msg) {
        push('error', msg);
    }

    return { subscribe, push, pop, info, success, warning, error };
}

export const alert = alertManager();

/**
 * @typedef {"confirm_dialog"} ModalType
 */

/**
 * @typedef {{
 *  title: string,
 *  message: string,
 *  confirmLabel: string,
 *  onConfirm: function(): void
 *  onClose: function(): void
 * }} ConfirmDialogPayload
 */

/**
 * @typedef {{
 *  id: number,
 *  type: ModalType,
 *  payload: ConfirmDialogPayload
 * }} ModalPayload
 */

/**
 * modalManager
 */
function modalManager() {
    let identifier = 0;
    const { subscribe, ...queue } = queueStore();

    /**
     *
     * @param {ModalType} type
     * @param {*} payload
     */
    function push(type, payload) {
        identifier += 1;

        /** @type {ModalPayload} */
        const obj = {
            id: identifier,
            type: type,
            payload: payload,
        };

        queue.push(obj);
    }

    /**
     *
     * @param {number} id
     */
    function pop(id) {
        if (id === undefined || isNaN(id)) {
            return arr;
        }

        queue.pop((arr) => {
            const index = arr.findIndex(e => e.id === id);

            arr.splice(index, 1);
        });
    }

    /**
     *
     * @param {ConfirmDialogPayload} data
     */
    function confirmDialog(data) {
        push('confirm_dialog', data);
    }

    return { subscribe, push, pop, confirmDialog };
}

export const modal = modalManager();
