<template>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Base de datos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{this.totals.db}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Club Dar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{this.totals.club_dar}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Clientes</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{this.totals.clients}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Leads</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{this.totals.leads}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Base inicial</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{this.totals.historic}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "databaseTotalsComponent",
        data(){
            return {
                loading:false,
                totals:[]
            }
        },
        methods:{
          loadTotals(){
              console.log("Loading notes");
              axios.get("/vue/dashboard/databases").then(response => {
                 console.log(response.data);
                 this.totals = response.data.totals;
              });
          }
        },
        mounted() {
            console.log('Component mounted.');
            this.loadTotals();
        }
    }
    /*axios.get("/vue/posts/" + this.post_id + "/comments").then(response => {
      this.comments = response.data;
    });
*/
</script>

<style scoped>

</style>
