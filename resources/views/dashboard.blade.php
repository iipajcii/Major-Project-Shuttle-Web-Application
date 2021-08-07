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
    <!-- SimpleZip Script--><script src="https://cdn.jsdelivr.net/npm/simplezip.js@1.0.0/lib/index.js" integrity="sha256-P0lkViV6CxibcFp/zbjrAtCnCESsAdt/18dIICXXq/c=" crossorigin="anonymous"></script>

@endsection
@section('content')
    <section class="columns">
        <div class="column is-2" id='navigation' style="border-right: solid #ddd 1px;">
            <div class="w-100 p-4 m-0 has-text-weight-bold has-text-primary" data-view="home" onclick="changeView(this)"><i class="fas fa-home"></i>&nbsp;&nbsp;Home</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="map" onclick="changeView(this); map.resizeMap()"><i class="fas fa-map"></i>&nbsp;&nbsp;Map</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="register" onclick="changeView(this)"><i class="fas fa-file-signature"></i>&nbsp;&nbsp;Register</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="routes" onclick="changeView(this);"><i class="fas fa-map"></i>&nbsp;&nbsp;Routes</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="vehicles" onclick="changeView(this)"><i class="fas fa-bus-alt"></i>&nbsp;&nbsp;Vehicles</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="students" onclick="changeView(this)"><i class="fas fa-user-cog"></i>&nbsp;&nbsp;Students</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="drivers" onclick="changeView(this)"><i class="fas fa-user-cog"></i>&nbsp;&nbsp;Drivers</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="owners" onclick="changeView(this)"><i class="fas fa-user-cog"></i>&nbsp;&nbsp;Owners</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="contracts" onclick="changeView(this)"><i class="fas fa-file-contract"></i>&nbsp;&nbsp;Contracts</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="payments" onclick="changeView(this)"><i class="fas fa-file-invoice-dollar"></i>&nbsp;&nbsp;Payments</div>
            <div class="w-100 p-4 m-0 has-text-weight-bold" data-view="reports" onclick="changeView(this)"><i class="fas fa-file-csv"></i>&nbsp;&nbsp;Reports</div>
        </div>
        <div class="column is-10 pt-5 pr-5" id='main'>
            <div id="home">
                <div class="columns is-multiline">
                    <div class="column is-full">
                        <div class="card">
                          <div class="card-content">
                            <div class="content">
                                <h1 class="is-size-4">Welcome to the USU Shuttle Service Web Application!</h1>
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
                                <p class="is-size-5" v-html="routeCount"></p>
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
                                <p class="is-size-5" v-html="vehicleCount"></p>
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
                                <p class="is-size-5" v-html="studentCount"></p>
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
                                <p class="is-size-5" v-html="driverCount"></p>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                {{--
                <div id="frequency-chart">
                    <canvas ref="vue-frequency-table" width="100%" min-height="400"></canvas>
                </div>
                --}}
            </div>
        </div>
    </section>
    {{-- Section where all the views are stored --}}
    <section style="display:none" id='views'>
        <div id="map" style="height:100%;">
            <div id='mapbox-map' style='width: 100%; min-height: 600px;' onload="this.style.width=100%;"></div>
        </div>
        <div id="register">
            <div class="columns w-100 is-variable is-1 is-multiline">
                <div class="column is-4">
                    <div class="columns w-100 is-variable is-1 is-multiline">
                        <div class="column is-full" data-form="student" onclick="changeForm(this)"><p class="button is-medium is-light has-text-centered w-100"><i class="fas fa-user-graduate"></i>&nbsp;&nbsp;Register Student</p></div>
                        <div class="column is-full" data-form="driver"  onclick="changeForm(this)"><p class="button is-medium is-light has-text-centered w-100"><i class="fas fa-id-badge"></i>&nbsp;&nbsp;Register Driver</p></div>
                        <div class="column is-full" data-form="owner"  onclick="changeForm(this)"><p class="button is-medium is-light has-text-centered w-100"><i class="fas fa-id-card"></i>&nbsp;&nbsp;Register Owner</p></div>
                        <div class="column is-full" data-form="vehicle" onclick="changeForm(this)"><p class="button is-medium is-light has-text-centered w-100"><i class="fas fa-bus"></i>&nbsp;&nbsp;Register Vehicle</p></div>
                        <div class="column is-full" data-form="contract" onclick="changeForm(this)"><p class="button is-medium is-light has-text-centered w-100"><i class="fas fa-file-contract"></i>&nbsp;&nbsp;Register Contract</p></div>
                        <div class="column is-full" data-form="route" onclick="changeForm(this)"><p class="button is-medium is-light has-text-centered w-100"><i class="fas fa-file-contract"></i>&nbsp;&nbsp;Register Route</p></div>
                        <div class="column is-full" data-form="payment" onclick="changeForm(this)"><p class="button is-medium is-light has-text-centered w-100"><i class="fas fa-file-contract"></i>&nbsp;&nbsp;Create Payment</p></div>
                    </div>
                </div>
                <div class="column is-offset-1 is-7">
                    <div class="columns w-100 p-4" id='register-form'>
                        <h1 class="has-text-centered has-text-grey is-size-4 w-100">The selected form will appear here</h1>
                    </div>
                        <div id='register-forms' style="display:none">
                            <form key="student" data-form="student" id="student-form">
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
                                        <input class="button is-primary" ref="registrationButton" @click="registerStudent" value="Submit">
                                    </div>
                                </div>
                            </form>

                            <form key="driver" data-form="driver" id="driver-form">
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
                                    <div class="control">
                                        <input class="button is-primary" ref="registrationButton" @click="registerDriver" value="Submit">
                                    </div>
                                </div>
                            </form>

                            <form key="owner" data-form="owner" id="owner-form">
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
                                    <div class="control">
                                        <input class="button is-primary" ref="registrationButton" @click="registerOwner" value="Submit">
                                    </div>
                                </div>
                            </form>

                            <form key="vehicle" data-form="vehicle" id="vehicle-form">
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
                                    <div class="select is-fullwidth">
                                        <select ref="driverID" class="select">
                                            <option value="" selected></option>
                                            <option v-for="(driver,index) in drivers" v-html="driver.driver_id+' -- '+driver.first_name+' '+driver.last_name" :value="driver.driver_id"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Owner ID</label>
                                    <div class="select is-fullwidth">
                                        <select class="select" ref="ownerID">
                                            <option value="" selected></option>
                                            <option v-for="(owner,index) in owners" v-html="owner.owner_id+' -- '+owner.first_name+' '+owner.last_name" :value="owner.owner_id"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input class="button is-primary" ref="registrationButton" @click="registerVehicle" value="Submit">
                                    </div>
                                </div>
                            </form>

                            <form key="contract" data-form="contract" id="contract-form">
                                <div class="field">
                                    <label class="label">Contract Number</label>
                                    <div class="control">
                                        <input ref="contractNumber" class="input" type="text" placeholder="e.g. 100140-01DP/DT">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Processing Number</label>
                                    <div class="control">
                                        <input ref="prNumber" class="input" type="text" placeholder="e.g. 10014-PG6055">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Procurement Officer</label>
                                    <div class="control">
                                        <input ref="procurementOfficer" class="input" type="text" placeholder="e.g. Alecia Thomas, Vice President Student Services">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Contractor</label>
                                    <div class="control">
                                        <input ref="contractor" class="input" type="text" placeholder="e.g. General Hall, Spanish Town St.Catherine">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Issue Date</label>
                                    <div class="control">
                                        <input ref="issueDate" class="input" type="date">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Expiration Date</label>
                                    <div class="control">
                                        <input ref="expirationDate" class="input" type="date">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Due Date</label>
                                    <div class="control">
                                        <input ref="dueDate" class="input" type="date">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Vehicle</label>
                                    <div class="select is-fullwidth">
                                        <select ref="vehicleID" class="select">
                                            <option value="" selected></option>
                                            <option v-for="(vehicle,index) in vehicles" v-html="vehicle.vehicle_id+' -- '+vehicle.plate_number" :value="vehicle.vehicle_id"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Owner</label>
                                    <div class="select is-fullwidth">
                                        <select class="select" ref="ownerID">
                                            <option value="" selected></option>
                                            <option v-for="(owner,index) in owners" v-html="owner.owner_id+' -- '+owner.first_name+' '+owner.last_name" :value="owner.owner_id"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Route</label>
                                    <div class="select is-fullwidth">
                                        <select class="select" ref="routeID">
                                            <option value="" selected></option>
                                            <option v-for="(route,index) in routes" v-html="route.route_id+' -- '+route.description" :value="route.route_id"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input class="button is-primary" ref="registrationButton" @click="createContract" value="Submit">
                                    </div>
                                </div>
                            </form>

                            <form key="route" data-form="route" id="route-form">
                                <div class="field">
                                    <label class="label">Starting Location</label>
                                    <div class="control">
                                        <input ref="startingLocation" class="input" type="text" placeholder="e.g. George Town">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Destination</label>
                                    <div class="control">
                                        <input ref="destination" class="input" type="text" placeholder="e.g. UTech Papine Campus">
                                    </div>
                                </div>
                                <label class="label">Fee</label>
                                <div class="field has-addons">
                                    <p class="control">
                                        <span class="button">$</span>
                                    </p>
                                    <p class="control is-expanded">
                                        <input ref="fee" class="input" type="text" placeholder="Amount of money">
                                    </p>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input class="button is-primary" ref="registrationButton" @click="createRoute" value="Submit">
                                    </div>
                                </div>
                            </form>

                            <form key="payment" data-form="payment" id="payment-form">
                                <div class="field">
                                    <label class="label">Paid By</label>
                                    <div class="control">
                                        <input ref="done_by" class="input" type="text" value="">
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Payment Type</label>
                                    <div class="select is-fullwidth">
                                        <select ref="payment_type" class="select" required>
                                            <option value="" selected></option>
                                            <option value="deposit">Deposit</option>
                                            <option value="charge">Charge</option>
                                        </select>
                                    </div>
                                </div>
                                <label class="label">Amount</label>
                                <div class="field has-addons">
                                    <p class="control">
                                        <span class="button">$</span>
                                    </p>
                                    <p class="control is-expanded">
                                        <input ref="amount" class="input" type="text" placeholder="Amount of money">
                                    </p>
                                </div>
                                <div class="field">
                                    <label class="label">Description</label>
                                    <div class="control">
                                        <textarea ref="description" class="textarea"></textarea>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Contract</label>
                                    <div class="select is-fullwidth">
                                        <select ref="contractID" class="select">
                                            <option value="" selected></option>
                                            <option v-for="(contract,index) in contracts" v-html="contract.contract_id+' -- '+contract.contract_number" :value="contract.contract_id"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input class="button is-primary" ref="registrationButton" @click="createPayment" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="vehicles">
            <div class="table-container">
                <table id="vehicle-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth" style=" white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Vehicle ID</th>
                            <th>License Plate Number</th>
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
                            <td style="vertical-align: middle;" v-html="vehicle.colour"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.make"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.model"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.capacity"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.owner_id"></td>
                            <td style="vertical-align: middle;" v-html="vehicle.driver_id"></td>
                            <td style="vertical-align: middle;"><button class="button is-small is-grey ml-1" @click="updateVehicle(vehicle.vehicle_id)"><i class="fas fa-pen"></i></button><button class="button is-small is-grey ml-1" @click="confirmDelete(vehicle.vehicle_id)"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="students">
            <div class="table-container">
                <table id="student-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth" style=" white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>ID Number</th>
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
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(student, index) in students">
                            <td style="vertical-align: middle;" v-html="student.student_id"></td>
                            <td style="vertical-align: middle;" v-html="student.first_name"></td>
                            <td style="vertical-align: middle;" v-html="student.last_name"></td>
                            <td style="vertical-align: middle;" v-html="student.phone_number"></td>
                            <td style="vertical-align: middle;" v-html="student.email_address"></td>
                            <td style="vertical-align: middle;"><button class="button is-small is-grey ml-1" @click="updateStudent(student.student_id)"><i class="fas fa-pen"></i></button><button class="button is-small is-grey ml-1" @click="confirmDelete(student.student_id)"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="drivers">
            <div class="table-container">
                <table id="driver-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth" style=" white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(driver, index) in drivers">
                            <td style="vertical-align: middle;" v-html="driver.first_name"></td>
                            <td style="vertical-align: middle;" v-html="driver.last_name"></td>
                            <td style="vertical-align: middle;" v-html="driver.phone_number"></td>
                            <td style="vertical-align: middle;" v-html="driver.email_address"></td>
                            <td style="vertical-align: middle;"><button class="button is-small is-grey ml-1" @click="updateDriver(driver.driver_id)"><i class="fas fa-pen"></i></button><button class="button is-small is-grey ml-1" @click="confirmDelete(driver.driver_id)"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="owners">
            <div class="table-container">
                <table id="owner-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth" style=" white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(owner, index) in owners">
                            <td style="vertical-align: middle;" v-html="owner.first_name"></td>
                            <td style="vertical-align: middle;" v-html="owner.last_name"></td>
                            <td style="vertical-align: middle;" v-html="owner.phone_number"></td>
                            <td style="vertical-align: middle;" v-html="owner.email_address"></td>
                            <td style="vertical-align: middle;"><button class="button is-small is-grey ml-1" @click="updateOwner(owner.owner_id)"><i class="fas fa-pen"></i></button><button class="button is-small is-grey ml-1" @click="confirmDelete(owner.owner_id)"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="contracts">
            <div class="table-container">
                <table id="contracts-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth" style=" white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Contract Number</th>
                            <th>Processing Number</th>
                            <th>Procurement Officer</th>
                            <th>Contractor</th>
                            <th>Issue Date</th>
                            <th>Expiration Date</th>
                            <th>Due Date</th>
                            <th>Route ID</th>
                            <th>Vehicle ID</th>
                            <th>Owner ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Contract Number</th>
                            <th>Processing Number</th>
                            <th>Procurement Officer</th>
                            <th>Contractor</th>
                            <th>Issue Date</th>
                            <th>Expiration Date</th>
                            <th>Due Date</th>
                            <th>Route ID</th>
                            <th>Vehicle ID</th>
                            <th>Owner ID</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(contract, index) in contracts">
                            <td style="vertical-align: middle;" v-html="contract.contract_id"></td>
                            <td style="vertical-align: middle;" v-html="contract.pr_number"></td>
                            <td style="vertical-align: middle;" v-html="contract.procurement_officer"></td>
                            <td style="vertical-align: middle;" v-html="contract.contractor"></td>
                            <td style="vertical-align: middle;" v-html="contract.issue_date"></td>
                            <td style="vertical-align: middle;" v-html="contract.expiration_date"></td>
                            <td style="vertical-align: middle;" v-html="contract.due_date"></td>
                            <td style="vertical-align: middle;" v-html="contract.route_id"></td>
                            <td style="vertical-align: middle;" v-html="contract.vehicle_id"></td>
                            <td style="vertical-align: middle;" v-html="contract.owner_id"></td>
                            <td style="vertical-align: middle;"><button class="button is-small is-grey ml-1" @click="updateContract(contract.contract_id)"><i class="fas fa-pen"></i></button><button class="button is-small is-grey ml-1" @click="confirmDelete(contract.contract_id)"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="routes">
            <div class="table-container">
                <table id="routes-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth"  style=" white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Route Description</th>
                            <th>Route Fee</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Route Description</th>
                            <th>Route Fee</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(route, index) in routes">
                            <td style="vertical-align: middle;" v-html="route.description"></td>
                            <td style="vertical-align: middle;" v-html="route.fee"></td>
                            <td style="vertical-align: middle;"><button class="button is-small is-grey ml-1" @click="updateRoute(route.route_id)"><i class="fas fa-pen"></i></button><button class="button is-small is-grey ml-1" @click="confirmDelete(route.route_id)"><i class="fas fa-trash"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="payments">
            <div class="table-container">
                <table id="payments-table" class="table has-text-centered is-bordered is-hoverable is-fullwidth" style=" white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>Payment Number</th>
                            <th>Date Processed</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Done By</th>
                            <th>Contract</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Payment Number</th>
                            <th>Date Processed</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Done By</th>
                            <th>Contract</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(payment, index) in payments">
                            <td style="vertical-align: middle;" v-html="payment.payment_id"></td>
                            <td style="vertical-align: middle;" v-html="payment.processed_on"></td>
                            <td style="vertical-align: middle;" v-html="payment.payment_type"></td>
                            <td style="vertical-align: middle;" v-html="payment.amount"></td>
                            <td style="vertical-align: middle;" v-html="payment.description"></td>
                            <td style="vertical-align: middle;" v-html="payment.done_by"></td>
                            <td style="vertical-align: middle;" v-html="payment.contract_id"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="reports" style="height:100%;">
            <div class="columns w-100 is-variable is-1">
                <div class="column is-one-fourth"><a class="button is-primary" ref="generalReport" @click="downloadGeneralReport">Download General Report</a></div>
                <div class="column is-one-fourth"></div>
                <div class="column is-one-fourth"></div>
                <div class="column is-one-fourth"></div>
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
                    if(forms.children[counter] && forms.children[counter].getAttribute('data-form') == form)
                    {
                        formArea.appendChild(forms.children[counter]);
                    }
                }
            }
        }
    </script>
@endsection
@section('top-body')
@endsection
@section('bottom-body')
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js" integrity="sha256-JLmknTdUZeZZ267LP9qB+/DT7tvxOOKctSKeUC2KT6E=" crossorigin="anonymous"></script>
    <script>
        var logout = new Vue({
            el:"#logout",
            data(){
                return {

                }
            },
            mounted(){

            },
            methods:{
                logout(){
                    this.$refs.logoutButton.classList.add('is-loading');
                    _this = this;
                    axios
                        .post("https://mp-authentication-server.herokuapp.com/logout",
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_refresh_token")}`
                            }}
                        )
                        .then(function(response){

                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        })
                        .then(function(response){
                            window.localStorage.setItem("usu_access_token","");
                            window.localStorage.setItem("usu_refresh_token","");
                            window.localStorage.setItem("usu_username","");
                            window.location.href = window.location.protocol + "//" + window.location.host + "/";
                        })
                }
            }
        })
        var vehicleVue = new Vue({
            el: "#vehicle-table",
            data(){
                return {
                    vehicles: null,
                    vehicle: null
                }
            },
            mounted(){
                window.vehicle = {}
                let _this = this;
                this.getVehicles();
            },
            methods: {
                confirmDelete(id) {
                    let _this = this;
                    this.$buefy.dialog.prompt({
                        title: 'Deleting Vehicle',
                        message: 'Type <b><i>your account password</i></b> to permanently delete this vehicle? This action cannot be undone!',
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 40,
                            type: 'password',
                            autocomplete:"off"
                        },
                        confirmText: 'Delete Vehicle',
                        trapFocus: true,
                        type: 'is-danger',
                        hasIcon: true,
                        onConfirm(value){
                            axios({
                                method: 'delete',
                                url: `https://mp-app-server.herokuapp.com/vehicle/${id}`,
                                headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                                },
                                data: {
                                adminPassword:value
                                }
                            })
                            .then(function(response){
                                _this.vehicles = response.data.data;
                                _this.$buefy.toast.open('Vehicle deleted!');
                                _this.getVehicles();
                            })
                            .catch(function(error){
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this vehicle record',type:"is-danger"});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                updateVehicle(id){
                    let vehicle = null;
                    let _this = this;
                    for(let counter = 0, count = this.vehicles.length; counter < count; counter++){
                        if(this.vehicles[counter].vehicle_id == id){
                            vehicle = this.vehicles[counter];
                            window.vehicle = this.vehicles[counter];
                            break;
                        }
                    }
                    this.$buefy.dialog.confirm({
                        title: 'Update Vehicle',
                        message: `
                            <div class="field">
                                <label class="label">Plate Number</label>
                                <div class="control">
                                    <input class="input" oninput="window.vehicle.plate_number = this.value " value="${vehicle.plate_number}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Capacity</label>
                                <div class="control">
                                    <input class="input" oninput="window.vehicle.capacity = this.value " value="${vehicle.capacity}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Make</label>
                                <div class="control">
                                    <input class="input" oninput="window.vehicle.make = this.value " value="${vehicle.make}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Model</label>
                                <div class="control">
                                    <input class="input" oninput="window.vehicle.model = this.value " value="${vehicle.model}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Colour</label>
                                <div class="control">
                                    <input class="input" oninput="window.vehicle.colour = this.value " value="${vehicle.colour}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Owner ID</label>
                                <div class="control">
                                    <input class="input" oninput="window.vehicle.owner_id = this.value " value="${vehicle.owner_id}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Driver ID</label>
                                <div class="control">
                                    <input class="input" oninput="window.vehicle.driver_id = this.value " value="${vehicle.driver_id}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Route ID</label>
                                <div class="control">
                                    <input class="input" oninput="window.vehicle.route_id = this.value " value="${vehicle.route_id == null ? '' : vehicle.route_id}" type="text" placeholder="Text input">
                                </div>
                            </div>
                        `,
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 20,
                            type: 'password',
                            autocomplete:"off"
                        },
                        size: 'is-medium',
                        trapFocus: true,
                        type: 'is-success',
                        confirmText: 'Update Vehicle',
                        onConfirm(value){
                            this.$buefy.toast.open('Vehicle Updated!');
                            axios({
                              method: 'put',
                              url: `https://mp-app-server.herokuapp.com/vehicle/${id}`,
                              headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                              },
                              data: {
                                plateNumber: window.vehicle.plate_number,
                                ownerID: window.vehicle.owner_id,
                                driverID: window.vehicle.driver_id,
                                capacity: window.vehicle.capacity,
                                make: window.vehicle.make,
                                model: window.vehicle.model,
                                colour: window.vehicle.colour
                              }
                            })
                            .then(function(response){
                                _this.$buefy.toast.open('Vehicle Updated!');
                                _this.getVehicles();
                            })
                            .catch(function(error){
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this vehicle record',type:"is-danger"});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                getVehiclesPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/vehicle",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}})
                },
                getVehicles(){
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
                        .catch(function(error){
                            window.utility.refreshToken();
                        })
                }
            },
            computed: {}
        });

        var studentsVue = new Vue({
            el: "#student-table",
            data(){
                return {
                    students:null,
                    student:null
                }
            },
            mounted(){
                window.student = {};
                let _this = this;
                this.getStudents();
            },
            methods: {
                confirmDelete(id) {
                    let _this = this;
                    this.$buefy.dialog.prompt({
                        title: 'Deleting Student',
                        message: 'Type <b><i>your account password</i></b> to permanently delete this student? This action cannot be undone!',
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 20,
                            type: 'password',
                            autocomplete:"off"
                        },
                        trapFocus: true,
                        type: 'is-danger',
                        hasIcon: true,
                        confirmText: 'Delete Student',
                        onConfirm(value){
                            axios({
                              method: 'delete',
                              url: `https://mp-app-server.herokuapp.com/student/${id}`,
                              headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                              },
                              data: {
                                adminPassword:value
                              }
                            })
                            .then(function(response){
                                _this.$buefy.toast.open('Student deleted!');
                                _this.students = response.data.data;
                                _this.getStudents();
                            })
                            .catch(function(error){
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this student record',type:'is-danger'});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                updateStudent(id){
                    let student = null;
                    let _this = this;
                    for(let counter = 0, count = this.students.length; counter < count; counter++){
                        if(this.students[counter].student_id == id){
                            student = this.students[counter];
                            window.student = this.students[counter];
                            break;
                        }
                    }
                    this.$buefy.dialog.confirm({
                        title: 'Update Vehicle',
                        message: `
                            <div class="field">
                                <label class="label">First Name</label>
                                <div class="control">
                                    <input class="input" oninput="window.student.first_name = this.value " value="${student.first_name}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Last Name</label>
                                <div class="control">
                                    <input class="input" oninput="window.student.last_name = this.value " value="${student.last_name}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Phone Number</label>
                                <div class="control">
                                    <input class="input" oninput="window.student.phone_number = this.value " value="${student.phone_number}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Email Address</label>
                                <div class="control">
                                    <input class="input" oninput="window.student.email_address = this.value " value="${student.email_address}" type="text" placeholder="Text input">
                                </div>
                            </div>
                        `,
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 20,
                            type: 'password',
                            autocomplete:"off"
                        },
                        size: 'is-medium',
                        trapFocus: true,
                        type: 'is-success',
                        confirmText: 'Update Student',
                        onConfirm(value){

                            axios({
                              method: 'put',
                              url: `https://mp-app-server.herokuapp.com/student/${id}`,
                              headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                              },
                              data: {
                                firstName: window.student.first_name,
                                lastName: window.student.last_name,
                                phoneNumber: window.student.phone_number,
                                emailAddress: window.student.email_address,
                                password: window.localStorage.getItem("usu_password")
                              }
                            })
                            .then(function(response){
                                _this.$buefy.toast.open('Student Updated!');
                                _this.getStudents();
                            })
                            .catch(function(error){
                                window.utility.refreshToken();
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this student record',type:"is-danger"});
                            })
                        }
                    })
                },
                getStudentsPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/student",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}})
                },
                getStudents(){
                    let _this = this;
                    axios
                        .get("https://mp-app-server.herokuapp.com/student",
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }}
                        )
                        .then(function(response){
                            _this.students = response.data.data;
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        })
                }
            }
        });

        var driversVue = new Vue({
            el: "#driver-table",
            data(){
                return {
                    drivers:null,
                    driver:null
                }
            },
            mounted(){
                window.driver = {};
                let _this = this;
                this.getDrivers();
            },
            methods: {
                confirmDelete(id) {
                    let _this = this;
                    this.$buefy.dialog.prompt({
                        title: 'Deleting Driver',
                        message: 'Type <b><i>your account password</i></b> to permanently delete this driver? This action cannot be undone!',
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 20,
                            type: 'password',
                            autocomplete:"off"
                        },
                        trapFocus: true,
                        type: 'is-danger',
                        hasIcon: true,
                        confirmText: 'Delete Driver',
                        onConfirm(value){
                            axios({
                              method: 'delete',
                              url: `https://mp-app-server.herokuapp.com/driver/${id}`,
                              headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                              },
                              data: {
                                adminPassword:value
                              }
                            })
                            .then(function(response){
                                console.log(response);
                                _this.$buefy.toast.open('Driver deleted!');
                                _this.drivers = response.data.data;
                                _this.getDrivers();
                            })
                            .catch(function(error){
                                console.log('error');
                                console.log(error);
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this driver record',type:"is-danger"});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                updateDriver(id){
                    let driver = null;
                    let _this = this;
                    for(let counter = 0, count = this.drivers.length; counter < count; counter++){
                        if(this.drivers[counter].driver_id == id){
                            driver = this.drivers[counter];
                            window.driver = this.drivers[counter];
                            break;
                        }
                    }
                    this.$buefy.dialog.confirm({
                        title: 'Update Driver',
                        message: `
                            <div class="field">
                                <label class="label">First Name</label>
                                <div class="control">
                                    <input class="input" oninput="window.driver.first_name = this.value " value="${driver.first_name}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Last Name</label>
                                <div class="control">
                                    <input class="input" oninput="window.driver.last_name = this.value " value="${driver.last_name}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Phone Number</label>
                                <div class="control">
                                    <input class="input" oninput="window.driver.phone_number = this.value " value="${driver.phone_number}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Email Address</label>
                                <div class="control">
                                    <input class="input" oninput="window.driver.email_address = this.value " value="${driver.email_address}" type="text" placeholder="Text input">
                                </div>
                            </div>
                        `,
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 20,
                            type: 'password',
                            autocomplete:"off"
                        },
                        size: 'is-medium',
                        trapFocus: true,
                        type: 'is-success',
                        confirmText: 'Update Driver',
                        onConfirm(value){
                            this.$buefy.toast.open('Driver Updated!');
                            axios({
                                method: 'put',
                                url: `https://mp-app-server.herokuapp.com/driver/${id}`,
                                headers:{
                                    "Content-type":"application/json",
                                    "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                                },
                                data: {
                                    firstName: window.driver.first_name,
                                    lastName: window.driver.last_name,
                                    phoneNumber: window.driver.phone_number,
                                    emailAddress: window.driver.email_address,
                                    password: window.localStorage.getItem("usu_password")
                                }
                            })
                            .then(function(response){
                                _this.$buefy.toast.open('Driver Updated!');
                                _this.getDrivers();
                            })
                            .catch(function(error){
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this driver record',type:"is-danger"});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                getDriversPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/driver",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}})
                },
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
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        });
                }
            }
        });

        var ownersVue = new Vue({
            el: "#owner-table",
            data(){
                return {
                    owners:null,
                    owner:null
                }
            },
            mounted(){
                window.owner = {};
                let _this = this;
                this.getOwners();
            },
            methods: {
                confirmDelete(id) {
                    let _this = this;
                    this.$buefy.dialog.prompt({
                        title: 'Deleting Owner',
                        message: 'Type <b><i>your account password</i></b> to permanently delete this owner? This action cannot be undone!',
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 20,
                            type: 'password',
                            autocomplete:"off"
                        },
                        trapFocus: true,
                        type: 'is-danger',
                        hasIcon: true,
                        confirmText: 'Delete Owner',
                        onConfirm(value){
                            axios({
                              method: 'delete',
                              url: `https://mp-app-server.herokuapp.com/owner/${id}`,
                              headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                              },
                              data: {
                                adminPassword:value
                              }
                            })
                            .then(function(response){
                                _this.$buefy.toast.open('Owner deleted!');
                                _this.owners = response.data.data;
                                _this.getOwners();
                            })
                            .catch(function(error){
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this owner record',type:"is-danger"});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                updateOwner(id){
                    let _this = this;
                    let owner = null;
                    for(let counter = 0, count = this.owners.length; counter < count; counter++){
                        if(this.owners[counter].owner_id == id){
                            owner = this.owners[counter];
                            window.owner = this.owners[counter];
                            break;
                        }
                    }
                    this.$buefy.dialog.confirm({
                        title: 'Update Owner',
                        message: `
                            <div class="field">
                                <label class="label">First Name</label>
                                <div class="control">
                                    <input class="input" oninput="window.owner.first_name = this.value " value="${owner.first_name}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Last Name</label>
                                <div class="control">
                                    <input class="input" oninput="window.owner.last_name = this.value " value="${owner.last_name}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Phone Number</label>
                                <div class="control">
                                    <input class="input" oninput="window.owner.phone_number = this.value " value="${owner.phone_number}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Email Address</label>
                                <div class="control">
                                    <input class="input" oninput="window.owner.email_address = this.value " value="${owner.email_address}" type="text" placeholder="Text input">
                                </div>
                            </div>
                        `,
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 20,
                            type: 'password',
                            autocomplete:"off"
                        },
                        size: 'is-medium',
                        trapFocus: true,
                        type: 'is-success',
                        confirmText: 'Update Owner',
                        onConfirm(value){
                            axios({
                              method: 'put',
                              url: `https://mp-app-server.herokuapp.com/owner/${id}`,
                              headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                              },
                              data: {
                                firstName: window.owner.first_name,
                                lastName: window.owner.last_name,
                                phoneNumber: window.owner.phone_number,
                                emailAddress: window.owner.email_address,
                                password: window.localStorage.getItem("usu_password")
                            }
                            })
                            .then(function(response){
                                _this.$buefy.toast.open('Owner Updated!');
                                _this.getOwners();
                            })
                            .catch(function(error){
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this owner record',type:"is-danger"});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                getOwnersPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/owner",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}})
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
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        })
                }
            }
        });

        /*
        new Vue({
            el: "#frequency-chart",
            data: {},
            mounted(){
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
        */

        var map = new Vue({
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
        var studentForm = new Vue({
            el:"#student-form",
            data(){
                return {}
            },
            mounted(){
            },
            methods:{
                registerStudent(){
                    let _this = this;
                    this.$refs.registrationButton.setAttribute("disabled","");
                    this.$refs.registrationButton.classList.add("is-loading");
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
                            _this.$buefy.dialog.alert('Student Registered!')
                            _this.$refs.id.value = "";
                            _this.$refs.firstName.value = "";
                            _this.$refs.lastName.value = "";
                            _this.$refs.email.value = "";
                            _this.$refs.phoneNumber.value = "";
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        });
                    this.$refs.registrationButton.removeAttribute("disabled");
                    this.$refs.registrationButton.classList.remove("is-loading");
                }
            }
        })
        // Student Form Stop

        // Driver Form Start
        var driverForm = new Vue({
            el:"#driver-form",
            data(){
                return {}
            },
            mounted(){
            },
            methods:{
                registerDriver(){
                    let _this = this;
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
                            _this.$buefy.dialog.alert('Driver Registered!')
                            _this.$refs.firstName.value;
                            _this.$refs.lastName.value;
                            _this.$refs.email.value;
                            _this.$refs.phoneNumber.value;
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        });
                }
            }
        })
        // Driver Form Stop

        // Vehicle Form Start
        var vehicleFormVue = new Vue({
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
                _this.getOwners();
            },
            methods:{
                getDriversPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/driver",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}});
                },
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
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        })
                },
                getOwnersPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/owner",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}});
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
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        })
                },
                registerVehicle(){
                    let _this = this;
                    let plate_number = this.$refs.plateNumber.value;console.log(this.$refs.plateNumber.value);
                    let owner_id = this.$refs.ownerID.value;console.log(this.$refs.ownerID.value);
                    let driver_id = this.$refs.driverID.value;console.log(this.$refs.driverID.value);
                    let capacity = this.$refs.capacity.value;console.log(this.$refs.capacity.value);
                    let make = this.$refs.make.value;console.log(this.$refs.make.value);
                    let model = this.$refs.model.value;console.log(this.$refs.model.value);
                    let colour = this.$refs.colour.value;console.log(this.$refs.colour.value);

                    axios
                        .post("https://mp-app-server.herokuapp.com/vehicle",
                        {"plateNumber":plate_number,"ownerID":owner_id,"driverID":driver_id,"capacity":capacity,"make":make,"model":model,"colour":colour},
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }},
                        )
                        .then(function(response){
                            _this.$buefy.dialog.alert('Vehicle Registered!');
                            _this.$refs.plateNumber.value = ""
                            _this.$refs.ownerID.value = ""
                            _this.$refs.driverID.value = ""
                            _this.$refs.capacity.value = ""
                            _this.$refs.make.value = ""
                            _this.$refs.model.value = ""
                            _this.$refs.colour.value = ""
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        });
                }
            }
        })
        // Vehicle Form Stop

        // Owner Form Start
        var ownerForm = new Vue({
            el:"#owner-form",
            data(){
                return {}
            },
            mounted(){
            },
            methods:{
                registerOwner(){
                    let _this = this;
                    let first_name = this.$refs.firstName.value;console.log(this.$refs.firstName.value);
                    let last_name = this.$refs.lastName.value;console.log(this.$refs.lastName.value);
                    let email = this.$refs.email.value;console.log(this.$refs.email.value);
                    let phone_number = this.$refs.phoneNumber.value;console.log(this.$refs.phoneNumber.value);

                    axios
                        .post("https://mp-app-server.herokuapp.com/owner",
                            {"firstName":first_name,"lastName":last_name,"emailAddress":email,"phoneNumber":phone_number},
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }},
                        )
                        .then(function(response){
                            _this.$buefy.dialog.alert('Owner Registered!');
                            _this.$refs.firstName.value = "";
                            _this.$refs.lastName.value = "";
                            _this.$refs.email.value = "";
                            _this.$refs.phoneNumber.value = "";
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        });
                }
            }
        })
        // Owner Form Stop

        // Report Menu Start
        var reportManager = new Vue({
            el:"#reports",
            data(){
                return {}
            },
            methods:{
                downloadGeneralReport(){
                    Promise.all([vehicleVue.getVehiclesPromise(),studentsVue.getStudentsPromise(),vehicleFormVue.getDriversPromise()])
                        .then(function(response){
                            let vehicles = response[0].data.data;
                            let students = response[1].data.data;
                            let drivers  = response[2].data.data;

                            let studentContent = "Student ID,First Name,Last Name,Phone Number,Email Address\n";
                            for(let counter = 0, count = students.length; counter < count; counter++){
                                studentContent += students[counter].student_id + ","
                                studentContent += students[counter].first_name + ","
                                studentContent += students[counter].last_name + ","
                                studentContent += students[counter].phone_number + ","
                                studentContent += students[counter].email_address + "\n"
                            }

                            let vehicleContent = "Vehicle ID,Plate Number,Colour,Make,Model,Maximum Capacity,Owner ID,Driver ID\n";
                            for(let counter = 0, count = vehicles.length; counter < count; counter++)
                            {
                                vehicleContent += vehicles[counter].vehicle_id + ","
                                vehicleContent += vehicles[counter].plate_number + ","
                                vehicleContent += vehicles[counter].colour + ","
                                vehicleContent += vehicles[counter].make + ","
                                vehicleContent += vehicles[counter].model + ","
                                vehicleContent += vehicles[counter].capacity + ","
                                vehicleContent += vehicles[counter].owner_id + ","
                                vehicleContent += vehicles[counter].driver_id + "\n"
                            }

                            let driverContent = "Driver ID,First Name,Last Name,Email Address,Phone Number\n";
                            for(let counter = 0, count = drivers.length; counter < count; counter++)
                            {
                                driverContent += drivers[counter].driver_id + ",";
                                driverContent += drivers[counter].first_name + ",";
                                driverContent += drivers[counter].last_name + ",";
                                driverContent += drivers[counter].email_address + ",";
                                driverContent += drivers[counter].phone_number + "\n";
                            }
                            let files = [{
                                name: "Student Information.csv",
                                data: studentContent
                            }, {
                                name: "Vehicle Information.csv",
                                data: vehicleContent
                            }, {
                                name: "Driver Information.csv",
                                data: driverContent
                            }];

                            var data = SimpleZip.GenerateZipFrom(files);
                            var blob = new Blob([data], {type: "octet/stream"});
                            var url = window.URL.createObjectURL(blob);
                            var el = document.createElement("a");
                            el.href = url;
                            el.download = "usu_general_report.zip";
                            el.click();
                        })
                }
            }
        });
        // Report Menu Stop
        var utility = new Vue({
            el:'',
            data(){
                return {
                    alive: true
                }
            },
            methods:{
                isAlive(){
                    return this.alive;
                },
                refreshToken(){
                    axios
                        .post("https://mp-authentication-server.herokuapp.com/refresh",
                            {},
                            {headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_refresh_token")}`}}
                        )
                        .then(function(response){
                            window.localStorage.setItem("usu_access_token", response.data.data.accessToken);
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        });
                }
            },
        })

        var contractsVue = new Vue({
            el: "#contracts-table",
            data(){
                return {
                    contracts: null,
                    contract: null,
                }
            },
            mounted(){
                window.contract = {};
                let _this = this;
                _this.getContracts();
            },
            computed:{
                owners(){return vehicleFormVue.owners;},
                vehicles(){return vehicleVue.vehicles;}
            },
            methods: {
                confirmDelete(id) {
                    let _this = this;
                    this.$buefy.dialog.prompt({
                        title: 'Deleting Contract',
                        message: 'Type <b><i>your account password</i></b> to permanently delete this student? This action cannot be undone!',
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 40,
                            type: 'password',
                            autocomplete:"off"
                        },
                        confirmText: 'Delete Contract',
                        trapFocus: true,
                        type: 'is-danger',
                        hasIcon: true,
                        onConfirm(value){
                            axios({
                                method: 'delete',
                                url: `https://mp-app-server.herokuapp.com/contract/${id}`,
                                headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                                },
                                data: {
                                adminPassword:value
                                }
                            })
                            .then(function(response){
                                _this.getContracts();
                                _this.$buefy.toast.open('Contract deleted!');
                            })
                            .catch(function(error){
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this Contract record',type:"is-danger"});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                updateContract(id){
                    let contract = null;
                    let _this = this;
                    for(let counter = 0, count = this.contracts.length; counter < count; counter++){
                        if(this.contracts[counter].contract_id == id){
                            contract = this.contracts[counter];
                            window.contract = this.contracts[counter];
                            break;
                        }
                    }
                    this.$buefy.dialog.confirm({
                        title: 'Update Contract',
                        message: `
                            <div class="field">
                                <label class="label">Contract Number</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.contract_number = this.value " value="${contract.contract_number}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Processing Number</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.pr_number = this.value " value="${contract.pr_number}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Procurement Officer</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.procurement_officer = this.value " value="${contract.procurement_officer}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Contractor</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.contractor = this.value " value="${contract.contractor}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Issue Date</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.issue_date = this.value " value="${this.yyyymmdd(contract.issue_date)}" type="date" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Expiration Date</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.expiration_date = this.value " value="${this.yyyymmdd(contract.expiration_date)}" type="date" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Due Date</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.due_date = this.value " value="${this.yyyymmdd(contract.due_date)}" type="date" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Route ID</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.route_id = this.value " value="${contract.route_id}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Vehicle</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.vehicle_id = this.value " value="${contract.vehicle_id}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Owner</label>
                                <div class="control">
                                    <input class="input" oninput="window.contract.owner_id = this.value " value="${contract.owner_id}" type="text" placeholder="Text input">
                                </div>
                            </div>
                        `,
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 20,
                            type: 'password',
                            autocomplete:"off"
                        },
                        size: 'is-medium',
                        trapFocus: true,
                        type: 'is-success',
                        confirmText: 'Update Contract',
                        onConfirm(value){

                            axios({
                              method: 'put',
                              url: `https://mp-app-server.herokuapp.com/contract/${id}`,
                              headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                              },
                              data: {
                                contractNumber: window.contract.contract_number,
                                prNumber: window.contract.pr_number,
                                procurementOfficer: window.contract.procurement_officer,
                                contractor: window.contract.contractor,
                                issueDate: window.contract.issue_date,
                                expirationDate: window.contract.expiration_date,
                                dueDate: window.contract.due_date,
                                routeID: window.contract.route_id,
                                vehicleID: window.contract.vehicle_id,
                                ownerID: window.contract.owner_id
                              }
                            })
                            .then(function(response){
                                _this.getContracts();
                                _this.$buefy.toast.open('Contract Updated!');
                            })
                            .catch(function(error){
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this Contract record',type:"is-danger"});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                getContractsPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/contract",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}})
                },
                getContracts(){
                    _this = this;
                    axios
                        .get("https://mp-app-server.herokuapp.com/contract",
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }}
                        )
                        .then(function(response){
                            _this.contracts = response.data.data;
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        })
                },
                yyyymmdd(t){
                    let date = new Date(t);
                    let y = date.getFullYear();
                    let m = date.getMonth() + 1;
                    let d = date.getDate();
                    return '' + y +"-"+ (m < 10 ? '0' : '') + m +"-"+ (d < 10 ? '0' : '') + d;
                }
            },
            computed: {}
        });

        // Route Table Start
        var routeTable = new Vue({
            el: "#routes-table",
            data(){
                return {
                    routes: null,
                }
            },
            mounted(){
                window.route = {};
                let _this = this;
                this.getRoutes();
            },
            computed:{

            },
            methods: {
                confirmDelete(id) {
                    let _this = this;
                    this.$buefy.dialog.prompt({
                        title: 'Deleting Route',
                        message: 'Type <b><i>your account password</i></b> to permanently delete this route? This action cannot be undone!',
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 40,
                            type: 'password',
                            autocomplete:"off"
                        },
                        confirmText: 'Delete Route',
                        trapFocus: true,
                        type: 'is-danger',
                        hasIcon: true,
                        onConfirm(value){
                            this.$buefy.toast.open('Route deleted!');
                            axios({
                                method: 'delete',
                                url: `https://mp-app-server.herokuapp.com/route/${id}`,
                                headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                                },
                                data: {
                                adminPassword:value
                                }
                            })
                            .then(function(response){
                                _this.getRoutes();
                            })
                            .catch(function(error){
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                updateRoute(id){
                    let route = null;
                    let _this = this;
                    for(let counter = 0, count = this.routes.length; counter < count; counter++){
                        if(this.routes[counter].route_id == id){
                            route = this.routes[counter];
                            window.route = this.routes[counter];
                            break;
                        }
                    }
                    this.$buefy.dialog.confirm({
                        title: 'Update Route',
                        message: `
                            <div class="field">
                                <label class="label">Route Description</label>
                                <div class="control">
                                    <input class="input" oninput="window.route.description = this.value " value="${route.description}" type="text" placeholder="Text input">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Route Fee</label>
                                <div class="control">
                                    <input class="input" oninput="window.route.fee = this.value " value="${route.fee}" type="text" placeholder="Text input">
                                </div>
                            </div>
                        `,
                        inputAttrs: {
                            placeholder: 'e.g. your_password',
                            maxlength: 20,
                            type: 'password',
                            autocomplete:"off"
                        },
                        size: 'is-medium',
                        trapFocus: true,
                        type: 'is-success',
                        confirmText: 'Update Route',
                        onConfirm(value){
                            axios({
                              method: 'put',
                              url: `https://mp-app-server.herokuapp.com/route/${id}`,
                              headers:{
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                              },
                              data: {
                                description: window.route.description,
                                fee: window.route.fee,
                              }
                            })
                            .then(function(response){
                                _this.getContracts();
                                _this.$buefy.toast.open('Route Updated!');
                            })
                            .catch(function(error){
                                _this.$buefy.toast.open({message:'Error: Likely problem - Something depends on this Route record',type:"is-danger"});
                                window.utility.refreshToken();
                            })
                        }
                    })
                },
                getRoutesPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/route",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}})
                },
                getRoutes(){
                    let _this = this;
                    axios
                        .get("https://mp-app-server.herokuapp.com/route",
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }}
                        )
                        .then(function(response){
                            _this.routes = response.data.data;
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        })
                }
            },
            computed: {}
        });
        // Route Table Stop
        // Contract Form Start
        var contractForm = new Vue({
            el:"#contract-form",
            data(){
                return {
                }
            },
            mounted(){
                let _this = this;
            },
            computed:{
                owners(){return vehicleFormVue.owners;},
                vehicles(){return vehicleVue.vehicles;},
                routes(){return routeTable.routes;}
            },
            methods:{
                createContract(){
                    let _this = this;
                    let contractNumber = this.$refs.contractNumber.value; console.log(this.$refs.contractNumber.value);
                    let prNumber = this.$refs.prNumber.value; console.log(this.$refs.prNumber.value);
                    let procurementOfficer = this.$refs.procurementOfficer.value; console.log(this.$refs.procurementOfficer.value);
                    let contractor = this.$refs.contractor.value; console.log(this.$refs.contractor.value);
                    let issueDate = this.$refs.issueDate.value; console.log(this.$refs.issueDate.value);
                    let expirationDate = this.$refs.expirationDate.value; console.log(this.$refs.expirationDate.value);
                    let dueDate = this.$refs.dueDate.value; console.log(this.$refs.dueDate.value);
                    let routeID = this.$refs.routeID.value; console.log(this.$refs.routeID.value);
                    let vehicleID = this.$refs.vehicleID.value; console.log(this.$refs.vehicleID.value);
                    let ownerID = this.$refs.ownerID.value; console.log(this.$refs.ownerID.value);

                    axios
                        .post("https://mp-app-server.herokuapp.com/contract",
                            {
                                "contractNumber": contractNumber,
                                "prNumber": prNumber,
                                "procurementOfficer": procurementOfficer,
                                "contractor": contractor,
                                "issueDate": issueDate,
                                "expirationDate": expirationDate,
                                "dueDate": dueDate,
                                "routeID": routeID,
                                "vehicleID": vehicleID,
                                "ownerID": ownerID
                            },
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }},
                        )
                        .then(function(response){
                            _this.$buefy.dialog.alert('Contract Created!')
                            _this.$refs.contractNumber.value = "";
                            _this.$refs.prNumber.value = "";
                            _this.$refs.procurementOfficer.value = "";
                            _this.$refs.contractor.value = "";
                            _this.$refs.issueDate.value = "";
                            _this.$refs.expirationDate.value = "";
                            _this.$refs.dueDate.value = "";
                            _this.$refs.routeID.value = "";
                            _this.$refs.vehicleID.value = "";
                            _this.$refs.ownerID.value = "";
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        });
                }
            }
        })
        // Contract Form Stop

        // Route Form Start
        var routeForm = new Vue({
            el:"#route-form",
            data(){
                return {
                }
            },
            mounted(){
                let _this = this;
            },
            computed:{

            },
            methods:{
                createRoute(){
                    let _this = this;
                    let startingLocation = this.$refs.startingLocation.value; console.log(this.$refs.startingLocation.value);
                    let destination = this.$refs.destination.value; console.log(this.$refs.destination.value);
                    let fee = this.$refs.fee.value; console.log(this.$refs.fee.value);

                    axios
                        .post("https://mp-app-server.herokuapp.com/route",
                            {
                                "description": `${startingLocation} to ${destination}`,
                                "fee": fee
                            },
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }},
                        )
                        .then(function(response){
                            _this.$buefy.dialog.alert('Route Created!');
                            _this.$refs.startingLocation.value = "";
                            _this.$refs.destination.value = "";
                            _this.$refs.fee.value = "";
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        });
                }
            }
        })
        // Route Form Stop

        // Route Table Start
        var paymentTable = new Vue({
            el: "#payments-table",
            data(){
                return {
                    payments: null,
                }
            },
            mounted(){
                window.payment = {};
                let _this = this;
                this.getPayments();
            },
            computed:{

            },
            methods: {
                getPaymentDepositsPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/payment_deposits",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}})
                },
                getPaymentChargesPromise(){
                    return axios.get("https://mp-app-server.herokuapp.com/payment_charges",{headers: {"Content-type":"application/json","Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`}})
                },
                getPayments(){
                    let _this = this;
                    Promise.all([this.getPaymentChargesPromise(), this.getPaymentDepositsPromise()])
                        .then(function(response){
                            _this.payments = response[0].data.data.concat(response[1].data.data);
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        })
                }
            },
            computed: {}
        });

        // Payment Form Start
        var paymentForm = new Vue({
            el:"#payment-form",
            data(){
                return {
                }
            },
            mounted(){
                let _this = this;
            },
            computed:{
                contracts(){return contractsVue.contracts;},
                username(){return window.localStorage.getItem('usu_username');}
            },
            methods:{
                createPayment(){
                    let _this = this;
                    let doneBy = this.$refs.done_by.value; console.log(this.$refs.done_by.value);
                    let amount = this.$refs.amount.value; console.log(this.$refs.amount.value);
                    let paymentType = this.$refs.payment_type.value; console.log(this.$refs.payment_type.value);
                    let description = this.$refs.description.value; console.log(this.$refs.description.value);
                    let contractID = this.$refs.contractID.value; console.log(this.$refs.contractID.value);

                    axios
                        .post("https://mp-app-server.herokuapp.com/payment",
                            {
                                "paymentType": paymentType,
                                "doneBy": doneBy,
                                "description": description,
                                "amount": amount,
                                "contractID": contractID
                            },
                            {headers: {
                                "Content-type":"application/json",
                                "Authorization": `Bearer ${window.localStorage.getItem("usu_access_token")}`
                            }},
                        )
                        .then(function(response){
                            _this.$buefy.dialog.alert('Transaction Created!');
                            _this.$refs.done_by.value = "";
                            _this.$refs.amount.value = "";
                            _this.$refs.payment_type.value = "";
                            _this.$refs.description.value = "";
                            _this.$refs.contractID.value = "";
                        })
                        .catch(function(error){
                            window.utility.refreshToken();
                        });
                }
            }
        })
        // Payment Form Stop

        var dashboard = new Vue({
            el:"#main",
            data:{
                studentCount: null,
                driverCount: null,
                routeCount: null,
                vehicleCount: null
            },
            methods:{
                getStudentCount(){this.studentCount = window.studentsVue.students.length;},
                getDriverCount(){this.driverCount = window.vehicleFormVue.drivers.length;},
                getRouteCount(){this.routeCount = window.routeTable.routes.length;},
                getVehicleCount(){this.vehicleCount = window.vehicleVue.vehicles.length;}
            },
            mounted(){

            },
            computed:{}
        })

        setInterval(function(){dashboard.getVehicleCount();console.log("Get Vehicles Interval");},9000);
        setInterval(function(){dashboard.getStudentCount();console.log("Get Students Interval");},9000);
        setInterval(function(){dashboard.getDriverCount();console.log("Get Drivers Interval");},9000);
        setInterval(function(){dashboard.getRouteCount();console.log("Get Routes Interval");},9000);
        setInterval(function(){vehicleVue.getVehicles();console.log("Get Vehicles Interval");},9000);
        setInterval(function(){studentsVue.getStudents();console.log("Get Students Interval");},9000);
        setInterval(function(){driversVue.getDrivers();console.log("Get Drivers Interval");},9000);
        setInterval(function(){ownersVue.getOwners();console.log("Get Owners Interval");},9000);
        setInterval(function(){vehicleFormVue.getDrivers();console.log("Get Drivers Interval")}, 9000);
        setInterval(function(){vehicleFormVue.getOwners();console.log("Get Owners Interval")}, 9000);
        setInterval(function(){contractsVue.getContracts();console.log("Get Contracts Interval");},9000);
        setInterval(function(){routeTable.getRoutes();console.log("Get Routes Interval");},9000);
        setInterval(function(){paymentTable.getPayments();console.log("Get Payments Interval");},9000);
        contractsVue.getContracts();
        vehicleVue.getVehicles();
        vehicleFormVue.getOwners();
        vehicleFormVue.getDrivers();
        studentsVue.getStudents();
        routeTable.getRoutes();
        paymentTable.getPayments();
        ownersVue.getOwners();
        driversVue.getDrivers();
    </script>
    <style type="text/css">
        html,body: {
            height: 100%;
        }
    </style>


@endsection
