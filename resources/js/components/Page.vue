<template>
  <div>
    <v-toolbar
      color="cyan"
      dark
      tabs
    >

      <v-toolbar-title>Open Flow</v-toolbar-title>

      <v-spacer></v-spacer>

      <template v-slot:extension>
        <v-tabs
          v-model="model"
          centered
          color="cyan"
          slider-color="yellow"
        >
          <v-tab
            href="`#tab-1`"
          >
            Authentication
          </v-tab>
          <v-tab
            href="`#tab-2`"
          >
            Flows Table
          </v-tab>
          <v-tab
            href="`#tab-3`"
          >
            Create Flow
          </v-tab>
          <v-tab
            href="`#tab-4`" 
          >
            Hosts
          </v-tab>
        </v-tabs>
      </template>
    </v-toolbar>

    <v-tabs-items v-model="model">
      <v-tab-item
        value="`tab-1`"
      >
        <authentication
          @authentication-completed = "authenticationCompleted"
        > </authentication>
      </v-tab-item>
      <v-tab-item
        value="`tab-3`"
      >
        <flow
          :devices = "devices"
          :ip = "ip"
          :port = "port"
          :username = "username"
          :password = "password"
          > </flow>
      </v-tab-item>
      <v-tab-item
        value="`tab-4`"
      >
        <tabela
        :devices = "devices"
        >  </tabela>
      </v-tab-item>
      <v-tab-item
        value="`tab-2`"
      >
        <flowlist
          :flows = "flows"
          :ip = "ip"
          :port = "port"
          :username = "username"
          :password = "password"
          > </flowlist>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>

<script>
  import tabela from './Table.vue';

  import authentication from './Authentication.vue';

  import flow from './Flows.vue';

  import flowlist from './FlowList.vue';

  export default {
    data () {
      return {
        model: 'tab-1',
        devices: [],
        ip: "",
        port: "",
        username: "",
        password: "",
        flows: [],
      }
    },
    components: {
      'tabela' : tabela,
      'authentication' : authentication,
      'flow' : flow,
      'flowlist' : flowlist,
    },
    methods: {
      authenticationCompleted(ip, port, username, password){
        this.ip = ip;
        this.port = port;
        this.username = username;
        this.password = password;
        let url = 'http://' + this.ip + ':' + this.port +'/restconf/operational/opendaylight-inventory:nodes';
        axios({
          method:'get',
          url,
          auth: {
            username: this.username,
            password: this.password,
          },
        }).then(response => {
          console.log(response.data.nodes.node);
          this.devices = response.data.nodes.node;
        });

        let si = 'http://' + this.ip + ':' + this.port +'/restconf/config/opendaylight-inventory:nodes';
        console.log(si);
        axios({
          method:'get',
          url: si,
          auth: {
            username: this.username,
            password: this.password,
          },
        }).then(response => {
          this.flows = response.data.nodes.node;
          console.log(response.data.nodes.node);
        });
      },
    }
  }
</script>

