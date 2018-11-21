<!-- first import Vue -->
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<!-- import JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/liquor-tree/dist/liquor-tree.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

<div class="row">
    <div class="col-6" id="app-tree">
        <liquor-json-viewer></liquor-json-viewer>
    </div>
</div>

<template id="liquor-json-viewer">
    <div class="json-viewer">
        <tree :data="treeData" :options="treeOptions" @node:selected="sel">
        <span slot-scope="{ node }" class="viewer-item" :class="[node.data.type]">
          <span class="viewer-item__key">
           <div style="border: 1px solid black; padding: 5px; background: white; border-radius: 5px; width: 350px">
               Id: {{ node.id }} <br>
               Nombre: {{ node.text }} <br>
<!--               <span v-if="node.collapsed()">-->
<!--                  <template v-if="node.data.type == 'array'">-->
<!--                    [ {{ node.children.length }} ]-->
<!--                  </template>-->
<!--                  <template v-else>-->
<!--                    { {{ node.children.length }} }-->
<!--                  </template>-->
<!--                </span>-->
            </div>
          </span>
            <div class="node-controls">
                <a href="#" @mouseup.stop="editNode(node)">Edit</a>
                <a href="#" @mouseup.stop="removeNode(node)">Remove</a>
                <a href="#" @mouseup.stop="addChildNode(node)">Add child</a>
            </div>
            <!-- <span v-else class="viewer-item__prop">
              <span class="viewer-item__key">{{ node.text }}</span>
              :
              <span class="viewer-item__value">{{ node.data.objectKey }}</span>
            </span> -->
        </span>
        </tree>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content" v-if="selectednode && selectednode.text && selectednode.data">
                        Nodo ID : {{selectednode.id}} <br/>
                        Nombre de tarea : {{ selectednode.text }} <br/>
                        Instancia: <select name="instance" id="instance" value="selectednode.data.instanceid" >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    Vue.component('liquor-json-viewer', {
        template: '#liquor-json-viewer',

        data() {
            return {
                json: {},
                selectednode: null,
                treeData: this.getData().then(r => r.data.input),
                treeOptions: {
                    checkbox: false,
                    propertyNames: {
                        text: 'name',
                        children: 'children',
                        data: 'data'
                    }
                },
                instanceList:[]
            }
        },
        methods: {
            ss(et) {
                this.selectednode = '111';
            },
            sel(et) {
                this.selectednode = et;
                console.log(this.selectednode)
            },
            toList(list) {
                var arr = [];
                for (var key in list) {
                    // var value = dict[key];
                    arr.push({key: key, value: list[key]})
                }
                return arr;
            },
            getData() {
                return axios.get('/processes/parse-to-json-for-view/<?php echo $id ?>')

            },
            editNode(node, e) {
                node.startEditing()
                console.log(node)
            },

            removeNode(node) {
                if (confirm('Are you sure?')) {
                    node.remove()
                }
            },

            addChildNode(node) {
                if (node.enabled()) {
                    let nnode = {};
                    let self = this;
                    //TODO terminar crear funciones en processes deberia enviar un nodo de proceso y recibir el nodo creado en la base de datos
                    // axios.post('processes/new-node', data).then( response  => {
                    //         nnode = response.data
                    //         node.append(nnode)
                    //     }
                    // )

                }
            },
        },
        mounted(){
            //TODO terminar crear funciones en processes deberia obtener las instancias del proyecto
             //axios.get('processes/get-instances/<?php //proyect_id ?>//').then( response =>{
            //     this.instanceList = response.data()
            // })
        }
    });


    new Vue({
        el: '#app-tree',
        data() {
            return {
            }
        },
    })
</script>

<?php $this->load->view('layout/display'); ?>
