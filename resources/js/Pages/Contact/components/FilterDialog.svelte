<script>
    import { router } from "@westacks/inertia-svelte";
    import { X as XIcon } from "lucide-svelte";

    import Select from "../../../components/form/Select.svelte";
    import TextInput from "../../../components/form/Textinput.svelte";
    import Modal from "../../../components/modal/Modal.svelte";

    export let dialog;
    export let name = "";
    export let email = "";
    export let limit;

    const pageLimit = [5, 10, 15, 20, 25, 50];

    function filter() {
        const obj = {};

        if (name) {
            obj.name = name;
        }

        if (email) {
            obj.email = email;
        }

        if (limit) {
            obj.limit = limit;
        }

        dialog.close();
        router.get("/", obj);
    }

    function reset() {
        name = "";
        email = "";
        limit = 10;

        dialog.close();
        router.get("/");
    }
</script>

<Modal signature={true} bind:dialog>
    <form method="dialog">
        <button class="btn btn-circle btn-ghost absolute right-2 top-2">
            <XIcon />
        </button>
    </form>
    <h3 class="font-bold text-lg">Filter Contacts</h3>
    <TextInput
        id="name"
        label="Name"
        type="text"
        placeholder="contact name"
        bind:value={name}
        class="mb-3"
    />
    <TextInput
        id="email"
        label="Email"
        type="text"
        placeholder="contact email"
        bind:value={email}
        class="mb-3"
    />
    <Select label="Per Page" bind:value={limit}>
        {#each pageLimit as l}
            <option value={l}>{l}</option>
        {/each}
    </Select>
    <br />
    <div class="modal-action">
        <button on:click={reset} type="submit" class="btn btn-primary">
            Reset
        </button>
        <button on:click={filter} type="submit" class="btn btn-primary">
            Filter
        </button>
    </div>
</Modal>
