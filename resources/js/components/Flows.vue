<template>
  <v-container fuild>
    <v-layout row wrap>
      <v-flex xs12 sm4>
        <form>
          <v-select
            :items="getDevices(devices)"
            v-model="selectedDevice"
            label="Device"
            target="#dropdown-example"
          ></v-select>
          <v-text-field
            v-model="table"
            :counter="15"
            label="Table"
            required
          ></v-text-field>
          <v-text-field
            v-model="flowId"
            label="Flow ID"
            required
          ></v-text-field>
          <v-select
            :items="actions"
            v-model="selectedAction"
            label="Drop Action"
            target="#dropdown-example"
          ></v-select>
          <v-text-field
            v-if="selectedAction=='Host to Host (IP)'"
            v-model="ipv4source"
            :counter="15"
            label="IP"
            required
          ></v-text-field>
          <v-text-field
            v-if="selectedAction=='Host to Host (MAC)'"
            v-model="mac"
            :counter="17"
            label="MAC"
            required
          ></v-text-field>
          <v-btn @click="submit">submit</v-btn>
        </form>
        <v-alert
        :value = "success"
        type = "success"
      >
        Flow created successfully!
      </v-alert>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  export default {
    data: () => ({
        selectedDevice: "",
        selectedAction: "",
        table: "",
        flowId: "",
        actions: ["Host to Host (IP)", "Host to Host (MAC)", "Host to All"],
        ipv4source: "",
        mac: "",
        success: false,
    }),
    props: ["devices", "ip", "port", "username", "password"],
    methods: {
      getDevices(devices){
        let ids = [];
        devices.forEach( function(element, index) {
          ids.push(element.id);
        });
        return ids;
      },
      submit(){
        let body = this.getBody();
        let url = 'http://' + this.ip + ':' + this.port +'/restconf/config/opendaylight-inventory:nodes/node/' + this.selectedDevice + '/table/' + this.table + '/flow/' + this.flowId;
        let flows = JSON.parse(body); 
        axios({
          method:'put',
          url,
          data: flows,
          auth: {
            username: this.username,
            password: this.password,
          },
        }).then(response => {
          this.success = true;
        });
      },
      getBody(){
        let body = "";
        if(this.selectedAction == "Host to Host (IP)"){
          body = '{"flow": [{"table_id": "'+this.table+'", "id": "' + this.flowId + '", "priority": "4", "hard-timeout": 0, "idle-timeout":0, "match":{"ethernet-match": {"ethernet-type": {"type": 2048}},"ipv4-source": "'+this.ipv4source+'/32"}, "instructions": {"instruction": [{"order": 0,"apply-actions": {"action": [{"order": 0,"drop-action": {}}]}}]}}]}';
        }else if(this.selectedAction == "Host to Host (MAC)"){
          body = '{"flow": [{"table_id": "'+this.table+'", "id": "' + this.flowId + '", "priority": "4", "hard-timeout": 0, "idle-timeout":0, "match":{"ethernet-match": {"ethernet-source": {"address": "'+this.mac+'"}}}, "instructions": {"instruction": [{"order": 0,"apply-actions": {"action": [{"order": 0,"drop-action": {}}]}}]}}]}';
        }else {
          body = '{"flow": [{"table_id": '+this.table+',"id": '+this.flowId+',"priority": 20,"hard-timeout": 0,"idle-timeout": 0,"match": {"in-port":"'+this.selectedDevice+':1"},"instructions": {"instruction": [{"order": 0,"apply-actions": {"action": [{"order": 0,"drop-action": {}}]}}]}}]}';
        }
        return body;
      }
    }
  }
</script>