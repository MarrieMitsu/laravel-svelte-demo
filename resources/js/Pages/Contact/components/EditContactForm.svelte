<script>
    import { useForm } from "@westacks/inertia-svelte";
    import { X as XIcon } from "lucide-svelte";
    import { onMount } from "svelte";

    import TextInput from "../../../components/form/Textinput.svelte";
    import Modal from "../../../components/modal/Modal.svelte";

    export let dialog;
    export let payload = {};

    let form = useForm({
        name: null,
        email: null,
    });

    $: if (payload) {
        $form.name = payload.name;
        $form.email = payload.email;
    }

    function updateContact() {
        $form
            .transform((data) => {
                const payload = Object.fromEntries(
                    Object.entries(data).filter(
                        ([key, value]) => value != null,
                    ),
                );

                return payload;
            })
            .put(`/contact/${payload.id}`, {
                onSuccess: async () => {
                    dialog.close();
                },
            });
    }

    function onCloseListener(event) {
        // delay 200ms to match the dialog transition
        setTimeout(() => {
            payload = {};
        }, 200);
        $form.clearErrors();
    }

    onMount(() => {
        dialog.addEventListener("close", onCloseListener);

        return () => {
            dialog.removeEventListener("close", onCloseListener);
        };
    });
</script>

<Modal signature={payload.id} bind:dialog>
    <form name={payload.id} method="dialog">
        <button class="btn btn-circle btn-ghost absolute right-2 top-2">
            <XIcon />
        </button>
    </form>
    <h3 class="font-bold text-lg">Edit Contact</h3>
    <form on:submit|preventDefault={updateContact}>
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
