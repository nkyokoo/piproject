<template>
    <div>
        <v-row>
            <v-col v-for="(items,i) in homeItems" :key="i">
                <v-card @click="$router.push(items.action)" color="blue">
                    <v-card-title style="text-align: center">
                        <v-icon>{{items.icon}}</v-icon> {{items.title}}
                    </v-card-title>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    data() {
        return {
            homeItems: [
                {title: 'Temperature', icon: 'mdi-temperature-celsius', action: "/temperature"},
                {title: 'Sound', icon: 'mdi-volume-high', action: "/sound"},
                {title: 'Light', icon: 'mdi-lightbulb-on', action: "/light"},
            ]

        }
    }
}
</script>
