<script>
    export let id;
    export let label;
    export let name;
    export let required;
    export let disabled;
    export let value;
    export let helperMessage;
    export let errorMessage;
</script>

<div class={`form-control w-full ${$$props.class}`}>
    {#if label}
        <label for={id} class="label">
            <span class="label-text">{label}</span>
        </label>
    {/if}
    <select
        {id}
        {name}
        {required}
        {disabled}
        bind:value
        class="select select-bordered w-full max-w-xs"
    >
        <slot />
    </select>
    {#if helperMessage || errorMessage}
        <div class="label">
            {#if errorMessage}
                <span class="label-text-alt text-error">
                    {errorMessage}
                </span>
            {:else}
                <span class="label-text-alt">
                    {helperMessage}
                </span>
            {/if}
        </div>
    {/if}
</div>
