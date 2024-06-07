<script>
    export let status;

    $: title = {
        503: "503: Service Unavailable",
        500: "500: Server Error",
        404: "404: Page Not Found",
        403: "403: Forbidden",
    }[status];

    $: description = {
        503: "Sorry, we are doing some maintenance. Please check back soon.",
        500: "Whoops, something went wrong on our servers.",
        404: "Sorry, the page you are looking for could not be found.",
        403: "Sorry, you are forbidden from accessing this page.",
    }[status];
</script>

<div class="prose">
    <div class="flex flex-col justify-center items-center w-screen h-screen">
        <h1 class="font-bold">{title}</h1>
        <p>{description}</p>
    </div>
</div>
