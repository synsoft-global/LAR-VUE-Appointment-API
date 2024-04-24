<script setup>
import axios from 'axios';
import { reactive, onMounted, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useToastr } from '@/toastr';
import { Form } from 'vee-validate';
import flatpickr from "flatpickr";
import 'flatpickr/dist/themes/light.css';

const router = useRouter();
const route = useRoute();
const toastr = useToastr();

const form = reactive({
    title: '',
    description: '',
});

const handleSubmit = (values, actions) => {
    if (editMode.value) {
        editCategory(values, actions);
    } else {
        createCategory(values, actions);
    }
};

const createCategory = (values, actions) => {
    axios.post('/api/category/create', form)
    .then((response) => {
        router.push('/admin/categories');
        toastr.success('Category created successfully!');
    })
    .catch((error) => {
        actions.setErrors(error.response.data.errors);
    })
};

const editCategory = (values, actions) => {
    axios.put(`/api/category/${route.params.id}/edit`, form)
    .then((response) => {
        router.push('/admin/categories');
        toastr.success('Category updated successfully!');
    })
    .catch((error) => {
        actions.setErrors(error.response.data.errors);
    })
};

const getCategory = () => {
    axios.get(`/api/category/${route.params.id}/edit`)
    .then(({data}) => {
        form.title = data.title;
        form.description = data.description;
    })
};

const editMode = ref(false);

onMounted(() => {
    if (route.name === 'admin.categories.edit') {
        editMode.value = true;
        getCategory();
    }
});
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <span v-if="editMode">Edit</span>
                        <span v-else>Create</span>
                        Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link to="/admin/categories">Categories</router-link>
                        </li>
                        <li class="breadcrumb-item active">
                            <span v-if="editMode">Edit</span>
                            <span v-else>Create</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <Form @submit="handleSubmit" v-slot:default="{ errors }">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input v-model="form.title" type="text" class="form-control" :class="{ 'is-invalid': errors.title }" id="title" placeholder="Enter Title">
                                            <span class="invalid-feedback">{{ errors.title }}</span>
                                        </div>
                                    </div>
                                    
                                </div>                              
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea v-model="form.description" class="form-control" :class="{'is-invalid': errors.description}" id="description" rows="3"
                                        placeholder="Enter Description"></textarea>
                                    <span class="invalid-feedback">{{ errors.description }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </Form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
