<template>
  <v-container fuild>
    <v-flex xs12 sm4 offset-sm2 mt-3>
      <form v-if="!validation">
        <v-text-field
          v-model="ip"
          :counter="15"
          label="Ip"
          required
        ></v-text-field>
        <v-text-field
          v-model="port"
          label="Port"
          required
        ></v-text-field>
        <v-btn @click="submitVal">submit</v-btn>
      </form>
      <form v-if="showAuth">
        <v-text-field
          v-model="username"
          :counter="15"
          label="Username"
          required
        ></v-text-field>
        <v-text-field
          v-model="password"
          label="Password"
          type = "password"
          required
        ></v-text-field>
        <v-btn @click="submitAuth">submit</v-btn>
      </form>
    </v-flex>
    <v-alert
        :value = "success"
        type = "success"
      >
        Authentication successfull!
      </v-alert>
  </v-container>
</template>

<script>
  export default {
    data: () => ({
      ip: '10.10.10.2',
      port: '8181',
      validation: false,
      showAuth: false,
      username: 'admin',
      password: 'admin',
      success: false,
    }),

    methods: {
      submitVal () {
        let url = 'http://' + this.ip + ':' + this.port +'/restconf/operational/opendaylight-inventory:nodes';
        axios({
          method:'get',
          url,
          auth: {
            username: '0',
            password: '0',
          },
        }).then(response => {
          console.log(response.data.nodes.node);
        }).catch(error => {
          if (error.response) {
            if (error.response.status == 401) {
              this.validation = true;
              this.showAuth = true;
            }
          }
          else{
              window.alert("Wrong IP/Port");
          }
          
        });
      },
      submitAuth () {
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
          this.showAuth = false;
          this.success = true;
          this.$emit("authentication-completed", this.ip, this.port, this.username, this.password);
        }).catch(error => {
          if (error.response) {
            if (error.response.status == 401) {
              window.alert("Wrong Username/Password");
            }
          }  
        });
      },
    }
  }
</script>