import Controller from '@ember/controller';
import { tracked } from '@glimmer/tracking';
import { inject as service } from '@ember/service';
import { action } from '@ember/object';

export default class TaskController extends Controller {
    @service dataService
    @service router
    @service session

    @tracked actionStatus = false
    @tracked statusColor = 'text-secondary'

    @tracked sharedData
    @tracked taskEditMode = false;
    @tracked currentTaskId = 0;
    @tracked title = "";
    @tracked currentTask;

    @action
    openForm(isEditMode, task, title) {
        if (isEditMode) {
            this.taskEditMode = true;
            this.currentTask = task;
            this.title = task.title;
        }
        else {
            this.taskEditMode = false;
            this.title = "";
        }
        $('#addBox').modal('show');
    }


    @action
    updateTitle() {
        let data = {
            id: this.currentTask.id,
            title: this.title,
        }
        this.updateTask(this.currentTask.id, data);
        $('#addBox').modal('hide')
    }

    @action
    toggleCompletion(task_id, _is_done) {
        $('#actionStatus').modal({ show: true, backdrop: 'static' })
        _is_done = _is_done == 1 ? 0 : 1;
        let data = { is_done: _is_done }
        this.updateTask(task_id, data);
    }

    @action
    updateTask(task_id, data) {
        $('#actionStatus').modal({ show: true, backdrop: 'static' })
        return this.dataService.updateData('tasks/' + task_id, data)
            .then(async (r) => {
                this.model = await new Promise((resolve, reject) => {
                    return resolve(
                        this.dataService.getData('tasks/' + this.session.currentUser.data.user.id)
                    )
                })
                $('#actionStatus').modal('hide');
            })
    }


    @action
    refresh(e) {
        return this.dataService.getData('tasks/' + this.session.currentUser.data.user.id)
            .then(async (r) => {
                this.model = await new Promise((resolve, reject) => {
                    return resolve(
                        this.dataService.getData('tasks/' + this.session.currentUser.data.user.id)
                    )
                })
                $('#shareBox').modal('hide')
            })

    }


    @action
    careteTask() {
        let data = {
            user_id: this.session.currentUser.data.user.id,
            is_done: '0', is_shared: '0', title: this.title
        }
        $('#addBox').modal('hide')
        $('#actionStatus').modal({ show: true, backdrop: 'static' })
        return this.dataService.postData('tasks', data)
            .then(async (r) => {
                this.model = await new Promise((resolve, reject) => {
                    return resolve(
                        this.dataService.getData('tasks/' + this.session.currentUser.data.user.id)
                    )
                })
                $('#actionStatus').modal('hide')
            })
    }
    @action
    async showShare(task_id) {
        this.currentTaskId = task_id;
        this.dataService.getData('users?user_id=' + this.session.currentUser.data.user.id + '&task_id=' + task_id)
            .then(async (r) => {
                $('#shareBox').modal('show');
                this.sharedData = await new Promise((resolve, reject) => {
                    return resolve(r)
                })
            })
    }

    @action
    delete(id) {

        $('#addBox').modal('hide')
        $('#actionStatus').modal({ show: true, backdrop: 'static' })
        return this.dataService.deleteData('tasks/', id)
            .then(async (r) => {
                this.model = await new Promise((resolve, reject) => {
                    return resolve(
                        this.dataService.getData('tasks/' + this.session.currentUser.data.user.id)
                    )
                })
                $('#actionStatus').modal('hide')
            })

    }

    @action
    restoreAll() {
        $('#addBox').modal('hide')
        $('#actionStatus').modal({ show: true, backdrop: 'static' })
        return this.dataService.updateData('restore')
            .then(async (r) => {
                this.model = await new Promise((resolve, reject) => {
                    return resolve(
                        this.dataService.getData('tasks/' + this.session.currentUser.data.user.id)
                    )
                })
                $('#actionStatus').modal('hide')
            })
    }

    @action
    hardDelete() {
        $('#addBox').modal('hide')
        $('#actionStatus').modal({ show: true, backdrop: 'static' })
        return this.dataService.deleteData('hardDelete', '')
            .then(async (r) => {
                this.model = await new Promise((resolve, reject) => {
                    return resolve(
                        this.dataService.getData('tasks/' + this.session.currentUser.data.user.id)
                    )
                })
                $('#actionStatus').modal('hide')
            })
    }


    @action
    shareToggle(user) {

        if (user.is_shared) {
            let queryString = `sharedTasks?user_id=${user.id}&task_id=${this.currentTaskId}`;
            this.dataService.deleteData(queryString);
        }
        else {
            let dataForPOST = {
                user_id: user.id,
                task_id: this.currentTaskId
            }
            this.dataService.postData('sharedTasks', dataForPOST);

        }
    }


    @action
    logout(user_id) {
        this.dataService.getData('logout')
            .then(async (r) => {
                this.router.transitionTo('index');
            })
    }


}
