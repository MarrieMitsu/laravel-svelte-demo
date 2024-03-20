<script>
    import {
        AlertTriangle as AlertTriangleIcon,
        CheckCircle as CheckCircleIcon,
        Info as InfoIcon,
        XOctagon as XOctagonIcon,
    } from "lucide-svelte";
    import { onDestroy, onMount } from "svelte";
    import { linear } from "svelte/easing";
    import { tweened } from "svelte/motion";
    import { alert } from "../../store/stores";

    export let id;
    /** @type {"info" | "success" | "warning" | "error"} */
    export let type;
    export let message;

    const alertVariants = {
        info: "alert-info",
        success: "alert-success",
        warning: "alert-warning",
        error: "alert-error",
    };
    const btnVariants = {
        info: "btn-info",
        success: "btn-success",
        warning: "btn-warning",
        error: "btn-error",
    };

    let checkpoint = 1; // progress checkpoint
    const duration = 7000;
    let isPaused = false;

    const progress = tweened(checkpoint, {
        duration: duration,
        easing: linear,
    });

    function close() {
        alert.pop(id);
    }

    function autoClose() {
        if ($progress === 1 || $progress === 0) {
            close();
        }
    }

    function pause() {
        if (!isPaused && $progress !== checkpoint) {
            progress.set($progress, { duration: 0 });
            isPaused = true;
        }
    }

    function resume() {
        if (isPaused) {
            progress.set(checkpoint, { duration }).then(autoClose);
            isPaused = false;
        }
    }

    function progressHandler() {
        document.hidden ? pause() : resume();
    }

    $: if (checkpoint !== 0) {
        checkpoint = 0;
        progress.set(checkpoint).then(autoClose);
    }

    onMount(() => {
        if (document.hidden === undefined) {
            return;
        }

        document.addEventListener("visibilitychange", progressHandler);
        progressHandler();
    });

    onDestroy(() => {
        document.removeEventListener("visibilitychange", progressHandler);
    });
</script>

<div
    role="alert"
    on:mouseenter={pause}
    on:mouseleave={resume}
    class="alert {alertVariants[type]} shadow-md"
>
    {#if type === "info"}
        <InfoIcon />
    {:else if type === "success"}
        <CheckCircleIcon />
    {:else if type === "warning"}
        <AlertTriangleIcon />
    {:else if type === "error"}
        <XOctagonIcon />
    {/if}
    <span>{message}</span>
    <div>
        <button on:click={close} class="btn btn-sm {btnVariants[type]}">
            Close
        </button>
    </div>
</div>
