<script>
    import { useForm } from "@westacks/inertia-svelte";
    import { X as XIcon } from "lucide-svelte";
    import { onMount } from "svelte";

    import TextInput from "../../../components/form/Textinput.svelte";
    import Modal from "../../../components/modal/Modal.svelte";

    export let dialog;

    let form = useForm({
        name: null,
        email: null,
    });

    function createContact() {
        $form.post("/contact", {
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
    <h3 class="font-bold">Add Contact</h3>
    <form on:submit|preventDefault={createContact}>
        <TextInput
            id="name"
            label="Name"
            type="text"
            placeholder="contact name"
            bind:value={$form.name}
            errorMessage={$form.errors.name}
            class="mb-3"
        />
        <TextInput
            id="email"
            label="Email"
            type="text"
            placeholder="contact email"
            bind:value={$form.email}
            errorMessage={$form.errors.email}
            class="mb-3"
        />
        <br />
        <div class="modal-action">
            <button
                type="submit"
                disabled={$form.processing}
                class="btn btn-primary"
            >
                Save
                {#if $form.processing}
                    <span class="loading loading-spinner loading-md" />
                {/if}
            </button>
        </div>
    </form>
</Modal>
