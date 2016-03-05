import dispatcher from "../dispatcher";
import axios from "axios";
import appConstants from "../constants/appConstants";

export function updateSearch(input){
	dispatcher.dispatch({type: appConstants.UPDATE_SEARCH, data: input});
}