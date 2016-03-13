import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import axios from "axios";

export default {

	getVerseByReference: (ref) => {
		// http://localhost/graphql?query=query+FetchBibleVerse{bibleverses(reference:%22genesis%203:2%22){id,t,reference,url,bible_chapter_id,notes{id,body,user{username}}}}
		var URL = "/graphql?query=query+FetchBibleVerse{bibleverses(reference:\""+ref+"\"){id,t,reference,url,notes{id,body,user{username}}}}";

		dispatch({type: ActionTypes.FETCH_VERSE});

		  axios(URL).then((data) => {
			 
			  if(data.data.errors){
				dispatch({type: ActionTypes.FETCH_FAILED, data: data});
			  }else{
				dispatch({type: ActionTypes.GET_VERSE, data: data.data.data.bibleverses[0]});
			  }
		  })
	 
	}

}