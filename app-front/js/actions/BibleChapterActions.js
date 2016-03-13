import { dispatch, dispatchAsync } from '../dispatchers/AppDispatcher';
import ActionTypes from '../constants/ActionTypes';
import axios from "axios";

export default {
  
	keepOnlyThisChapter: (data) => {
		dispatch({type: ActionTypes.KEEP_AND_CLEAR_CHAPTER, data: data});
	},

	addChapter: (id) => {

		// /graphql?query=query+FetchBibleChapter{biblechapters(reference:%22John%203%22){id,next,orderBy,previous,reference,url,book{id,n},verses{id,v,t}}}
		var URL = "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,previous,reference,url,orderBy,book{id,n},verses{id,v,t}}}";

		dispatch({type: ActionTypes.FETCH_CHAPTER});

		  axios(URL).then((data) => {
			 dispatch({type: ActionTypes.ADD_CHAPTER, data: data.data.data.biblechapters[0]});
		  })

	},

	getChapter: (id) => {

		var URL = "/graphql?query=query+FetchBibleChapter{biblechapters(id:\""+id+"\"){id,next,orderBy,previous,reference,url,book{id,n},verses{id,v,t}}}";
		// /graphql?query=query+FetchBibleChapter{biblechapters(reference:%22John%203%22){id,next,orderBy,previous,reference,url,book{id,n},verses{id,v,t}}}

		dispatch({type: ActionTypes.FETCH_CHAPTER});

		  axios(URL).then((data) => {
			 dispatch({type: ActionTypes.GET_CHAPTER, data: data.data.data.biblechapters[0]});
		  })
	 
	},

	getChapterByReference: (ref) => {
		
		// /graphql?query=query+FetchBibleChapter{biblechapters(reference:%22John%203%22){id,next,orderBy,previous,reference,url,book{id,n},verses{id,v,t}}}
		var URL = "/graphql?query=query+FetchBibleChapter{biblechapters(reference:\""+ref+"\"){id,next,previous,orderBy,reference,url,book{id,n},verses{id,v,t}}}";

		dispatch({type: ActionTypes.FETCH_CHAPTER});

		  axios(URL).then((data) => {
			 
			  if(data.data.errors){
				dispatch({type: ActionTypes.FETCH_FAILED, data: data});
			  }else{
				dispatch({type: ActionTypes.GET_CHAPTER, data: data.data.data.biblechapters[0], searched:ref});
			  }
		  })
		 
	},

}