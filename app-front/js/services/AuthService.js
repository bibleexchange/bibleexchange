import request from 'request';
import bluebird from 'bluebird';
import AppConstants from '../constants/AppConstants';

class AuthService {

  login(email, password) {
	  
	 // /graphql?query=mutation+UserSession{userSession(email:%22sgrjr@deliverance.me%22,password:%221230happy%22){id,email}}
	let URL = AppConstants.BASE_URL+"graphql?query=mutation+UserSession{userSession(email:\""+email+"\",password:\""+password+"\"){id,email}}";
	  
    return new bluebird( (resolve, reject) => {
      request.get(
        {
          url: URL,
          json: true
        },
        (err, response, body) => {
          if(err){
            return reject(err);
          }
          if(response.statusCode >= 400){
            return reject(body);
          }
          return resolve(body);
        }
      );
    });
  }

  signup(username, password, extra) {
    return new bluebird( (resolve, reject) => {
      request.post(
        {
          url: AppConstants.SIGNUP_URL,
          body: {username, password, extra},
          json: true
        },
        (err, response, body) => {
          if(err){
            return reject(err);
          }
          if(response.statusCode >= 400){
            return reject(body);
          }
          return resolve(body);
        }
      );
    });
  }

}

export default new AuthService();