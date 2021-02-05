<template>
    <div>
        <div class="alert alert-primary text-center" v-if="processing">
            <i class="fa fa-compass"> </i> Cargando datos...
        </div>
        <v-server-table ref="table" :columns="columns" :url="url" :options="options">
            <div slot="detail" slot-scope="props">
                <button
                    type="button"
                    class="btn btn-success btn-sm"
                    @click="showDetail(props.row)">
                    Detalle
                </button>
            </div>
        </v-server-table>

        <!-- Side Deail content-->
        <div id="detail_side" class="detail_side">

            <div class="side_close_btn">
                <a href="#" class="closebtn"  v-on:click="hidewDetail()"><i class="far fa-times-circle"></i></a>
            </div>
            <div class="side_detail_content">
                <div class="container">
                    <div class="side_detail_navbar">
                        <h2 class="title"> <b>{{customer['client_number']}}</b> {{customer.first_name}} {{customer.last_name}} {{customer.second_last_name}}</h2>
                    </div>
                    <div class="side_detail_tabs">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Encuestas y conexiones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Otro</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Información Personal</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="profile_picture mb-4">
                                                    <img src="https://randomuser.me/api/portraits/lego/7.jpg" alt="" class="m-0">
                                                </div>

                                                <div class="content-info">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <p>
                                                                <label>Email:</label>
                                                                <span>{{customer.email}}</span>
                                                            </p>
                                                            <p>
                                                                <label>Télefono Movil</label>
                                                                <span>{{customer.mobile_number}}</span>
                                                            </p>
                                                            <p>
                                                                <label>Télefono</label>
                                                                <span>{{customer.phone}}</span>
                                                            </p>
                                                            <p>
                                                                <label>Sucursal:</label>
                                                                <span>{{customer.branch_id}}</span>
                                                            </p>
                                                            <p>
                                                                <label>Ciudad</label>
                                                                <span>{{customer.city_id}}</span>
                                                            </p>
                                                            <p>
                                                                <label>Estado</label>
                                                                <span>{{customer.state_id}}</span>
                                                            </p>

                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p>
                                                                <label>Educación</label>
                                                                <span>{{customer.education}}</span>
                                                            </p>
                                                            <p>
                                                                <label>Género:</label>
                                                                <span>{{customer.gender}}</span>
                                                            </p>
                                                            <p>
                                                                <label>mobile_number:</label>
                                                                <span>{{customer.mobile_number}}</span>
                                                            </p>
                                                            <p>
                                                                <label>Cumpleaños</label>
                                                                <span>{{customer.birthday}}</span>
                                                            </p>
                                                            <p>
                                                                <label>Colonia</label>
                                                                <span>{{customer.colonia}}</span>
                                                            </p>
                                                            <p>
                                                                <label>Código postal</label>
                                                                <span>{{customer.postal_code}}</span>
                                                            </p>
                                                        </div>
                                                    </div>



                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                <h6 class="m-0 font-weight-bold text-primary">Actividad</h6>
                                            </div>
                                            <div class="card-body">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./Side Deail content-->

    </div>
</template>

<script>
    import {Event} from 'vue-tables-2';
    export default {
        name: "databaseTableComponent",
        props:{
            labels:{
                type:Object,
                required:true
            },
            route:{
                type:String,
                required:true
            }
        },
        data () {
            return {

                customer:{},
                processing: false,
                status: null,
                url: this.route,
                columns: ['name',
                    'last_name',
                    'second_last_name',
                    'email',
                    'mobile_number',
                    'created_at','detail'],
                options: {
                    filterByColumn: true,
                    perPage: 10,
                    perPageValues: [10, 25, 50, 100, 500],
                    headings: {
                        'name': 'Nombre',
                        'last_name': 'Apellido',
                        'second_last_name': 'A. Materno',
                        'email': 'Correo',
                        'mobile_number': 'Télefono',
                        'created_at':'Creación',
                    },
                    //sortable: [ 'name', 'last_name'],
                    //hiddenColumns:['second_last_name'],
                    filterable: ['name'],
                    requestFunction: function (data) {
                        return window.axios.get(this.url, {
                            params: data
                        })
                            .catch(function (e) {
                                this.dispatch('error', e);
                            }.bind(this));
                    }
                }
            }
        },
        methods:{
            showDetail (row){
                console.log('Show detail');
                console.log(row);
                this.customer = row;
                document.getElementById("detail_side").style.width = "100%";
            },

            hidewDetail(){
                document.getElementById("detail_side").style.width = "0%";
            },
            /*hide_show(column){
                console.log(column);

            }*/
        }
    }
</script>

<style scoped>

</style>
