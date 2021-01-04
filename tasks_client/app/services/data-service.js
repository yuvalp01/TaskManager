import Service from '@ember/service';
import ENV from '../config/environment';
import fetch from 'fetch';
import { inject as service } from '@ember/service';

export default class StoreDataService extends Service {
    url = ENV.APP.API_URL;
    @service session

    getData(endpoint, data = {}) {
        return fetch(this.url + endpoint, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${this.session.currentUser.data.token}`
            }
        })
            .then((response) => {
                return response.json();
            })
            .catch((error) => {
                return error
            });
    }

    postData(endpoint, data = {}) {
        console.log('in postData  ' + data);

        let bearer = '';
        if (this.session.currentUser) {
            console.log('in session  ' + this.session);
            bearer = `Bearer ${this.session.currentUser.data.token}`;
        }

        return fetch(this.url + endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': bearer
            },
            body: JSON.stringify(data)
        })
            .then((response) => {
                console.log(response);
                if (response.status == 200) {
                    return response.json();
                }
                else {
                    return "Return with status: " +response.status;
                }

            })
            .catch((error) => {
                return error
            });
    }

    updateData(endpoint, data = {}) {
        return fetch(this.url + endpoint, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.session.currentUser.data.token}`
            },
            body: JSON.stringify(data)
        })
            .then((response) => {
                return response.json();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    deleteData(endpoint, id) {
        return fetch(this.url + endpoint + id, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${this.session.currentUser.data.token}`
            }
        })
            .then((response) => {
                return response.json();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

}