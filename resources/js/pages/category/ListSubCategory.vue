<script setup>
import { onMounted, ref, computed } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const subcategories = ref([]);

const getsubcategories = () => {
    const params = {};
    axios.get('/api/subcategory', {
        params: params,
    })
        .then((response) => {
            subcategories.value = response.data;
        })
};

const deleteSubCategory = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/api/subcategory/${id}`)
                .then((response) => {
                    subcategories.value.data = subcategories.value.data.filter(subcategory => subcategory.id !== id);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                });
        }
    })
};

onMounted(() => {
    getsubcategories();
});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sub Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Sub Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <router-link to="/admin/subcategories/create">
                                <button class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i> Add New
                                    Sub Category</button>
                            </router-link>
                        </div>                       
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Parent Category</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(subcategory, index) in subcategories.data" :key="subcategory.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ subcategory.category.title }}</td>
                                        <td>{{ subcategory.title }}</td>
                                        <td>{{ subcategory.slug }}</td>
                                        <td>{{ subcategory.description }}</td>
                                        <td>
                                            <router-link :to="`/admin/subcategories/${subcategory.id}/edit`">
                                                <i class="fa fa-edit mr-2"></i>
                                            </router-link>

                                            <a href="#" @click.prevent="deleteSubCategory(subcategory.id)">
                                                <i class="fa fa-trash text-danger"></i>
                                            </a>
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
