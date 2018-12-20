<!-- first import Vue -->
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<!-- import JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/liquor-tree/dist/liquor-tree.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>


<div class="col-lg-12 grid-margin">
    <div id="app">
        <div class="row">
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-body" v-if="treeExecution">
                        <liquor-json-viewer :datos = "treeExecution"></liquor-json-viewer>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">

                    <div class="card-body">
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-lg"
                                    @click="run(<?php echo $process_id ?>)">
                                <img src="/assets/img/play-48.png" style="height: 24px; width: 24px"/>Ejecutar
                            </button>

                            <button type="button" class="btn btn-outline-primary btn-lg" @click="update()">
                                <img src="/assets/img/update-48.png" style="height: 24px; width: 24px"/>Actualizar
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>
                                    UUID
                                </th>
                                <th>
                                    Progreso
                                </th>
                                <th>
                                    Momento de inicio
                                </th>
                                <th>
                                    Acciones
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($execution_table) { ?>
                                <?php foreach ($execution_table as $item) { ?>
                                    <tr>
                                        <td>
                                            <a href="/processes/">
                                                <?php echo $item['exe_id'] ?>
                                            </a>
                                        </td>
                                        <td><?php if ($item['exe_status'] == 'processing') { ?>
                                                <img src="/assets/img/loading.gif"/>
                                            <?php } else if ($item['exe_status'] == 'terminado') { ?>
                                                <img src="/assets/img/icon-ready.png"/>
                                            <?php } ?>

                                        </td>
                                        <td><?php
                                            echo $item['exe_created_at'] ?></td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Operaciones">
                                                <button title="Ver resultados" @click="selectExecution('<?php echo $item['exe_id'] ?>')">
                                                    <i class="mdi mdi-view-week"></i>
                                                </button>
                                                <!--
                                                <a title="Matar ejecución"
                                                   href="/processes/destroy_ex/<?php echo $item['exe_id'] ?>"
                                                   class="btn btn-outline-secondary">
                                                    <i class="mdi mdi-delete"></i>
                                                </a>
                                                -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<template id="liquor-json-viewer">
    <div class="row">
        <div class="col-md-6">
            <div class="json-viewer">
                <tree :data="treeData" :options="treeOptions" @node:selected="sel"ref="tree">
                    <span slot-scope="{ node }" class="viewer-item">
                        <span class="viewer-item__key">
                            <div style="border: 1px solid black; padding: 5px; background: white; border-radius: 5px; width: 350px">
                                Id: {{ node.id }} <br>
                                Nombre: {{ node.text }} <br>
                            </div>
                        </span>
                        <div class="node-controls">
                            <a href="#" @mouseup.stop="removeNode(node)">Eliminar nodo</a>
                            <a href="#" @mouseup.stop="addChildNode(node)">Agregar nodo</a>
                        </div>
                    </span>
                </tree>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body"
                     v-if="selectednode && selectednode.text && selectednode.data">
                    Información del nodo
                    <hr/>
                    <form class="forms-sample">
                        <div class="form-group row">
                            <label for="exampleInputEmail2"
                                   class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-9">
                                {{selectednode.id}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputEmail2"
                                   class="col-sm-3 col-form-label">Tarea</label>
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
                        <div class="form-group row">
                            <label for="exampleInputEmail2"
                                   class="col-sm-3 col-form-label">Tiempo de Ejecuccion</label>
                            <div class="col-sm-9">
                                {{selectednode.data.ex_time}}
                            </div>
                        </div>
                    </form>
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
                treeData: this.datos,
                treeOptions: {
                    checkbox: false,
                    propertyNames: {
                        text: 'name',
                        children: 'children',
                        data: 'data'
                    }
                },
                instanceList: [],
                new_node: {},
                node: {}
            }
        },
        props: {
            datos: {}
        },
        watch: {
            datos(newDatos){
                const tree = this.$refs.tree;
                tree.setModel(newDatos);
                this.selectednode = null;
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
            // getData(id) {
            //     return axios.get('/executions/parse-to-json-for-view/'+ id)
            //
            // },

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
        },
    });

    new Vue({
        el: '#app',
        data: function () {
            return {
                id: <?php echo $process_id ?>,
                input: <?php echo $process_id ?>,
                toast: null,
                treeExecution: null
            }
        },
        created() {
            this.toast = swal.mixin({
                toast: true,
                type: 'success',
                title: 'Signed in successfully',
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            })
        },
        methods: {
            run: function (id) {
                var self = this;
                this.toast({type: 'info', title: 'Iniciando ejecución de proceso ...'});
                axios.post('/processes/execute/' + id)
                    .then(function (arg) {
                        self.toast({type: 'info', title: 'Procesando ejecución ...'});
                        location.reload();
                    });
            },
            update: function () {
                var self = this;
                this.toast({type: 'info', title: 'Actualizando estados de proceso ...'});
                axios.post('/processes/update_table/')
                    .then(function (arg) {
                        self.toast({type: 'info', title: '¡Estados de proceso actualizados!'});
                        if (arg.data) {
                            location.reload();
                        }
                        else {
                            self.toast({type: 'info', title: 'No hay estados nuevos'});
                        }
                    });
            },
            selectExecution: function (execution_id) {
                var self = this;
                // this.exe_id = execution_id;
                // this.treeExecution = true;
                 axios.get('/executions/parse-to-json-for-view/' + execution_id)
                    .then(function (r) {
                        self.treeExecution = r.data.input;
                    })
            },
        }
    })
</script>