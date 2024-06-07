<script>
    import Modal from "./Modal.svelte";

    export let id;
    export let dialog;
    export let signature;
    export let title;
    export let message;
    export let confirmLabel;
    export let onConfirm;
    export let onClose;
</script>

<Modal {id} {signature} bind:dialog>
    <h3 class="font-bold">{title}</h3>
    <p class="py-4">{message}</p>
    <div class="modal-action">
        <button class="btn btn-neutral" on:click={onConfirm}>
            {confirmLabel ?? "Confirm"}
        </button>
        <button class="btn" on:click={onClose}>Close</button>
    </div>
</Modal>
