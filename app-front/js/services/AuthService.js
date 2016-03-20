import request from 'request';
import bluebird from 'bluebird';
import AppConstants from '../constants/AppConstants';

class AuthService {

  login(email, password) {
	  
	 //  /graphql?query=mutation+UserSession{userSession(email:%22sgrjr@deliverance.me%22,password:%221230happy%22){id,email}}
	let URL = AppConstants.BASE_URL+"/graphql?query=mutation+UserSession{userSession(email:\""+email+"\",password:\""+password+"\"){id,email,token}}";
   
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
		  if(body.errors){
            return reject(body.errors);
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

    fetch(token) {
	  
	 // /graphql?query=mutation+UserSession{userSession(token:%22eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvZ3JhcGhxbCIsImlhdCI6MTQ1Nzk3MDc2MywiZXhwIjoxNDU3OTc0MzYzLCJuYmYiOjE0NTc5NzA3NjMsImp0aSI6IjBjNTMzZmZiMmIxMWQ5YmE4NDNkZGY0NzlmMmMxZDk5In0.xrrLDES_HdWTo8BPeoKbfWBCK4EEylsfdKz3oahto1I%22){id,email,token}}
	let URL = AppConstants.BASE_URL+"/graphql?query=mutation+UserSession{userSession(token:\""+token+"\"){id,email,firstname,token,gravatar,unreadNotifications{id,body}}}";

	return this.poster(URL);
	
	}

  poster(url){
	  
	  console.log(url);
	  
	    return new bluebird( (resolve, reject) => {
		  request.get(
			{
			  url: url,
			  json: true
			},
			(err, response, body) => {
			  if(err){
				return reject(err);
			  }
			  if(body.errors){
				return reject(body.errors);
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