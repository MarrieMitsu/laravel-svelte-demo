<script>
    import { page } from "@westacks/inertia-svelte";
    import { onDestroy } from "svelte";
    import { flip } from "svelte/animate";
    import { fade, fly } from "svelte/transition";
    import { alert } from "../../store/stores";
    import Alert from "../feedback/Alert.svelte";

    let notification;

    const unsubscribe = page.subscribe((val) => {
        notification = val.props.notification;
    });

    $: if (notification) {
        alert.push(notification.type, notification.message);
    }

    let queues = [];

    $: queues = $alert;

    onDestroy(() => {
        unsubscribe();
    });
</script>

<div class="fixed top-0 w-full flex justify-center pointer-events-none z-10">
    <div class="mt-6 m-3 basis-full sm:basis-1/2 stack">
        {#each queues as queue (queue.id)}
            <div
                in:fly={{ y: -200 }}
                out:fade
                animate:flip={{ duration: 200 }}
                class="pointer-events-auto"
            >
                <Alert
                    id={queue.id}
                    type={queue.type}
                    message={queue.message}
                />
            </div>
        {/each}
    </div>
</div>
