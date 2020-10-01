<template>
  <v-app app dark>
    <v-app-bar dark
               app>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>Dynamic Monitoring System</v-toolbar-title>

    </v-app-bar>
      <v-navigation-drawer app v-model="drawer">

          <v-list
              dense
              nav
          >
              <v-list-item
                  v-for="item in this.items"
                  :key="item.title"
                  @click="$router.push(item.action)"
                  link
              >
                  <v-list-item-icon>
                      <v-icon>{{ item.icon }}</v-icon>
                  </v-list-item-icon>

                  <v-list-item-content>
                      <v-list-item-title>{{ item.title }}</v-list-item-title>
                  </v-list-item-content>
              </v-list-item>
          </v-list>
      </v-navigation-drawer>
      <v-main>
          <v-container>
              <router-view></router-view>
          </v-container>
      </v-main>

  </v-app>
</template>

<script>

import {mapGetters} from "vuex";

export default {
  name: 'MainLayout',
  middleware:"auth",
  components: {
  },
  data(){
      return{
          drawer:true,
          items: [
              { title: 'Home', icon: 'mdi-home', action:"/" },
              { title: 'Temperature', icon: 'mdi-temperature-celsius', action: "/temperature" },
              { title: 'Sound', icon: 'mdi-volume-high', action: "/sound" },
              { title: 'Light', icon: 'mdi-lightbulb-on', action: "/light" },
          ],
          right: null,
      }
  },
  computed:{
    ...mapGetters(["LoggedInUser"]),
  }

}
</script>
