
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
import Sortable from 'sortablejs';

require('./bootstrap');

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.config.silent = true;
Vue.component('projects', require('./components/projects.vue'));
Vue.component('adduser', require('./components/AddUserForm.vue'));
Vue.component('modal', require('./components/modal.vue'));
Vue.component('backlog', require('./components/backlog.vue'));
Vue.component('createus', require('./components/createUs.vue'));
Vue.component('createsprint', require('./components/createSprint.vue'));
Vue.component('createtask', require('./components/createtask.vue'));
Vue.component('showus', require('./components/showUs.vue'));
Vue.component('editus',require('./components/editus.vue'));
Vue.component('editsprint',require('./components/editSprint.vue'));
Vue.component('kanban',require('./components/kanban.vue'));
Vue.component('sortablecoluns',require('./components/sortablecoluns.vue'));

// Vue.component('members', require('./components/Members.vue'));

const app = new Vue({
    el: '#memb',
    data:{
        members: []
    }

});
const board = new Vue({
    el: '#boardWrapper'

});
const backlog = new Vue({
    el: '#backlog'
});

const userstory = new Vue({
    el: '#userstory'
});
const projects = new Vue({
    el: '#projects'
});

const createtask = new Vue({
    el: '#createtask'
});
