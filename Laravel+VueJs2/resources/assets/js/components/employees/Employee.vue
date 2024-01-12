<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div>
                    <span style="font-size: 18px">Сотрудники</span>
                    <button class="btn btn-outline-primary btn-sm pull-right" v-show="!show_form1" @click="toggleForm1">
                        <i class="fa fa-plus"></i> Добавить
                    </button>
                    <hr>
                    <!-- create employee - (form) -->
                    <form v-if="show_form1" role="form" @submit.prevent="createEmployee">
                        <div class="form-group">
                            <input type="text" name="name" v-model="name" class="form-control" placeholder = "ФИО" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm">
                                Добавить
                            </button>
                            <a class="btn btn-secondary btn-sm" role="button" @click="toggleForm1" style="color:white">
                                Отмена
                            </a>
                        </div>
                    </form>
                </div>
                <!--card -->
                <div class="card">
                    <div class="card-body">
                        <!-- displaying all created employees in a table-->
                        <table class="table table-hover">
                            <tbody v-if="employees">
                            <tr>
                                <th>ФИО</th>
                                <th></th>
                            </tr>
                            <tr v-for="emp in employees"
                                :class="employee_id == emp.id ? 'active1': ''"
                                @click="loadKeyInfo(emp.id);
                                      employee_id = emp.id;">

                                <!--employee name -->
                                <td>{{ emp.name }}</td>

                                <!--employee actions(delete and update) -->
                                <td>
                                    <!--delete employee form-->
                                    <form role="form" @submit.prevent="deleteEmployee(emp.id)">
                                        <button class="btn btn-danger pull-right">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </form>
                                    <!-- update url -->
                                    <a class="btn btn-warning pull-right" :href="editEmployee(emp.id)">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                            <tr>
                                <td colspan="2">
                                    <div class="text-center">
                                        <br>
                                        <i class="fa fa-warning fa-5x"></i>
                                        <br><b>Ничего не найдено!</b>
                                        <br>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!--end card-->
                </div>
            </div>

            <!--by default - it says choose from the employee list-->
            <div class="col-md-6">
                <div v-if="pushed === 0">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <br><br><br>
                                <i class="fa fa-warning fa-4x"></i>
                                <br><b>Выберите из списка!</b>
                                <br><br><br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--pressing tr column - displaying all keys of employee by emloyee_id -->
                <div v-else>
                    <div class="loader text-center" v-if="loading_info"></div>
                    <div class="card" v-if="employee">
                        <div class="card-header">
                            Ключи сотрудника - <b>{{ employee.name }}</b>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody v-if="employee.keys.length">
                                <tr>
                                    <th>#ID</th>
                                    <th>Замок</th>
                                    <th></th>
                                </tr>
                                <tr v-for="key in employee.keys" >
                                    <!--key id -->
                                    <td>
                                        <span class="badge badge-pill badge-info" style="font-size: 14px">
                                            <i class="fa fa-key"></i> {{ key.id }}
                                        </span>
                                    </td>

                                    <!--key lock title -->
                                    <td>{{ key.lock.title }}</td>

                                    <!--delete employee_key action -->
                                    <td>
                                        <form role="form" @submit.prevent="deleteKeyFromEmployee(employee_id, key.id)">
                                            <button class="btn btn-danger pull-right">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr>
                                    <td colspan="2">
                                        <div class="text-center">
                                            <br><br>
                                            <i class="fa fa-warning fa-4x"></i>
                                            <br><b>Empty!</b>
                                            <br><br>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <!-- key form - creating keys to employee -->
                            <div v-if="keys.length">
                                <button class="btn btn-outline-primary btn-sm" v-show="!show_form" @click="toggleForm">
                                    <i class="fa fa-plus"></i>
                                    Добавить
                                </button>

                                <!-- create key to employee action -->
                                <form v-if="show_form" role="form" @submit.prevent="createKeyToEmployee">
                                    <div class="form-group">
                                        <label for="key_id">Выберите ключ:</label>
                                        <!-- dropdown selection of the keys -->
                                        <select class="form-control" v-model="key" id="key_id">
                                            <option v-for="ky in keys" :value.sync="ky.id" v-if="!ky.employees.length">
                                                {{ ky.id }} - {{ ky.lock.title }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-sm">
                                            Добавить
                                        </button>
                                        <a class="btn btn-secondary btn-sm" role="button" @click="toggleForm" style="color:white">
                                            Отмена
                                        </a>
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
    import swal from 'sweetalert';
    export default {
        data() {
            return {
                loading: false,
                loading_info: false,
                show_form: false,
                show_form1: false,
                pushed: 0,

                employees: [],
                employee_id: null,
                employee: null,
                name: '',

                keys: [],
                key_id: null,
                key: null,
            }
        },

        methods: {
            //toggle add btn for keys to employee
            toggleForm() {
                this.show_form = !this.show_form;
            },

            //toggle add btn for employees
            toggleForm1() {
                this.show_form1 = !this.show_form1;
            },

            //=load page - displaying all employees
            load() {
                let self = this;
                let url = route('employees');
                self.loading = true;
                axiosRetry(axios, { retries: 5 });
                axios.get(url)
                    .then(function (response) {
                        self.employees = response.data.employees.data;//objects;
                        self.loading = false;
                    })
                    .catch(function (error) {
                        self.error = true;
                        console.log(error);
                        self.loading = false;
                    });

            },

            //load key info by employee_id
            loadKeyInfo(employee_id) {
                let self = this;
                self.employee_id = employee_id;
                self.pushed = 1;
                let url = route('employee.show', {employee: employee_id});
                self.loading_info = true;
                axiosRetry(axios, { retries: 5 });
                axios.get(url)
                    .then(function (response) {
                        self.employee = response.data.employee;
                        self.keys = response.data.keys;
                        self.loading_info = false;
                    })
                    .catch(function (error) {
                        self.error = true;
                        console.log(error);
                        self.loading_info = false;
                    });
            },

            //edit employee - url route
            editEmployee(emp_id) {
                let url = route('employee.edit', {employee: emp_id});
                return url;
            },

            //create employee
            createEmployee() {
                let self = this;
                self.loading = true;
                let url = route('employee.store');
                let name_req = {
                    'name': self.name
                };
                axiosRetry(axios, {retries: 5});
                axios.post(url, name_req)
                    .then(function (response) {
                        console.log(response.data);
                        swal("Успешно", "Сотрудник создан", "success");
                        self.load();
                        self.show_form1 = false;
                        self.loading = false;
                    })
                    .catch(function (error) {
                        self.error = true;
                        console.log(error);
                        swal("Ошибка", "Уппс, Ошибка", "warning");
                        self.loading = false;
                    });
            },

           // delete employee - by employee_id
            deleteEmployee(emp_id) {
                let self = this;
                let url = route('employee.destroy', {employee: emp_id});
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this employee!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            axios.delete(url)
                                .then(function (response) {
                                    console.log(response.data);
                                    swal("Успешно", "Сотрудник удален", "success");
                                    self.load();
                                    self.loading = false;
                                })
                                .catch(function (error) {
                                    self.error = true;
                                    console.log(error);
                                    swal("Ошибка", "Упс, Ошибка", "warning");
                                    self.loading = false;
                                });
                        } else {
                        }
                    });
            },


            //create key to employee - by (employee_id and key_id)
            createKeyToEmployee() {
                let self = this;
                self.loading_info = true;
                let url = route('employee_key.store');
                axios.post(url, {employee_id: self.employee_id, key_id: self.key})
                    .then(function (response) {
                        console.log(response.data);
                        swal("Успешно", "Ключ для сотрудника создан", "success");
                        self.loadKeyInfo(self.employee_id);
                        self.show_form = false;
                        self.loading_info = false;
                    })
                    .catch(function (error) {
                        self.error = true;
                        console.log(error);
                        swal("Ошибка", "Упс, Ошибка", "warning");
                        self.loading_info = false;
                    });
            },

            //delete key from employee - by employee_id and key_id
            deleteKeyFromEmployee(employee_id, key_id) {
                let self = this;
                let url = route('employee_key.destroy', {
                    employee_id: employee_id,
                    key_id: key_id
                });
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this key from employee!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            self.loading_info = true;
                            axios.delete(url)
                                .then(function (response) {
                                    console.log(response.data);
                                    swal("Успешно", "Ключ для сотрудника удален", "success");
                                    self.loadKeyInfo(employee_id);
                                    self.loading_info = false;
                                })
                                .catch(function (error) {
                                    self.error = true;
                                    console.log(error);
                                    swal("Ошибка", "Упс, Ошибка", "warning");
                                    self.loading_info = false;
                                });
                        } else {
                            swal("Canceled", "Canceled", "warning");
                        }
                    });
            }
        },

        watch: {
            key() {
                if (this.key.id > 0)
                    this.key_id = this.key.id;
            }
        },

        mounted() {
            this.load();
        }
    }
</script>