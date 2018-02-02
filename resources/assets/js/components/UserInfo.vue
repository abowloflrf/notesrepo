<template>
    <div>
        <p>{{user.email}}</p>
        <p>{{user.name}}</p>
    </div>
</template>

<script>
export default {
    props: ["user"]
}
</script>

<style>

</style>
