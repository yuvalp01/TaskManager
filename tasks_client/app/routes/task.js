import Route from '@ember/routing/route';
import { inject as service } from '@ember/service';
import { tracked } from '@glimmer/tracking';
import { action } from '@ember/object';

export default class TaskRoute extends Route {
    @service dataService
    @service session

    model() {
        return this.dataService.getData('tasks/'+this.session.currentUser.data.user.id);
    }


    @action
    refreshModel() {
        this.refresh();
     }
}





















    // async model() {
    //     let [tasks, summary] = await Promise.all([
    //       this.dataService.getData('tasks/'+this.session.currentUser.data.user.id),
    //       this.dataService.getData('tasks/summary/'+this.session.currentUser.data.user.id)

    //     ]);
    
    
    //     return { tasks, summary };
    // }