@extends('layouts.main')
@section('title','Shuttle Bus System')
@section('top-head')
    <!-- Vue Script--><script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <!-- Chart.js Script--><script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>
    <!-- Mapbox Script--><script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <!-- Mapbox Style--><link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <!-- Buefy Icon Material Design --> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css">
    <!-- Buefy Icon Font Awesome --> <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <!-- Buefy Style --> <link rel="stylesheet" href="https://unpkg.com/buefy/dist/buefy.min.css">
    <!-- Buefy Script --> <script src="https://unpkg.com/buefy/dist/buefy.min.js"></script>

@endsection
@section('content')
    <section class="columns">
        <div class="column is-2" id='navigation' style="border-right: solid #ddd 1px;">
            <div class="w-100 p-4 m-0 has-text-weight-bold has-text-primary" data-view="home" onclick="changeView(this)"><i class="fas fa-home"></i>&nbsp;&nbsp;Home</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="booking" onclick="changeView(this);"><i class="fas fa-book"></i>&nbsp;&nbsp;Bookings</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="map" onclick="changeView(this); map.resizeMap()"><i class="fas fa-map"></i>&nbsp;&nbsp;Map</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="register" onclick="changeView(this)"><i class="fas fa-file-signature"></i>&nbsp;&nbsp;Register</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="vehicles" onclick="changeView(this)"><i class="fas fa-bus-alt"></i>&nbsp;&nbsp;Vehicles</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="users" onclick="changeView(this)"><i class="fas fa-user-cog"></i>&nbsp;&nbsp;Users</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="contracts" onclick="changeView(this)"><i class="fas fa-file-contract"></i>&nbsp;&nbsp;Contracts</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="payments" onclick="changeView(this)"><i class="fas fa-file-invoice-dollar"></i>&nbsp;&nbsp;Payments</div>
        </div>
        <div class="column is-10 pt-5 pr-5" id='main'>
            <div id="home">
                <div class="columns is-multiline">
                    <div class="column is-full">
                        <div class="card">
                          <div class="card-content">
                            <div class="content">
                                <h1 class="is-size-4">Welcome to the Shuttle Bus System!</h1>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="column is-3 has-text-centered">
                        <div class="card">
                          <div class="card-content">
                            <div class="content">
                                <h1 class="is-size-2"><i class="fas fa-road"></i></h1>
                                <h1 class="is-size-4 has-text-weight-bold">Current Routes</h1>
                                <p class="is-size-5">12</p>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="column is-3 has-text-centered">
                        <div class="card">
                          <div class="card-content">
                            <div class="content">
                                <h1 class="is-size-2"><i class="fas fa-bus"></i></h1>
                                <h1 class="is-size-4 has-text-weight-bold">Total Vehicles</h1>
                                <p class="is-size-5">31</p>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="column is-3 has-text-centered">
                        <div class="card">
                          <div class="card-content">
                            <div class="content">
                                <h1 class="is-size-2"><i class="fas fa-user-graduate"></i></h1>
                                <h1 class="is-size-4 has-text-weight-bold">Total Students</h1>
                                <p class="is-size-5">1,342</p>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="column is-3 has-text-centered">
                        <div class="card">
                          <div class="card-content">
                            <div class="content">
                                <h1 class="is-size-2"><i class="fas fa-user"></i></h1>
                                <h1 class="is-size-4 has-text-weight-bold">Total Drivers</h1>
                                <p class="is-size-5">29</p>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div id="frequency-chart">
                    <canvas ref="vue-frequency-table" width="100%" min-height="400"></canvas>
                </div>
            </div>
        </div>
    </section>
    {{-- Section where all the views are stored --}}
    <section style="display:none" id='views'>
        <div id="booking" style="height:100%;">
            <div class="table-container">
                <table id="booking-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th>License Plate Number</th>
                            <th>Image</th>
                            <th>Vehicle Name</th>
                            <th>Manufacturer</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Max Capacity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>License Plate Number</th>
                            <th>Image</th>
                            <th>Vehicle Name</th>
                            <th>Manufacturer</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Max Capacity</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td style="vertical-align: middle;" >1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="map" style="height:100%;">
            <div id='mapbox-map' style='width: 100%; min-height: 600px;' onload="this.style.width=100%;"></div>
        </div>
        <div id="register">
            <div class="columns w-100 is-variable is-1">
                <div class="column is-one-third" data-form="student" onclick="changeForm(this)"><p class="button is-light has-text-centered w-100"><i class="fas fa-user-graduate"></i>&nbsp;&nbsp;Register Student</p></div>
                <div class="column is-one-third" data-form="driver"  onclick="changeForm(this)"><p class="button is-light has-text-centered w-100"><i class="fas fa-user"></i>&nbsp;&nbsp;Register Driver</p></div>
                <div class="column is-one-third" data-form="vehicle" onclick="changeForm(this)"><p class="button is-light has-text-centered w-100"><i class="fas fa-bus"></i>&nbsp;&nbsp;Register Vehicle</p></div>
            </div>
            <div class="columns w-100 p-4" id='register-form'></div>
            <div id='register-forms' style="display:none">
                <form data-form="student" id="student-form">
                    <div class="field">
                        <label class="label">First Name</label>
                        <div class="control">
                            <input ref="firstName" class="input" type="text" placeholder="e.g Johnathan">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Last Name</label>
                        <div class="control">
                            <input ref="lastName" class="input" type="text" placeholder="e.g Doberman">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">School ID Number</label>
                        <div class="control">
                            <input ref="id" class="input" type="text" placeholder="e.g 180000">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email Address</label>
                        <div class="control">
                            <input ref="email" class="input" type="email" placeholder="e.g. johnathandoberman@email.com">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Phone Number</label>
                        <div class="control">
                            <input ref="phoneNumber" class="input" type="tel" placeholder="e.g. 876-123-4567"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button" @click="registerStudent" value="Submit">
                        </div>
                    </div>
                </form>

                <form data-form="driver" id="driver-form">
                    <div class="field">
                        <label class="label">First Name</label>
                        <div class="control">
                            <input ref="firstName" class="input" type="text" placeholder="e.g Johnathan">
                        </div>
                    </div><div class="field">
                        <label class="label">Last Name</label>
                        <div class="control">
                            <input ref="lastName" class="input" type="text" placeholder="e.g Doberman">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input ref="email" class="input" type="email" placeholder="e.g. johnathanndoe@email.com">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Phone Number</label>
                        <div class="control">
                            <input ref="phoneNumber" class="input" type="tel" placeholder="e.g. 876-123-4567"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Tax Registration Number</label>
                        <div class="control">
                            <input class="input" type="number" placeholder="e.g. 876-123-4567"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button" @click="registerDriver" value="Submit">
                        </div>
                    </div>
                </form>

                <form data-form="vehicle" id="vehicle-form">
                    <div class="field">
                        <label class="label">License Plate Number</label>
                        <div class="control">
                            <input ref="plateNumber" class="input" type="text" placeholder="e.g. 3424323">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Make</label>
                        <div class="control">
                            <input ref="make" class="input" type="text" placeholder="e.g. Toyota">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Model</label>
                        <div class="control">
                            <input ref="model" class="input" type="text" placeholder="e.g. Hiace">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Max Capacity</label>
                        <div class="control">
                            <input ref="capacity" class="input" type="number" placeholder="e.g. 7">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Colour</label>
                        <div class="control">
                            <input ref="colour" class="input" type="text" placeholder="e.g. Orange">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Driver ID</label>
                        <div class="select">
                            <select ref="driverID" class="select">
                                <option v-for="(driver,index) in drivers" v-html="driver.driver_id+' -- '+driver.first_name+' '+driver.last_name" :value="driver.driver_id"></option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Owner ID</label>
                        <div class="select">
                            <select class="select" ref="ownerID">
                                <option v-for="(owner,index) in owners" v-html="owner.owner_id+' -- '+owner.first_name+' '+owner.last_name" :value="owner.owner_id"></option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <input class="button" @click="registerVehicle" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="vehicles">
            <div class="table-container">
                <table id="vehicle-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th>Vehicle ID</th>
                            <th>License Plate Number</th>
                            <th>Image</th>
                            <th>Colour</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Max Capacity</th>
                            <th>Owner ID</th>
                            <th>Driver ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Vehicle ID</th>
                            <th>License Plate Number</th>
                            <th>Image</th>
                            <th>Colour</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Max Capacity</th>
                            <th>Owner ID</th>
                            <th>Driver ID</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(vehicle, index) in vehicles">
                            <td style="vertical-align: middle;" v-html="vehicle.vehicle_id"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.plate_number"></td>
                            <td><img :src="'https://loremflickr.com/120/75/bus,van/all?random='+index"/></td>
                            <td style="vertical-align: middle;" v-html="vehicle.colour"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.make"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.model"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.capacity"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.owner_id"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.driver_id"></td>
                            <td style="vertical-align: middle;"><button class="button is-grey ml-1"><i class="fas fa-pen"></i></button><button class="button is-grey ml-1" @click="confirmDelete"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="users">
            <div class="table-container">
                <table id="user-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th>ID Number</th>
                            <th>Image</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID Number</th>
                            <th>Image</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(user, index) in users">
                            <td style="vertical-align: middle;" v-html="user.student_id"></td>
                            <td><img :src="'https://loremflickr.com/120/75/face/all?random='+index"/></td>
                            <td style="vertical-align: middle;" v-html="user.first_name"></td>
                            <td style="vertical-align: middle;" v-html="user.last_name"></td>
                            <td style="vertical-align: middle;" v-html="user.phone_number"></td>
                            <td style="vertical-align: middle;" v-html="user.email_address"></td>
                            <td style="vertical-align: middle;"><button class="button is-grey ml-1"><i class="fas fa-pen"></i></button><button class="button is-grey ml-1" @click="confirmDelete"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="contracts">
            <div class="table-container">
                <table class="table has-text-centered is-bordered is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th><abbr title="Position">Pos</abbr></th>
                            <th>Team</th>
                            <th><abbr title="Played">Pld</abbr></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th><abbr title="Position">Pos</abbr></th>
                          <th>Team</th>
                          <th><abbr title="Played">Pld</abbr></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr class="is-selected">
                            <th>1</th>
                            <td>+32</td>
                            <td>81</td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td>36</td>
                            <td>+29</td>
                        </tr>
                        <tr>
                            <th>3</th>
                            <td>13</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <th>4</th>
                            <td>+30</td>
                            <td>66</td>
                        </tr>
                        <tr>
                            <th>5</th>
                            <td>38</td>
                            <td>19</td>
                        </tr>
                        <tr>
                            <th>6</th>
                            <td>38</td>
                            <td>18</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="payments">
            <div class="table-container">
                <table class="table has-text-centered is-bordered is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th><abbr title="Position">Pos</abbr></th>
                            <th>Team</th>
                            <th><abbr title="Played">Pld</abbr></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th><abbr title="Position">Pos</abbr></th>
                          <th>Team</th>
                          <th><abbr title="Played">Pld</abbr></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr class="is-selected">
                            <th>1</th>
                            <td>+32</td>
                            <td>81</td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td>36</td>
                            <td>+29</td>
                        </tr>
                        <tr>
                            <th>3</th>
                            <td>13</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <th>4</th>
                            <td>+30</td>
                            <td>66</td>
                        </tr>
                        <tr>
                            <th>5</th>
                            <td>38</td>
                            <td>19</td>
                        </tr>
                        <tr>
                            <th>6</th>
                            <td>38</td>
                            <td>18</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <style type="text/css">
        .w-100 {
            width: 100%;
        }
    </style>
    <script type="text/javascript">
        function changeView(el){
            let view = el.getAttribute('data-view');
            let main = document.getElementById('main');
            let views = document.getElementById('views');
            let nav = document.getElementById('navigation');

            views.appendChild(main.children[0]);
            main.appendChild(document.getElementById(view));

            //Change Navigation Menu Highlight
            if(nav.children.length){
                for(let counter = 0, count = nav.children.length; counter < count; counter++)
                {
                    if(nav.children[counter].getAttribute('data-view') == view)
                    {nav.children[counter].classList.add('has-text-primary');}
                    else {nav.children[counter].classList.remove('has-text-primary');}
                }
            }
        }

        function recurse(el){
            console.log(el);
            if(el.children.length){
                for(let counter = 0, count = el.children.length; counter < count; counter++)
                {
                    recurse(el.children[counter]);
                }
            }
        }

        function changeForm(el){
            let form = el.getAttribute('data-form');
            let formArea = document.getElementById('register-form');
            let forms = document.getElementById('register-forms');
            if(formArea.children[0]){
                forms.appendChild(formArea.children[0]);
            }

            if(forms.children.length){
                for(let counter = 0, count = forms.children.length; counter < count; counter++)
                {
                    if(forms.children[counter].getAttribute('data-form') == form)
                    {
                        formArea.appendChild(forms.children[counter]);
                    }
                }
            }
        }
    </script>
@endsection
@section('top-body')
<script type="text/javascript">
    var map = null;
</script>
@endsection
@section('bottom-body')
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js" integrity="sha256-JLmknTdUZeZZ267LP9qB+/DT7tvxOOKctSKeUC2KT6E=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        new Vue({
            el: "#vehicle-table",
            data(){
                return {
                    vehicles: null
                }
            },
            methods: {
                confirmDelete() {
                    this.$buefy.dialog.confirm({
                        title: 'Deleting account',
                        message: 'Are you sure you want to <b>delete</b> your account? This action cannot be undone.',
                        confirmText: 'Delete Account',
                        type: 'is-danger',
                        hasIcon: true,
                        onConfirm: () => this.$buefy.toast.open('Account deleted!')
                    })
                },
                getVehicles(){ // [{license_plate_number:"8584JC",vehicle_name:"Hunda Axios Blade",manufacturer:"Hunda",model:"Super",year:"2025",max_capacity:"30"},{license_plate_number:"6545JC",vehicle_name:"Nissan Swift Cure",manufacturer:"Nissan",model:"Modest",year:"2019",max_capacity:"12"},{license_plate_number:"2654JC",vehicle_name:"Suzuki Mantis Swipe",manufacturer:"Suzuki",model:"Vroom",year:"2021",max_capacity:"23"}]
                    _this = this;
                    axios
                        .get("https://mp-app-server.herokuapp.com/vehicle",
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }}
                        )
                        .then(function(response){
                            _this.vehicles = response.data.data;
                        })
                }
            },
            mounted(){
                let _this = this;
                this.getVehicles();
                setInterval(function(){_this.getVehicles();console.log("Get Vehicles Interval");},15000);
            },
            computed: {}
        });

        new Vue({
            el: "#user-table",
            data(){
                return {
                    users:null
                }
            },
            methods: {
                editUser(){

                },
                confirmDelete() {
                    this.$buefy.dialog.prompt({
                        title: 'Deleting User',
                        message: 'Type "<b>DELETE</b>" to permanently delete this user? This action cannot be undone!',
                        inputAttrs: {
                            placeholder: 'e.g. DELETE',
                            maxlength: 20
                        },
                        trapFocus: true,
                        type: 'is-danger',
                        hasIcon: true,
                        confirmText: 'Delete User',
                        onConfirm: () => this.$buefy.toast.open('User deleted!')
                    })
                },
                getUsers(){
                    let _this = this;
                    axios
                        .get("https://mp-app-server.herokuapp.com/student",
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }}
                        )
                        .then(function(response){
                            _this.users = response.data.data;
                        })
                }
            },
            mounted(){
                let _this = this;
                this.getUsers();
                setInterval(function(){_this.getUsers();console.log("Get Users Interval");},15000);
            }
        });

        new Vue({
            el: "#frequency-chart",
            data: {},
            mounted(){
                console.log(this);

                console.log(this.$refs['vue-frequency-table']);
                let ctx = this.$refs['vue-frequency-table'].getContext('2d');
                let myChart = new Chart(ctx,{
                    type: 'bar',
                    data: {
                        labels: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30'],
                        datasets: [{
                            label: '30 Day Ride Summary',
                            data: [405, 531, 321, 432, 554, 221, 20, 505, 531, 421, 332, 554, 241, 30, 305, 531, 321, 432, 554, 221, 20,405, 531, 321, 432, 554, 221, 20,544,343],
                            backgroundColor: [
                              'rgba(75, 192, 192, 0.2)',
                            ],
                            borderColor: [
                              'rgb(75, 192, 192)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                          y: {beginAtZero: true}
                        }
                    },
                });
            },
            computed: {}
        });

        map = new Vue({
            el:'#mapbox-map',
            data:{
                map: null
            },
            mounted(){
                let position = {coords:{longitude:null,latitude:null}};
                position.coords.longitude = 18.016585; //University of Technology Lognitude
                position.coords.latitude = -76.744143; //University of Technology Latitude
                mapboxgl.accessToken = 'pk.eyJ1IjoiaWlwYWpjaWkiLCJhIjoiY2txYjRvdzFyMDFnejJubnI4eWpoeXFzOSJ9.RJxRW0BhhTnbe54PDSlDUA';
                this.map = new mapboxgl.Map({
                    container: 'mapbox-map', // container ID
                    style: 'mapbox://styles/mapbox/satellite-streets-v11', // style URL
                    center: [position.coords.latitude,position.coords.longitude], // starting position [lng, lat]
                    zoom: 15.8 // starting zoom
                });
            },
            methods:{
                resizeMap(){if(this._isMounted){this.map.resize()};}
            }
        });

        // Student Form Start
        new Vue({
            el:"#student-form",
            data(){
                return {}
            },
            mounted(){
            },
            methods:{
                registerStudent(){
                    let student_id = this.$refs.id.value;console.log(this.$refs.id.value);
                    let first_name = this.$refs.firstName.value;console.log(this.$refs.firstName.value);
                    let last_name = this.$refs.lastName.value;console.log(this.$refs.lastName.value);
                    let email = this.$refs.email.value;console.log(this.$refs.email.value);
                    let phone_number = this.$refs.phoneNumber.value;console.log(this.$refs.phoneNumber.value);

                    axios
                        .post("https://mp-app-server.herokuapp.com/student",
                            {"studentID": student_id,"firstName":first_name,"lastName":last_name,"emailAddress":email,"phoneNumber":phone_number},
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }},
                        )
                        .then(function(response){
                            if(!response.data.error){
                                console.log(response);
                            }
                        });
                }
            }
        })
        // Student Form Stop

        // Driver Form Start
        new Vue({
            el:"#driver-form",
            data(){
                return {}
            },
            mounted(){
            },
            methods:{
                registerDriver(){
                    let first_name = this.$refs.firstName.value;console.log(this.$refs.firstName.value);
                    let last_name = this.$refs.lastName.value;console.log(this.$refs.lastName.value);
                    let email = this.$refs.email.value;console.log(this.$refs.email.value);
                    let phone_number = this.$refs.phoneNumber.value;console.log(this.$refs.phoneNumber.value);

                    axios
                        .post("https://mp-app-server.herokuapp.com/driver",
                            {"firstName":first_name,"lastName":last_name,"emailAddress":email,"phoneNumber":phone_number},
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }},
                        )
                        .then(function(response){
                            if(!response.data.error){
                                console.log(response);
                            }
                        });
                }
            }
        })
        // Driver Form Stop

        // Vehicle Form Start
        new Vue({
            el:"#vehicle-form",
            data(){
                return {
                    drivers: null,
                    owners: null
                }
            },
            mounted(){
                let _this = this;
                _this.getDrivers();
                setInterval(function(){_this.getDrivers();console.log("Get Drivers Interval")}, 15000);
                _this.getOwners();
                setInterval(function(){_this.getOwners();console.log("Get Owners Interval")}, 15000);
            },
            methods:{
                getDrivers(){
                    let _this = this;
                    axios
                        .get("https://mp-app-server.herokuapp.com/driver",
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }}
                        )
                        .then(function(response){
                            _this.drivers = response.data.data;
                            console.log(response)
                        })
                },
                getOwners(){
                    let _this = this;
                    axios
                        .get("https://mp-app-server.herokuapp.com/owner",
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }}
                        )
                        .then(function(response){
                            _this.owners = response.data.data;
                            console.log(response)
                        })
                },
                registerVehicle(){
                    let plate_number = this.$refs.plateNumber.value;console.log(this.$refs.plateNumber.value);
                    let owner_id = this.$refs.ownerID.value;console.log(this.$refs.ownerID.value);
                    let driver_id = this.$refs.driverID.value;console.log(this.$refs.driverID.value);
                    let capacity = this.$refs.capacity.value;console.log(this.$refs.capacity.value);
                    let make = this.$refs.make.value;console.log(this.$refs.make.value);
                    let model = this.$refs.model.value;console.log(this.$refs.model.value);
                    let colour = this.$refs.colour.value;console.log(this.$refs.colour.value);

                    /*
                    {
                        "plateNumber":"7040LR",
                        "ownerID":4001,
                        "driverID":1002,
                        "capacity":5,
                        "make":"Nissan",
                        "model":"Pro-Box",
                        "colour":"White"
                    }
                    */
                    axios
                        .post("https://mp-app-server.herokuapp.com/vehicle",
                        {"plateNumber":plate_number,"ownerID":owner_id,"driverID":driver_id,"capacity":capacity,"make":make,"model":model,"colour":colour},
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }},
                        )
                        .then(function(response){
                            if(!response.data.error){
                                console.log(response);
                            }
                        });
                }
            }
        })
        // Vehicle Form Stop
    </script>
    <style type="text/css">
        html,body: {
            height: 100%;
        }
    </style>


@endsection
