<script>
    import { onMount } from "svelte";
    import { modal } from "../../store/stores";
    import ConfirmDialog from "../modal/ConfirmDialog.svelte";

    let signature;
    let isModalOpen = false;
    let currentModal;

    let confirmDialog;
    /**
     * @type {import('../../store/stores').ConfirmDialogPayload}
     */
    let confirmDialogPayload = {};

    function handleModalNextQueue() {
        if ($modal.length === 0 || isModalOpen) return;
        /**
         * @type {import('../../store/stores').ModalPayload}
         */
        const item = $modal[0];
        isModalOpen = true;
        currentModal = item;
        signature = Symbol();

        if (item.type === "confirm_dialog") {
            confirmDialogPayload = item.payload;
            confirmDialog.showModal();
        }
    }

    function onCloseListener(event) {
        if (isModalOpen) {
            if (currentModal.type === "confirm_dialog") {
                confirmDialogPayload.onClose?.call();
            }

            // delay 200ms to match the dialog transition
            setTimeout(() => {
                isModalOpen = false;
                signature = undefined;
                modal.pop(currentModal.id);
                handleModalNextQueue();
            }, 200);
        }
    }

    onMount(() => {
        confirmDialog.addEventListener("close", onCloseListener);

        return () => {
            confirmDialog.removeEventListener("close", onCloseListener);
        };
    });

    $: if ($modal.length !== 0) {
        handleModalNextQueue();
    }
</script>

<ConfirmDialog
    {signature}
    bind:dialog={confirmDialog}
    title={confirmDialogPayload.title}
    message={confirmDialogPayload.message}
    confirmLabel={confirmDialogPayload.confirmLabel}
    onConfirm={() => {
        if (isModalOpen && confirmDialogPayload) {
            confirmDialogPayload.onConfirm?.call();

            confirmDialog.close();
        }
    }}
    onClose={() => {
        confirmDialog.close();
    }}
/>
