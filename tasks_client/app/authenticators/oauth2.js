
import Base from 'ember-simple-auth/authenticators/base';
import { inject as service } from '@ember/service';
import { run } from '@ember/runloop';

export default class OAuth2Authenticator extends Base {
    @service session
    @service dataService
    
    authenticate(data) {
        return new Promise((resolve, reject) => {
            return this.dataService.postData('login',data)
            .then((response)=>{
                let userid = response.data?response.data.user.id:0
                if(userid){
                    this.session.currentUser = response
                    let sres = JSON.stringify({authenticated: {authenticator: "authenticator:oauth2", response}})
                    window.localStorage.setItem('simple_auth-session',sres);
                    run(() => { resolve(response) })
 
                }else{
                    run(() => { reject(response) })
                }
            })
        });
    }
    restore(data) {
        return new Promise((resolve, reject) => {
            let locsec = JSON.parse(window.localStorage.getItem('simple_auth-session'));

            if(locsec.authenticated.response.data){
                console.log('auth res', locsec);
                this.session.currentUser = locsec.authenticated.response
                run(() => { resolve(locsec.authenticated.response) })
            }else{
                reject()
            }

        });
    }
}






