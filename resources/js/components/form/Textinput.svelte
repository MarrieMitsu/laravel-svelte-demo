<script>
    export let id;
    export let label;
    export let name;
    export let required;
    export let disabled;
    export let type = "text";
    export let placeholder;
    export let value;
    export let helperMessage;
    export let errorMessage;

    const handleInput = (e) => {
        value = type.match(/^(number|range)$/)
            ? +e.target.value
            : e.target.value;
    };
</script>

<div class={`form-control w-full ${$$props.class}`}>
    {#if label}
        <label for={id} class="label">
            <span class="label-text">{label}</span>
        </label>
    {/if}
    <input
        {id}
        {name}
        {placeholder}
        {type}
        {required}
        {disabled}
        {value}
        on:input={handleInput}
        class="input input-bordered w-full"
    />
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
