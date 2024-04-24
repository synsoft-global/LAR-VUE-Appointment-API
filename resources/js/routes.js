import Dashboard from './components/Dashboard.vue';
import ListAppointments from './pages/appointments/ListAppointments.vue';
import AppointmentForm from './pages/appointments/AppointmentForm.vue';
import ListCategory from './pages/category/ListCategory.vue';
import ListSubCategory from './pages/category/ListSubCategory.vue';
import CategoryForm from './pages/category/CategoryForm.vue';
import SubCategoryForm from './pages/category/SubCategoryForm.vue';
import UserList from './pages/users/UserList.vue';
import UpdateSetting from './pages/settings/UpdateSetting.vue';
import UpdateProfile from './pages/profile/UpdateProfile.vue';
import Login from './pages/auth/Login.vue';

export default [
    {
        path: '/login',
        name: 'admin.login',
        component: Login,
    },

    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: Dashboard,
    },

    {
        path: '/admin/appointments',
        name: 'admin.appointments',
        component: ListAppointments,
    },

    {
        path: '/admin/categories',
        name: 'admin.categories',
        component: ListCategory,
    },

    {
        path: '/admin/categories/create',
        name: 'admin.categories.create',
        component: CategoryForm,
    },

    {
        path: '/admin/categories/:id/edit',
        name: 'admin.categories.edit',
        component: CategoryForm,
    },

    {
        path: '/admin/subcategories',
        name: 'admin.subcategories',
        component: ListSubCategory,
    },
    {
        path: '/admin/subcategories/create',
        name: 'admin.subcategories.create',
        component: SubCategoryForm,
    },
    {
        path: '/admin/subcategories/:id/edit',
        name: 'admin.subcategories.edit',
        component: SubCategoryForm,
    },
    {
        path: '/admin/appointments/create',
        name: 'admin.appointments.create',
        component: AppointmentForm,
    },

    {
        path: '/admin/appointments/:id/edit',
        name: 'admin.appointments.edit',
        component: AppointmentForm,
    },

    {
        path: '/admin/users',
        name: 'admin.users',
        component: UserList,
    },

    {
        path: '/admin/settings',
        name: 'admin.settings',
        component: UpdateSetting,
    },

    {
        path: '/admin/profile',
        name: 'admin.profile',
        component: UpdateProfile,
    }
]
