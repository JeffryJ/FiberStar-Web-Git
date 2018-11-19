import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import IntroTeam from './IntroTeam';
import JobPlace from './JobPlace';
import OurActivity from './OurActivity';


export default class OurTeamPage extends Component {
    constructor(props){
      super(props);
    }

    render() {
        return (
          <div>
            <IntroTeam />
            <JobPlace />
            <OurActivity />
          </div>
        );
    }
}

if (document.getElementById('our-team')) {
  //var introteam = document.getElementById('intro-team').dataset('teams');
    ReactDOM.render(<OurTeamPage /*teams={introteam}*//>, document.getElementById('our-team'));
}
