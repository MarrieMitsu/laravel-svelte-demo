<script>
    import { uid } from "../../lib/utils";

    export let id = uid();
    export let dialog;
    export let signature;
    /** @type {"medium" | "large"} */
    export let size = "medium";

    const modalVariant = {
        medium: "",
        large: "w-11/12 max-w-5xl",
    };
</script>

<dialog {id} class={`modal ${$$props.class}`} bind:this={dialog}>
    <div class={`modal-box ${modalVariant[size]}`}>
        {#if signature}
            <slot />
        {:else}
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        {/if}
    </div>
</dialog>
