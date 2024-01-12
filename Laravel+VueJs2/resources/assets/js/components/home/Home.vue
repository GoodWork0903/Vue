<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cписок сотрудников c ключами</div>
                    <div class="card-body">
                        <table class="table">
                            <tbody v-if="employees.length">
                            <tr>
                                <th>ФИО</th>
                                <th>Ключ замка</th>
                            </tr>
                            <tr v-for="employee in employees">

                                <!--employee name -->
                                <td>{{ employee.name }}</td>

                                <!--key_id and  lock title -->
                                <td>
                                    <div v-if="employee.keys.length">
                                        <div v-for="key in employee.keys">
                                            <span class="badge badge-info">
                                                <i class="fa fa-lock"></i> {{ key.lock.title }}
                                            </span>
                                            <br>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-warning">
                                            Нет ключа
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                            <tr>
                                <td colspan="3">
                                    <div class="text-center">
                                        <br>
                                        <i class="fa fa-warning fa-3x"></i>
                                        <br><b>Ничего не найдено!</b>
                                        <br>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                employees: [],
            }
        },
        methods: {
            //=load page
            load() {
                let self = this;
                let url = route('main');
                self.loading = true;
                axiosRetry(axios, { retries: 5 });
                axios.get(url)
                    .then(function (response) {
                        self.employees = response.data.employees;
                        self.loading = false;
                    })
                    .catch(function (error) {
                        self.error = true;
                        console.log(error);
                        self.loading = false;
                    });
            },
        },
        mounted() {
            this.load();
        }
    }
</script>