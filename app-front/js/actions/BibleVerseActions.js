import dispatcher from "../dispatcher";
import axios from "axios";
import appConstants from "../constants/appConstants";

export function getVerseByReference(ref){
	console.log(" ");
	console.log(" ");
	console.log(" ");
	console.log(" ");
	console.log(" ");
	console.log(ref);
// http://localhost/graphql?query=query+FetchBibleVerse{bibleverses(reference:%22genesis%203:2%22){id,t,reference,url,bible_chapter_id,notes{id,body,user{username}}}}
var URL = "/graphql?query=query+FetchBibleVerse{bibleverses(reference:\""+ref+"\"){id,t,reference,url,notes{id,body,user{username}}}}";

dispatcher.dispatch({type: appConstants.FETCH_VERSE});

  axios(URL).then((data) => {
	 
	  if(data.data.errors){
		  dispatcher.dispatch({type: appConstants.FETCH_FAILED, data: data});
	  }else{
		dispatcher.dispatch({type: appConstants.GET_VERSE, data: data.data.data.bibleverses[0]});
	  }
  })
 
}