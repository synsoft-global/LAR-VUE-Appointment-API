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
        editSubCategory(values, actions);
    } else {
        createSubCategory(values, actions);
    }
};

const createSubCategory = (values, actions) => {
    axios.post('/api/subcategory/create', form)
    .then((response) => {
        router.push('/admin/subcategories');
        toastr.success('Sub Category created successfully!');
    })
    .catch((error) => {
        actions.setErrors(error.response.data.errors);
    })
};

const editSubCategory = (values, actions) => {
    axios.put(`/api/subcategory/${route.params.id}/edit`, form)
    .then((response) => {
        router.push('/admin/subcategories');
        toastr.success('Sub Category updated successfully!');
    })
    .catch((error) => {
        actions.setErrors(error.response.data.errors);
    })
};

const categories = ref();
const getCategories = () => {
    axios.get(`/api/category`).then((response) => {
        categories.value = response.data.data;
    })
}

const getSubCategory = () => {
    axios.get(`/api/subcategory/${route.params.id}/edit`)
    .then(({data}) => {
        form.title = data.title;
        form.category_id = data.category_id;
        form.description = data.description;
    })
};

const editMode = ref(false);
onMounted(() => {
    if (route.name === 'admin.subcategories.edit') {
        editMode.value = true;
        getSubCategory();        
    }
    getCategories();
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
                        Sub Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link to="/admin/subcategories">Categories</router-link>
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categories">Parent Category</label>
                                            <select v-model="form.category_id" id="category_id" class="form-control" :class="{ 'is-invalid': errors.category_id }">
                                                <option  :value="category.id" :key="category.id" v-for="category in categories">{{ category.title }}</option>
                                            </select>
                                            <span class="invalid-feedback">{{ errors.category_id }}</span>
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
