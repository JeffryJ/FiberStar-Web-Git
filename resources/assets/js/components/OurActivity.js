import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ActivitySlider from './ActivitySlider';


export default class OurActivity extends Component {
    constructor(props){
      super(props);

    }

    render() {

        return (
          <div className="our-activity-wrapper">
            <div className="our-activity-title mx-auto">Activities With FiberStar</div>
              <ActivitySlider />
          </div>
        );
    }
}
