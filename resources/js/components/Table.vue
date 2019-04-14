<template>
    <v-data-table
      :headers="headers"
      :items="devices"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.id }}</td>
        <td class="text-xs-left">{{ getMac(props.item["node-connector"]) }}</td>
        <td class="text-xs-left">{{ getAttachmentPoint(props.item["node-connector"]) }}</td>
        <td class="text-xs-left">{{ getIp(props.item["node-connector"])}}</td>
        <td class="text-xs-left">{{ getHostMac(props.item["node-connector"]) }}</td>
      </template>
    </v-data-table>
</template>

<script>
  export default {
    mounted(){
    },
    props: ["devices"],

    methods: {
      getIp(node){
        let ip = "";
        node.some( element => {
          if (Object.keys(element).indexOf("address-tracker:addresses")>-1) {
            ip = element["address-tracker:addresses"][0].ip;
          }
        });
        return ip;
      },
      getHostMac(node){
        let mac = "";
        node.some( element => {
          if (Object.keys(element).indexOf("address-tracker:addresses")>-1) {
            mac = element["address-tracker:addresses"][0].mac;
          }
        });
        return mac;
      },
      getAttachmentPoint(node){
        let ap = "";
        node.some( element => {
          if (Object.keys(element).indexOf("address-tracker:addresses")>-1) {
            ap = element.id;
          }
        });
        return ap;
      },

      getMac(node){
        let mac = "";
        node.some( element => {
          if (Object.keys(element).indexOf("address-tracker:addresses")>-1) {
            mac = element["flow-node-inventory:hardware-address"];
          }
        });
        return mac;
      },
    },
    data () {
      return {
        ip: "",
        headers: [
          {
            text: 'Switch',
            align: 'left',
            sortable: false,
            value: 'name'
          },
          { text: 'MAC-Adress', align: 'left', sortable: false, value: 'mac' },
          { text: 'Attachment point ID', align: 'left', sortable: false, value: 'APointID' },
          { text: 'Host IP', align: 'left', sortable: false, value: 'hostIp' },
          { text: 'Host MAC', align: 'left', sortable: false, value: 'hostMac' },
        ],
      }
    }
  }
</script>
