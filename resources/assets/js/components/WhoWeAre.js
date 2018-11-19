import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import AdvantageBox from './AdvantageBox';

export default class WhoWeAre extends Component {
    constructor(props){
      super(props);
    }


    render() {
        return (
          <div className="who-wrapper">
            <div className="container">
              <div className="who-desc">
                  <div className="who-title fbas">Who We Are</div>
                  {this.props.text_data}
              </div>
              <div className="adv-wrapper">
                <AdvantageBox benefits={this.props.benefits}/>
              </div>
            </div>
          </div>

        );
    }
}
