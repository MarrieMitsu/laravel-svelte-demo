<script>
    import { router } from "@westacks/inertia-svelte";
    import { Filter as FilterIcon } from "lucide-svelte";

    import { modal } from "../../store/stores";
    import CreateContactForm from "./components/CreateContactForm.svelte";
    import EditContactForm from "./components/EditContactForm.svelte";
    import FilterDialog from "./components/FilterDialog.svelte";
    import SeedContactForm from "./components/SeedContactForm.svelte";

    export let contacts;

    let addContactDialog;
    let editContactDialog;
    let seedContactDialog;
    let filterDialog;

    let nameFilter;
    let emailFilter;
    let limitFilter = 10;

    let editPayload = {};

    function constructQueryParameter() {
        const obj = {};

        if (nameFilter) {
            obj.name = nameFilter;
        }

        if (emailFilter) {
            obj.email = emailFilter;
        }

        if (limitFilter) {
            obj.limit = limitFilter;
        }

        return obj;
    }

    function previousPage() {
        if (contacts.links.prev) {
            router.get("/", {
                page: contacts.meta.current_page - 1,
                ...constructQueryParameter(),
            });
        }
    }

    function nextPage() {
        if (contacts.links.next) {
            router.get("/", {
                page: contacts.meta.current_page + 1,
                ...constructQueryParameter(),
            });
        }
    }

    function deleteContact(id) {
        if (id) {
            modal.confirmDialog({
                title: "Delete contact",
                message: "Are you sure want to delete this contact?",
                confirmLabel: "Delete",
                onConfirm: () => {
                    router.delete(`/contact/${id}`, {
                        preserveScroll: true,
                    });
                },
            });
        }
    }
</script>

<svelte:head>
    <title>Laravel-Svelte Demo</title>
</svelte:head>

<div class="p-6">
    <CreateContactForm bind:dialog={addContactDialog} />
    <EditContactForm bind:dialog={editContactDialog} payload={editPayload} />
    <SeedContactForm bind:dialog={seedContactDialog} />
    <FilterDialog
        bind:dialog={filterDialog}
        bind:name={nameFilter}
        bind:email={emailFilter}
        bind:limit={limitFilter}
    />
    <div class="flex justify-end gap-2">
        <button
            on:click={() => {
                addContactDialog.showModal();
            }}
            class="btn btn-primary"
        >
            Add Contact
        </button>
        <button
            on:click={() => {
                seedContactDialog.showModal();
            }}
            class="btn btn-primary"
        >
            Seed Contact
        </button>
    </div>
    <hr />
    <h1 class="font-bold">Contact List</h1>
    <div class="flex justify-end gap-2">
        <button
            on:click={() => {
                filterDialog.showModal();
            }}
            class="join-item btn btn-sm btn-outline"
        >
            Filter <FilterIcon size="16" />
        </button>
        <div class="join grid grid-cols-2">
            <button
                on:click={previousPage}
                disabled={!contacts.links.prev}
                class="join-item btn btn-sm btn-outline"
            >
                Previous
            </button>
            <button
                on:click={nextPage}
                disabled={!contacts.links.next}
                class="join-item btn btn-sm btn-outline"
            >
                Next
            </button>
        </div>
    </div>
    <br />
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {#each contacts.data as contact, i}
                    <tr class="hover">
                        <td>{contact.name}</td>
                        <td>{contact.email}</td>
                        <td>
                            {new Date(contact.created_at).toLocaleString()}
                        </td>
                        <td>
                            {new Date(contact.updated_at).toLocaleString()}
                        </td>
                        <th>
                            <button
                                on:click={() => {
                                    editPayload = {
                                        id: contact.id,
                                        name: contact.name,
                                        email: contact.email,
                                    };
                                    editContactDialog.showModal();
                                }}
                                class="btn btn-ghost btn-sm">Edit</button
                            >
                            <button
                                on:click={() => {
                                    deleteContact(contact.id);
                                }}
                                class="btn btn-ghost btn-sm"
                            >
                                Delete
                            </button>
                        </th>
                    </tr>
                {/each}
            </tbody>
        </table>
    </div>
    <br />
    <div class="flex justify-end gap-2">
        <div class="join grid grid-cols-2">
            <button
                on:click={previousPage}
                disabled={!contacts.links.prev}
                class="join-item btn btn-sm btn-outline"
            >
                Previous
            </button>
            <button
                on:click={nextPage}
                disabled={!contacts.links.next}
                class="join-item btn btn-sm btn-outline"
            >
                Next
            </button>
        </div>
    </div>
    <br />
    <br />
    <br />
</div>
