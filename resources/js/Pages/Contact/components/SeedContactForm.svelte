<script>
    import { useForm } from "@westacks/inertia-svelte";
    import { X as XIcon } from "lucide-svelte";
    import { onMount } from "svelte";

    import TextInput from "../../../components/form/Textinput.svelte";
    import Modal from "../../../components/modal/Modal.svelte";

    export let dialog;

    let form = useForm({
        amount: null,
    });

    function seedContact() {
        $form.post("/seed-contact", {
            onSuccess: async () => {
                dialog.close();
            },
        });
    }

    function onCloseListener(event) {
        $form.clearErrors();
        $form.reset();
    }

    onMount(() => {
        dialog.addEventListener("close", onCloseListener);

        return () => {
            dialog.removeEventListener("close", onCloseListener);
        };
    });
</script>

<Modal signature={true} bind:dialog>
    <form method="dialog">
        <button class="btn btn-circle btn-ghost absolute right-2 top-2">
            <XIcon />
        </button>
    </form>
    <h3 class="font-bold text-lg">Seed Contact</h3>
    <form on:submit|preventDefault={seedContact}>
        <TextInput
            id="amount"
            label="Amount"
            type="number"
            placeholder="0"
            bind:value={$form.amount}
            errorMessage={$form.errors.amount}
            class="mb-3"
        />
        <br />
        <div class="modal-action">
            <button
                type="submit"
                disabled={$form.processing}
                class="btn btn-primary"
            >
                Seed
                {#if $form.processing}
                    <span class="loading loading-spinner loading-md" />
                {/if}
            </button>
        </div>
    </form>
</Modal>
