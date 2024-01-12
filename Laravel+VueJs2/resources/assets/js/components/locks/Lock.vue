<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <diV>
                    <span style="font-size: 18px">Замки</span>
                    <button class="btn btn-outline-primary btn-sm pull-right" v-show="!show_form" @click="toggleForm">
                        <i class="fa fa-plus"></i>
                        Добавить
                    </button>
                    <hr>
                    <!-- create lock - (form) -->
                    <form v-if="show_form" role="form" @submit.prevent="createLock">
                        <div class="form-group">
                            <input type="text" name="title" v-model="title" class="form-control" placeholder = "Название" required>
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
                </diV>
                <!-- card -->
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody v-if="locks">
                            <tr>
                                <th>Название</th>
                                <th></th>
                            </tr>
                            <tr v-for="lock in locks"
                                :class="lock_id == lock.id ? 'active1': ''"
                                @click="loadKeyInfo(lock.id);
                                lock_id = lock.id;
                                lock_title = lock.title">

                                <!--lock title -->
                                <td>{{ lock.title }}</td>

                                <!--lock actions(update and delete) -->
                                <td>
                                    <!--delete lock - (form) -->
                                    <form role="form" @submit.prevent="deleteLock(lock.id)">
                                        <button class="btn btn-danger pull-right">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </form>

                                    <!-- update lock - (url-route) -->
                                    <a class="btn btn-warning pull-right" :href="editLockUrl(lock.id)">
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
                                        <i class="fa fa-warning fa-3x"></i>
                                        <br><b>Ничего не найдено!</b>
                                        <br>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!--end card -->
            </div>

            <div class="col-md-6">
                <!--by default -->
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
                <!--in case of pressing the tr column -->
                <div v-else>
                    <div class="loader text-center" v-if="loading_info"></div>
                        <div class="card">
                            <div class="card-header">
                                <!--store key form -->
                                <form role="form" @submit.prevent="createKeyToLock">
                                    <span>Список ключей - {{ lock_title }}</span>
                                    <button class="btn btn-primary pull-right">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody v-if="keys.length">
                                    <tr>
                                        <th>#ID ключа</th>
                                        <th></th>
                                    </tr>
                                    <tr v-for="key in keys">
                                        <!--key id -->
                                        <td>
                                            <span class="badge badge-pill badge-info" style="font-size: 14px">
                                                <i class="fa fa-key"></i>
                                                {{ key.id }}
                                                </span>
                                        </td>
                                        <!--key action (delete) -->
                                        <td>
                                            <!--delete key form-->
                                            <form role="form" @submit.prevent="deleteKeyFromLock(key.id)">
                                                <button class="btn btn-danger pull-right">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </form>
                                        </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <div class="text-center">
                                                <br>
                                                <i class="fa fa-warning fa-3x"></i>
                                                <br><b>Empty!</b>
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
                pushed: 0,

                locks: [],
                keys: [],
                title: '',
                lock_id: null,
                lock_title: null,
            }
        },
        methods: {

            //toggle add btn for locks
            toggleForm() {
                this.show_form = !this.show_form;
            },

            //=load page - displaying all locks
            load() {
                let self = this;
                let url = route('locks');
                self.loading = true;
                axiosRetry(axios, { retries: 5 });
                axios.get(url)
                    .then(function (response) {
                        self.locks = response.data.locks.data;//objects;
                        self.loading = false;
                    })
                    .catch(function (error) {
                        self.error = true;
                        console.log(error);
                        self.loading = false;
                    });
            },

            //load key info -  by lock_id
            loadKeyInfo(lock_id) {
                let self = this;
                self.pushed = 1;
                self.lock_id = lock_id;
                let url = route('key.index', {lock_id: lock_id});
                self.loading_info = true;
                axiosRetry(axios, { retries: 5 });
                axios.get(url)
                    .then(function (response) {
                        self.keys = response.data.keys.data;
                        self.loading_info = false;
                    })
                    .catch(function (error) {
                        self.error = true;
                        console.log(error);
                        self.loading_info = false;
                    });
            },

            //edit lock url route
            editLockUrl(lock_id) {
                let url = route('lock.edit', {lock: lock_id});
                return url;
            },

            //create lock
            createLock() {
                let self = this;
                self.loading = true;
                let url = route('lock.store');
                let title_value = {
                    'title': self.title
                };
                axiosRetry(axios, {retries: 5});
                axios.post(url, title_value)
                    .then(function (response) {
                        console.log(response.data);
                        swal("Успешно", "Замок создан", "success");
                        self.load();
                        self.show_form = false;
                        self.loading = false;
                    })
                    .catch(function (error) {
                        self.error = true;
                        console.log(error);
                        swal("Ошибка", "Уппс, Ошибка", "warning");
                        self.loading = false;
                    });
            },

            //delete lock - by lock_id
            deleteLock(lock_id) {
                let self = this;
                let url = route('lock.destroy', {lock: lock_id});
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this lock!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            self.loading = true;
                            axios.delete(url)
                                .then(function (response) {
                                    console.log(response.data);
                                    swal("Успешно", "Замок удален", "success");
                                    self.loadKeyInfo(lock_id);
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


            //=create key for lock
            createKeyToLock(){
                let self = this;
                self.loading = true;
                let url = route('key.store');
                axios.post(url, {lock_id: self.lock_id})
                    .then(function (response) {
                        console.log(response.data);
                        swal("Успешно", "Ключ создан", "success");
                        self.loadKeyInfo(self.lock_id);
                        self.loading = false;
                    })
                    .catch(function (error) {
                        self.error = true;
                        console.log(error);
                        swal("Ошибка", "Упс, Ошибка", "warning");
                        self.loading = false;
                    });
            },

            //=delete key for lock - by key_id
            deleteKeyFromLock(key_id) {
                let self = this;
                let url = route('key.destroy', {key_id: key_id});
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this key from employee!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            self.loading = true;
                            axios.delete(url)
                                .then(function (response) {
                                    console.log(response.data);
                                    swal("Успешно", "Ключ удален", "success");
                                    self.loadKeyInfo(self.lock_id);
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

            update: _.debounce(function (e) {
                this.load();
            }, 300),
        },

        mounted() {
            this.load();
        }
    }
</script>