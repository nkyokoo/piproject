<template>
    <div>
        <v-main>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>
        <v-footer fixed>

        </v-footer>
    </div>
</template>

<script>
export default {
    name: "guest",
    middleware:"guest",
}
</script>

<style scoped>

</style>
