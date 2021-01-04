import Controller from '@ember/controller';
import { action } from '@ember/object';
import { inject as service } from '@ember/service';
import { later } from '@ember/runloop';
import { tracked } from '@glimmer/tracking';

export default class IndexController extends Controller {
    @service router
    @service session

    @tracked msg

    @action
    async authenticate(e) {
        e.preventDefault();

        let { email, password } = this;
        try {
          this.session.authenticate('authenticator:oauth2', {email, password})
        } catch(error) {
            this.msg  = error.error || error;
        }
        if (this.session.isAuthenticated) {
            later(() => { this.router.transitionTo('task') }, 2000);
        }
    }






    @action
    emailUp(e) {
        this.email = e.target.value;
    }

    @action
    passwordUp(e) {
        this.password = e.target.value;
    }



}
