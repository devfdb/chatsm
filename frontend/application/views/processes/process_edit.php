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

                <div class="row flex-grow">


                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" v-if="selectednode && selectednode.text && selectednode.data">
                                Información del nodo
                                <hr/>
                                <form class="forms-sample">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">ID</label>
                                        <div class="col-sm-9">
                                            {{selectednode.id}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Tarea</label>
                                        <div class="col-sm-9">
                                            {{selectednode.text}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputEmail2"
                                               class="col-sm-3 col-form-label">Instancia</label>
                                        <div class="col-sm-9">
                                            {{selectednode.text}}
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="col-12" style="margin-top: 30px">
                        <div class="card">
                            <div class="card-body">
                                Nuevo nodo
                                <hr/>
                                <form class="forms-sample">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail2"
                                               class="col-sm-3 col-form-label">Instancia</label>
                                        <div class="col-sm-9">
                                            <select name="" id="tipo" class="form-control"
                                                    v-model="new_node.instance_id">
                                                <option :value="item.key" v-for="item in list_types">{{ item.value }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </form>

                            </div>


                        </div>
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
                list_types: [],
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
                instanceList: [],
                new_node: {}
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
                    if (this.new_node.instance_id) {
                        let nnode = {};
                        let self = this;
                        //TODO terminar crear funciones en processes deberia enviar un nodo de proceso y recibir el nodo creado en la base de datos

                        node.identifier = node.id;

                        var data = {
                            process_id: <?php echo $id ?>,
                            parent: {
                                id: node.id
                            },
                            new: this.new_node
                        };
                        axios.post('/processes/new-node', data)
                            .then(
                                function (response) {
                                    debugger;
                                    nnode = response.data;
                                    node.append(nnode);
                                    self.new_node = {};
                                    node.expand();
                                }
                            )
                    }
                    else {
                        swal({
                            type: "warning",
                            title: "Selecciona un tipo de nodo",
                            text: "Se requiere seleccionar la instancia"
                        })
                    }
                }
            },
            get_task_type() {
                var self = this
                return axios.get('/task-instances/get_instances_of_project')
                    .then(function (r) {
                        self.list_types = r.data;
                    })
            }
        },
        mounted() {
            //TODO terminar crear funciones en processes deberia obtener las instancias del proyecto
            //axios.get('processes/get-instances/<?php //proyect_id ?>//').then( response =>{
            //     this.instanceList = response.data()
            // })

            this.get_task_type();
        }
    });


    new Vue({
        el: '#app-tree',
        data() {
            return {}
        },
    })
</script>

<?php $this->load->view('layout/display'); ?>
