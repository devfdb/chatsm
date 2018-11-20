<!-- first import Vue -->
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<!-- import JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/liquor-tree/dist/liquor-tree.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

<div class="row">
    <div class="col-6" id="app-tree">
        <liquor-json-viewer :json="json.processes"></liquor-json-viewer>
        <div class="card">

            Proyecto: {{json.project}} <br/><br/>
            Input: {{json.input}} <br/><br/>


        </div>
    </div>

</div>
<template id="liquor-json-viewer">
    <div class="json-viewer">
        <tree :data="treeData" :options="treeOptions" @node:selected="sel">
        <span slot-scope="{ node }" class="viewer-item" :class="[node.data.type]">
          <span class="viewer-item__key">
           <div style="border: 1px solid black; padding: 5px; background: white; border-radius: 5px; width: 350px">
              {{ node.text }}
                <span v-if="node.collapsed()">
              <template v-if="node.data.type == 'array'">
                [ {{ node.children.length }} ]
              </template>
              <template v-else>
                { {{ node.children.length }} }
              </template>
            </span>
            </div>

          </span>
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
                        Nodo ID : {{selectednode.text}} <br/>
                        Nombre de tarea : {{selectednode.data.name}} <br/>
                        Parámetros :
                        <ul>
                            <li v-for="item in toList(selectednode.data.params)">
                                <b>{{item.key}}</b> : {{item.value}}
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    Vue.component('liquor-json-viewer', {
        template: '#liquor-json-viewer',

        props: ['json'],

        data() {
            return {
                selectednode: null,
                treeData: this.json,
                treeOptions: {
                    checkbox: false,
                    propertyNames: {
                        text: 'id',
                        children: 'children',
                        data: 'task'
                    }
                }
            }
        },

        methods: {
            ss: function (et) {
                this.selectednode = '111';
            },
            sel: function (et) {
                this.selectednode = et;
                console.log(this.selectednode)
            },
            toList: function (list) {
                var arr = [];
                for (var key in list) {
                    // var value = dict[key];
                    arr.push({key: key, value: list[key]})
                }
                return arr;
            }
        }
    })


    new Vue({
        el: '#app-tree',
        data: function () {
            return {
                varx: 'ho',
                json: {
                    "project": "proy",
                    "input": "algo.csv",
                    "processes": [{
                        "id": 1,
                        "task": {
                            "name": "clean",
                            "params": {}
                        },
                        "children": [{
                            "id": 2,
                            "task": {
                                "name": "spellcheck",
                                "params": {
                                    "corpus_path": "V1"
                                }
                            },
                            "children": []
                        },
                            {
                                "id": 3,
                                "task": {
                                    "name": "replace",
                                    "params": {
                                        "file_path": "remplazo2.csv"
                                    }
                                },
                                "children": []
                            }
                        ]
                    }]
                }
            }
        },
        mounted() {
            // TODO: Hay que recibir el arbol desde método en PHP

            var self = this;
            axios.get('/processes/tree-json')
                .then(function (response) {
                    // handle success
                    self.json = response.data;
                    console.log(response.data)
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        }
    })
</script>

<?php $this->load->view('layout/display'); ?>