<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
<div id="app">
    <v-app>
        <v-app>
            <v-app-bar
                color="deep-purple accent-4"
                dense
                dark
            >

                <v-app-bar-nav-icon></v-app-bar-nav-icon>

                <v-toolbar-title>Page title</v-toolbar-title>

                <v-spacer></v-spacer>

                <v-btn icon>
                    <v-icon>mdi-heart</v-icon>
                </v-btn>

                <v-btn icon>
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>

                <v-menu
                    left
                    bottom
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>

                    <v-list>
                        <v-list-item
                            v-for="n in 5"
                            :key="n"
                            @click="() => {}"
                        >
                            <v-list-item-title>Option {{ n }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-app-bar>
            <v-navigation-drawer
                class="deep-purple accent-4"
                dark
                permanent
            >
                <v-list>
                    <v-list-item
                        v-for="item in items"
                        :key="item.title"
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

                <template v-slot:append>
                    <div class="pa-2">
                        <v-btn block>Logout</v-btn>
                    </div>
                </template>
            </v-navigation-drawer>
        <v-main>

            <div>
                <v-card>
                    <v-card-text>
                        hello world

                    </v-card-text>
                </v-card>
            </div>
        </v-main>

    </v-app>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js" integrity="sha512-quHCp3WbBNkwLfYUMd+KwBAgpVukJu5MncuQaWXgCrfgcxCJAq/fo+oqrRKOj+UKEmyMCG3tb8RB63W+EmrOBg==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data() {
            return {
                items: [
                    { title: 'Dashboard', icon: 'dashboard' },
                    { title: 'Account', icon: 'account_box' },
                    { title: 'Admin', icon: 'gavel' },
                ],
            }
        }
    })
</script>
</body>
<footer>

</footer>
</html>
<?php
require __DIR__ . '/vendor/autoload.php';
$loop = new Loop(new SelectLoop);
$server = new SocketListener('tcp://10.54.123.41:6000', $loop);

$server->on('connect', function($server, SocketInterface $client) {
    echo "mbed controller connected";

    $client->on('data', function(SocketInterface $client, $data) use(&$buffer) {

    });
});

$loop->onStart(function() use($server) {
    $server->start();
});
$loop->start();
