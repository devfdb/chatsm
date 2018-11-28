<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

<div class="col-12 grid-margin" id="create">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Crear instancia</h4>
            <p class="card-description">
                Crea una instancia a partir de la configuración de un modelo.
            </p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input id="name" type="text" v-model="name" class="form-control">
                            <!--                            --><?php //echo form_input(array('name' => 'name', 'class' => 'form-control')) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tipo</label>
                        <div class="col-sm-9">
                            {{list_types}}
                            <select name="" id="tipo" @change="get_task_parameters" class="form-control" v-model="type">
                                <option :value="item.key" v-for="item in list_types">{{ item.value }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" v-for="(p,index) in parameters[0]">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">{{p.itp_name}}</label>
                        <div class="col-sm-9">
                            <input v-if="is_string(p.itp_var_type)" type="text" v-model="p.value"
                                   class="form-control">
                        </div>
                    </div>
                </div>
                {{parameters}}
            </div>
            <div class="row">
                <button class="btn btn-success mr-2" @click="create_instance">Crear</button>
                <a href="/task-instances/index" class="btn btn-light">Cancelar</a>
            </div>
            <!--            --><?php //echo form_close(); ?>
        </div>
    </div>
</div>

<script>
    //    Todo encontrar modo de traspasar la id del tipo de dato a el arreglo de parametros
    new Vue({
        el: '#create',
        data() {
            return {
                name: '',
                type: '',
                list_types: [],
                parameters: [],
                param: [
                    {
                        id: '',
                        value: ''
                    }
                ]
            }
        },
        methods: {
            /**
             * Recupera los tipos de tarea
             * @returns {*}
             */
            get_task_type() {
                return axios.get('/task-instances/get-task-types');
            },
            /**
             * Recupera los parámetros de las tareas
             * @returns {*}
             */
            get_task_parameters() {
                var self= this;
                return axios.get('/task-instances/get-task-parameters/' + this.type)
                    .then(function (response) {
                        self.parameters = response.data;
                    });
            },
            is_string(type) {
                if (type === 'string') {
                    return true;
                }
                else return false;
            },
            create_instance() {

                var taskobj = {
                    name: this.name,
                    type_id: this.type,
                    parameters: this.parameters
                };

                axios.post('/task-instances/create', taskobj)
            }
        },
        mounted() {
            this.get_task_type().then(resp => {
                this.list_types = resp.data;
            })
        }
    });
</script>

<?php $this->load->view('layout/display'); ?>
