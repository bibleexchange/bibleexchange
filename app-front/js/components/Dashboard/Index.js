import React from 'react';
import BibleStore from '../../stores/BibleStore';
import Link from 'react-router/lib/Link';
import ProfileStore from '../../stores/ProfileStore';
import Promotion from './Promotion';
import SessionStore from '../../stores/SessionStore';
import ThemeSquares from '../ThemeSquares';
import SessionActionCreators from '../../actions/SessionActionCreators';
import UserNavigation from './UserNavigation';

class DashboardIndex extends React.Component {
	
    constructor(props) {
		super(props);	
		this.state = this._getState();
	}
	
	_getState() {
		return {
		  user: {
				session: SessionStore.getState(),
				profile: ProfileStore.getState()
				},
		  bible: {nav: BibleStore.nav}
		};
  }
  
 componentDidMount() {
    this.changeListener = this._onChange.bind(this);
	BibleStore.addChangeListener(this.changeListener);
    SessionStore.addChangeListener(this.changeListener);
	ProfileStore.addChangeListener(this.changeListener);
  }

   _onChange() {
    let newState = this._getState();
    this.setState(newState);
  }

  componentWillUnmount() {
	BibleStore.removeChangeListener(this.changeListener);
    SessionStore.removeChangeListener(this.changeListener);
	ProfileStore.removeChangeListener(this.changeListener);
  }
	
  render() {

	const navLinks = this.state.bible.nav.map((l)=>{
		return <Link to={l} >l</Link>;
	});
	
    return (
      <div>	  
		 <div id="sub_be_banner" className="row redBG">	
			<h1>Your place for Bible study and conversation.</h1>
		</div>
		
		<ThemeSquares />
		
		<UserNavigation nav={{bible:this.state.bible.nav}} user={this.state.user}/>
		
		<Promotion />
	</div>
    )
  }
  
}

module.exports = DashboardIndex;