<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="arrayFlows"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{props.item.flow[0].id}}</td>
        <td class="text-xs-left">{{ props.item.flow[0].table_id }}</td>
        <td class="text-xs-left">{{ "openflow:" + getDevice(props.item.flow[0])}}</td>
        <td class="text-xs-left">{{ getDropAction(props.item.flow[0])}}</td>
        <td class="text-xs-left">
          <v-icon class="mr-2" @click.prevent="deleteFlow(props.item.flow[0].table_id, props.item.flow[0].id, getDevice(props.item.flow[0]))">delete</v-icon>
        </td>
      </template>
    </v-data-table>
    <button @click="getArrayFlows">Get Flows</button>
  </div>
</template>

<script>
  export default {
    mounted(){
      this.getArrayFlows();
    },
    props: ["flows", "ip", "port", "username", "password"],
    methods: {
      getArrayFlows(){
        this.arrayFlows = [];
        this.flows.forEach((swi, index) => {
            swi["flow-node-inventory:table"].forEach((element) => {
              if (Object.keys(element).indexOf("flow")>-1){
                element.switc=index;
                this.arrayFlows.push(element);
              }
            });
        });
        console.log(this.arrayFlows);
      },
      getDropAction(flow){
        if (Object.keys(flow["match"]).indexOf("ipv4-source")>-1){
          return "Host to Host (IP)";
        }else if (Object.keys(flow["match"]).indexOf("ethernet-match")>-1){
          return "Host to Host (MAC)";
        } else {
          return "Host to all";
        }
      },
      getDevice(flow){
        let device = flow.match["in-port"];
        let num = device.split(":");
        return num[1];
      },
      deleteFlow(table_id, flow_id, switchNumber){
        let url = 'http://'+this.ip+ ':' + this.port +'/restconf/config/opendaylight-inventory:nodes/node/openflow%3A'+switchNumber+'/table/'+table_id+'/flow/' + flow_id;
        axios({
          method:'delete',
          url,
          auth: {
            username: this.username,
            password: this.password,
          },
        }).then(response => {
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
            this.updateFlows(response.data.nodes.node)
          });
        });
      },
      updateFlows(flows){
        this.arrayFlows= [];
        flows.forEach((swi, index) => {
            swi["flow-node-inventory:table"].forEach((element) => {
              if (Object.keys(element).indexOf("flow")>-1){
                element.switc=index;
                this.arrayFlows.push(element);
              }
            });
        });
        console.log(this.arrayFlows);
      }
    },
    data () {
      return {
        arrayFlows:[],
        headers: [
          {
            text: 'ID',
            align: 'left',
            sortable: false,
            value: 'id'
          },
          { text: 'Table ID', align: 'left', sortable: false, value: 'tableId' },
          { text: 'Device', align: 'left', sortable: false, value: 'device' },
          { text: 'Drop Action', align: 'left', sortable: false, value: 'drop' },
          {text: 'Actions', align: 'left', sortable: false, value: 'drop' },
        ],
      }
    },
  }
</script>